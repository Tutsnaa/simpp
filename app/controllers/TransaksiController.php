<?php

require_once "app/models/TransaksiModel.php";
require_once "app/models/DetailTransaksiModel.php";
require_once "app/models/BarangModel.php";

class TransaksiController
{
    private $transaksiModel;
    private $detailModel;
    private $barangModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->transaksiModel = new TransaksiModel();
        $this->detailModel    = new DetailTransaksiModel();
        $this->barangModel    = new BarangModel();
    }

    // =====================================================
    // HALAMAN TRANSAKSI
    // =====================================================
    public function index()
    {
        if (!isset($_SESSION['id_pengguna'])) {
            header("Location: index.php?controller=auth&action=index");
            exit;
        }

        $transaksi = $this->transaksiModel->getAll();
        $barang    = $this->barangModel->getAll();

        $title   = "Transaksi";
        $content = "app/views/transaksi/transaksi.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    // =====================================================
    // CRUD START
    // =====================================================

    // ==============================
    // TAMBAH TRANSAKSI
    // ==============================
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // VALIDASI STOK SISI SERVER
            if (isset($_POST["barang"]) && is_array($_POST["barang"])) {
                foreach ($_POST["barang"] as $item) {
                    $dataBarang = $this->barangModel->getById($item["id_barang"]);
                    $stokTersedia = $dataBarang['jumlah'] ?? 0;

                    // Jika jumlah dipesan melebihi stok yang ada
                    if ($item["jumlah"] > $stokTersedia) {
                        $pesan_error = "Transaksi gagal! Stok barang '" . ($dataBarang['nama_barang'] ?? 'Produk') . "' tidak mencukupi (Sisa stok: {$stokTersedia}).";
                        
                        $_SESSION['flash_type']    = 'danger';
                        $_SESSION['flash_message'] = $pesan_error;

                        $barang = $this->barangModel->getAll();
                        require_once "app/views/transaksi/tambah_transaksi.php";
                        return;
                    }
                }
            } else {
                $pesan_error = "Keranjang belanja masih kosong!";
                
                $_SESSION['flash_type']    = 'warning';
                $_SESSION['flash_message'] = $pesan_error;

                $barang = $this->barangModel->getAll();
                require_once "app/views/transaksi/tambah_transaksi.php";
                return;
            }

            $id_pengguna = $_SESSION["id_pengguna"] ?? 1;
            $jenis       = $_POST["jenis_transaksi"] ?? "Penjualan";

            $data = [
                "id_pengguna"         => $id_pengguna,
                "nama_pelanggan"      => $_POST["nama_pelanggan"] ?? "Pelanggan Umum",
                "no_telepon"          => $_POST["no_telepon"] ?? null,
                "jenis_transaksi"     => $jenis,
                "total"               => $_POST["total"] ?? 0,
                "jumlah_dibayar"      => $_POST["jumlah_dibayar"] ?? 0,
                "sisa_pembayaran"     => $_POST["sisa_pembayaran"] ?? 0,
                "status_pembayaran"   => $_POST["status_pembayaran"] ?? ($jenis == "Penjualan" ? "Lunas" : "Belum Bayar"),
                "status_transaksi"    => $_POST["status_transaksi"] ?? ($jenis == "Penjualan" ? "Selesai" : "Diproses"),
                "metode_pembayaran"   => $_POST["metode_pembayaran"] ?? "Tunai",
                "tanggal_pengambilan" => !empty($_POST["tanggal_pengambilan"]) ? $_POST["tanggal_pengambilan"] : null,
                "catatan"             => !empty($_POST["catatan"]) ? $_POST["catatan"] : null
            ];

            // 1. Simpan transaksi utama
            $id_transaksi = $this->transaksiModel->create($data);

            // 2. Simpan detail barang & kurangi stok
            if ($id_transaksi) {
                foreach ($_POST["barang"] as $item) {
                    $detail = [
                        "id_transaksi" => $id_transaksi,
                        "id_barang"    => $item["id_barang"],
                        "harga"        => $item["harga"],
                        "jumlah"       => $item["jumlah"],
                        "subtotal"     => $item["subtotal"]
                    ];

                    $this->detailModel->create($detail);

                    // Pengurangan stok barang
                    if (method_exists($this->transaksiModel, 'kurangiStok')) {
                        $this->transaksiModel->kurangiStok($item["id_barang"], $item["jumlah"]);
                    } elseif (method_exists($this->barangModel, 'kurangiStok')) {
                        $this->barangModel->kurangiStok($item["id_barang"], $item["jumlah"]);
                    }
                }

            //     $_SESSION['flash_type']    = 'success';
            //     $_SESSION['flash_message'] = 'Transaksi berhasil disimpan!';
            //     $pesan_sukses = 'Transaksi berhasil disimpan!';
            // } else {
            //     $_SESSION['flash_type']    = 'danger';
            //     $_SESSION['flash_message'] = 'Gagal menyimpan transaksi.';
            //     $pesan_error = 'Gagal menyimpan transaksi.';
            }

            // 3. Ambil data barang terbaru
            $barang = $this->barangModel->getAll();
            
            require_once "app/views/transaksi/tambah_transaksi.php";
            return;
        }

        // Jika diakses via method GET
        $barang = $this->barangModel->getAll();
        require_once "app/views/transaksi/tambah_transaksi.php";
    }

    // ==============================
    // DETAIL TRANSAKSI
    // ==============================
    public function detail()
    {
        $id_transaksi = $_GET["id"];

        $transaksi = $this->transaksiModel->getById($id_transaksi);
        $detail    = $this->detailModel->getByTransaksi($id_transaksi);

        $title   = "Detail Transaksi";
        $content = "app/views/transaksi/detail.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    // ==============================
    // UPDATE STATUS TRANSAKSI
    // ==============================
    public function updateStatus()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $update = $this->transaksiModel->updateStatus(
                $_POST["id_transaksi"],
                $_POST["status_transaksi"]
            );

            if ($update) {
                $_SESSION['flash_type']    = 'success';
                $_SESSION['flash_message'] = 'Status transaksi berhasil diperbarui.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal memperbarui status transaksi.';
            }

            header("Location: index.php?controller=transaksi&action=index");
            exit;
        }
    }

    // ==============================
    // PELUNASAN (SUDAH DISESUAIKAN DENGAN MODAL)
    // ==============================
    public function pelunasan()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id     = $_POST["id_transaksi"];
            $bayar  = $_POST["bayar_pelunasan"] ?? $_POST["jumlah_bayar"] ?? 0;
            $metode = $_POST["metode_pembayaran"] ?? "Tunai";

            $transaksi  = $this->transaksiModel->getById($id);

            $totalBayar = $transaksi["jumlah_dibayar"] + $bayar;
            $sisa       = $transaksi["total"] - $totalBayar;
            
            if ($sisa < 0) {
                $sisa = 0;
            }

            $status = ($sisa <= 0) ? "Lunas" : "DP";

            if (method_exists($this->transaksiModel, 'pelunasan')) {
                $this->transaksiModel->pelunasan($id, $totalBayar, $sisa, $status);
                
                $_SESSION['flash_type']    = 'success';
                $_SESSION['flash_message'] = 'Pembayaran pelunasan berhasil diproses.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal memproses pelunasan.';
            }

            header("Location: index.php?controller=transaksi&action=index");
            exit;
        }
    }

    // ==============================
    // HAPUS TRANSAKSI
    // ==============================
    public function delete()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            $this->detailModel->deleteByTransaksi($id);
            $hapus = $this->transaksiModel->delete($id);

            if ($hapus) {
                $_SESSION['flash_type']    = 'success';
                $_SESSION['flash_message'] = 'Data transaksi berhasil dihapus.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal menghapus data transaksi.';
            }
        }

        header("Location: index.php?controller=transaksi&action=index");
        exit;
    }

    // ==============================
    // BATAL TRANSAKSI
    // ==============================
    public function batal()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            // 1. Ambil detail barang dari transaksi ini
            $detailItems = $this->detailModel->getByTransaksi($id);

            // 2. Kembalikan stok barang yang dibatalkan
            if (!empty($detailItems)) {
                foreach ($detailItems as $item) {
                    $id_barang = $item['id_barang'];
                    $jumlah    = $item['jumlah'];

                    // Panggil fungsi tambahStok pada BarangModel
                    if (method_exists($this->barangModel, 'tambahStok')) {
                        $this->barangModel->tambahStok($id_barang, $jumlah);
                    }
                }
            }

            // 3. Ubah status transaksi menjadi 'Dibatalkan'
            $updated = $this->transaksiModel->updateStatus($id, 'Dibatalkan');

            if ($updated) {
                $_SESSION['flash_type']    = 'warning';
                $_SESSION['flash_message'] = 'Transaksi berhasil dibatalkan dan stok barang telah dikembalikan.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal memproses pembatalan transaksi.';
            }
        }

        header("Location: index.php?controller=transaksi&action=index");
        exit;
    }

    // =====================================================
    // HALAMAN TAMBAH TRANSAKSI KASIR
    // =====================================================
    public function tambah()
    {
        if (!isset($_SESSION['id_pengguna'])) {
            header("Location: index.php?controller=auth&action=index");
            exit;
        }

        $barang = $this->barangModel->getAll();

        require_once "app/views/transaksi/tambah_transaksi.php";
    }

    public function cetakLaporanPdf()
    {
        $tglAwal  = $_GET['tgl_awal'] ?? null;
        $tglAkhir = $_GET['tgl_akhir'] ?? null;

        $transaksiModel = new TransaksiModel();
        $dataTransaksi  = $transaksiModel->getLaporanSelesai($tglAwal, $tglAkhir);

        require_once "app/views/transaksi/cetak_pdf.php";
    }

    
}