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
// TAMBAH TRANSAKSI
// ==============================

public function create($data)
{


$query=$this->db->prepare("

INSERT INTO transaksi

(
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

)

VALUES

(
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



$query->execute($data);



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

public function kurangiStok($id_barang,$jumlah)
{


$query=$this->db->prepare("

UPDATE barang

SET jumlah = jumlah - :jumlah

WHERE id_barang=:id

");


return $query->execute([


":jumlah"=>$jumlah,

":id"=>$id_barang


]);


}


// =====================================================
// CRUD END
// =====================================================


}