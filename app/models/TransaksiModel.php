<?php


require_once "app/config/Database.php";


class TransaksiModel
{


private $db;



public function __construct()
{

    $database = new Database();

    $this->db =
    $database->connect();

}





// =====================================================
// CRUD START
// =====================================================



// ==============================
// TAMPIL DATA TRANSAKSI
// ==============================

public function getAll()
{

$query=$this->db->prepare("

SELECT 
transaksi.*,
pengguna.nama

FROM transaksi

JOIN pengguna

ON transaksi.id_pengguna=pengguna.id_pengguna

ORDER BY id_transaksi DESC

");


$query->execute();


return $query->fetchAll(PDO::FETCH_ASSOC);


}




// ==============================
// DETAIL SATU TRANSAKSI
// ==============================

public function getById($id)
{

$query=$this->db->prepare("

SELECT *

FROM transaksi

WHERE id_transaksi=:id

");


$query->execute([

":id"=>$id

]);


return $query->fetch(PDO::FETCH_ASSOC);


}





// ==============================
// TAMBAH TRANSAKSI (Model)
// ==============================
public function create($data)
{
    $query = $this->db->prepare("
        INSERT INTO transaksi (
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
        )
    ");

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



// ==============================
// UPDATE STATUS
// ==============================

public function updateStatus($id,$status)
{

$query=$this->db->prepare("

UPDATE transaksi

SET status_transaksi=:status

WHERE id_transaksi=:id

");


return $query->execute([

":status"=>$status,

":id"=>$id

]);


}




// ==============================
// PELUNASAN
// ==============================

public function pelunasan(
$id,
$jumlah,
$sisa,
$status
)
{

$query=$this->db->prepare("

UPDATE transaksi

SET

jumlah_dibayar=:jumlah,

sisa_pembayaran=:sisa,

status_pembayaran=:status


WHERE id_transaksi=:id


");


return $query->execute([


":jumlah"=>$jumlah,

":sisa"=>$sisa,

":status"=>$status,

":id"=>$id


]);


}




// ==============================
// HAPUS
// ==============================

public function delete($id)
{

$query=$this->db->prepare("

DELETE FROM transaksi

WHERE id_transaksi=:id

");


return $query->execute([

":id"=>$id

]);


}




// ==============================
// AMBIL BARANG
// ==============================

public function getBarang()
{

$query=$this->db->prepare("

SELECT *

FROM barang

WHERE status='Tersedia'

ORDER BY nama_barang ASC

");


$query->execute();


return $query->fetchAll(PDO::FETCH_ASSOC);


}




// ==============================
// KURANGI STOK
// ==============================

public function kurangiStok($id_barang, $jumlah)
{
    // 1. Kurangi jumlah stok
    $query = "UPDATE barang SET jumlah = jumlah - :jumlah WHERE id_barang = :id_barang";
    $stmt = $this->db->prepare($query);
    $stmt->execute([
        ':jumlah' => $jumlah,
        ':id_barang' => $id_barang
    ]);

    // 2. Otomatis ubah status menjadi 'Habis' jika stok menjadi <= 0
    $queryStatus = "UPDATE barang SET status = 'Habis' WHERE id_barang = :id_barang AND jumlah <= 0";
    $stmtStatus = $this->db->prepare($queryStatus);
    $stmtStatus->execute([':id_barang' => $id_barang]);
}



// =====================================================
// CRUD END
// =====================================================


}