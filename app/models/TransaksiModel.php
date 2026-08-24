<?php

require_once "app/config/Database.php";

class TransaksiModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // =====================================================
    // READ OPERATIONS
    // =====================================================

    /**
     * Ambil semua data transaksi beserta nama kasir/pengguna
     */
    public function getAll()
    {
        $sql = "SELECT 
                    t.*,
                    p.nama
                FROM transaksi t
                JOIN pengguna p ON t.id_pengguna = p.id_pengguna
                ORDER BY t.id_transaksi DESC";

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ambil detail satu transaksi berdasarkan ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM transaksi WHERE id_transaksi = :id";

        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ambil daftar barang yang tersedia untuk transaksi
     */
    public function getBarang()
    {
        $sql = "SELECT * FROM barang WHERE status = 'Tersedia' ORDER BY nama_barang ASC";

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================================================
    // CREATE, UPDATE, DELETE OPERATIONS
    // =====================================================

    /**
     * Tambah data transaksi baru
     */
    public function create($data)
    {
        $sql = "INSERT INTO transaksi (
                    id_pengguna,
                    nama_pelanggan,
                    no_telepon,
                    jenis_transaksi,
                    total,
                    jumlah_dibayar,
                    sisa_pembayaran,
                    status_pembayaran,
                    status_transaksi,
                    metode_pembayaran,
                    tanggal_pengambilan,
                    catatan
                ) VALUES (
                    :id_pengguna,
                    :nama_pelanggan,
                    :no_telepon,
                    :jenis_transaksi,
                    :total,
                    :jumlah_dibayar,
                    :sisa_pembayaran,
                    :status_pembayaran,
                    :status_transaksi,
                    :metode_pembayaran,
                    :tanggal_pengambilan,
                    :catatan
                )";

        $query = $this->db->prepare($sql);

        $query->bindValue(':id_pengguna',         $data['id_pengguna']);
        $query->bindValue(':nama_pelanggan',      $data['nama_pelanggan']);
        $query->bindValue(':no_telepon',          !empty($data['no_telepon']) ? $data['no_telepon'] : null);
        $query->bindValue(':jenis_transaksi',     $data['jenis_transaksi']);
        $query->bindValue(':total',               $data['total']);
        $query->bindValue(':jumlah_dibayar',      $data['jumlah_dibayar']);
        $query->bindValue(':sisa_pembayaran',     $data['sisa_pembayaran']);
        $query->bindValue(':status_pembayaran',   $data['status_pembayaran']);
        $query->bindValue(':status_transaksi',    $data['status_transaksi']);
        $query->bindValue(':metode_pembayaran',   $data['metode_pembayaran']);
        $query->bindValue(':tanggal_pengambilan', !empty($data['tanggal_pengambilan']) ? $data['tanggal_pengambilan'] : null);
        $query->bindValue(':catatan',             !empty($data['catatan']) ? $data['catatan'] : null);

        $query->execute();

        return $this->db->lastInsertId();
    }

    /**
     * Update status transaksi (misal: Diproses, Selesai, Dibatalkan)
     */
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE transaksi SET status_transaksi = :status WHERE id_transaksi = :id";

        $query = $this->db->prepare($sql);
        return $query->execute([
            ':status' => $status,
            ':id'     => $id
        ]);
    }

    /**
     * Update pembayaran/pelunasan transaksi
     */
    public function pelunasan($id, $jumlah, $sisa, $status)
    {
        $sql = "UPDATE transaksi 
                SET jumlah_dibayar = :jumlah,
                    sisa_pembayaran = :sisa,
                    status_pembayaran = :status
                WHERE id_transaksi = :id";

        $query = $this->db->prepare($sql);
        return $query->execute([
            ':jumlah' => $jumlah,
            ':sisa'   => $sisa,
            ':status' => $status,
            ':id'     => $id
        ]);
    }

    /**
     * Hapus data transaksi
     */
    public function delete($id)
    {
        $sql = "DELETE FROM transaksi WHERE id_transaksi = :id";

        $query = $this->db->prepare($sql);
        return $query->execute([':id' => $id]);
    }

    /**
     * Kurangi stok barang dan ubah status jika stok habis
     */
    public function kurangiStok($id_barang, $jumlah)
    {
        // 1. Kurangi jumlah stok
        $sql = "UPDATE barang SET jumlah = jumlah - :jumlah WHERE id_barang = :id_barang";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':jumlah'    => $jumlah,
            ':id_barang' => $id_barang
        ]);

        // 2. Otomatis ubah status menjadi 'Habis' jika stok menjadi <= 0
        $sqlStatus = "UPDATE barang SET status = 'Habis' WHERE id_barang = :id_barang AND jumlah <= 0";
        $stmtStatus = $this->db->prepare($sqlStatus);
        $stmtStatus->execute([':id_barang' => $id_barang]);
    }

/**
 * Hitung total omset dari seluruh transaksi
 */
public function getTotalOmset()
{
    // Menggunakan SUM(total) agar sesuai dengan harga transaksi (175)
    $sql = "SELECT SUM(total) AS total FROM transaksi WHERE status_transaksi != 'Dibatalkan'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total'] ?? 0;
}

/**
 * Hitung total jumlah transaksi (banyaknya transaksi yang terjadi)
 */
public function getTotalTransaksi()
{
    $sql = "SELECT COUNT(*) AS total FROM transaksi WHERE status_transaksi != 'Dibatalkan'";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total'] ?? 0;
}

/**
 * Hitung total transaksi dengan jenis 'Pemesanan'
 */
public function getTotalPemesanan()
{
    $sql = "SELECT COUNT(*) AS total 
            FROM transaksi 
            WHERE jenis_transaksi = 'Pemesanan' 
              AND status_transaksi != 'Dibatalkan'";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total'] ?? 0;
}

/**
 * Ambil 5 data transaksi terbaru untuk Dashboard
 */
public function getTransaksiTerbaru($limit = 5)
{
    $sql = "SELECT * FROM transaksi ORDER BY id_transaksi DESC LIMIT :limit";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
     * Ambil data transaksi khusus yang berstatus 'Selesai' untuk laporan PDF
     */
    public function getLaporanSelesai($tglAwal = null, $tglAkhir = null)
    {
        $sql = "SELECT 
                    t.*, 
                    p.nama AS nama_kasir 
                FROM transaksi t
                LEFT JOIN pengguna p ON t.id_pengguna = p.id_pengguna
                WHERE t.status_transaksi = 'Selesai'";

        $params = [];

        // Filter opsional berdasarkan rentang tanggal
        if (!empty($tglAwal) && !empty($tglAkhir)) {
            $sql .= " AND DATE(t.tanggal_dibuat) BETWEEN :tglAwal AND :tglAkhir";
            $params[':tglAwal']  = $tglAwal;
            $params[':tglAkhir'] = $tglAkhir;
        }

        $sql .= " ORDER BY t.id_transaksi DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByFilterTanggal($tgl_awal, $tgl_akhir)
{
    $sql = "SELECT t.*, p.nama 
            FROM transaksi t
            JOIN pengguna p ON t.id_pengguna = p.id_pengguna
            WHERE DATE(t.tanggal_dibuat) BETWEEN :tgl_awal AND :tgl_akhir
            ORDER BY t.id_transaksi DESC";

    $query = $this->db->prepare($sql);
    $query->execute([
        ':tgl_awal'  => $tgl_awal,
        ':tgl_akhir' => $tgl_akhir
    ]);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
}