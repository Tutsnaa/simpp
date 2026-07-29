<?php

require_once "app/config/Database.php";

class PemesananModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Menampilkan seluruh data pemesanan
    public function getAll()
    {
        $query = $this->db->prepare("
            SELECT
                pemesanan.*,
                barang.nama_barang,
                pengguna.nama
            FROM pemesanan
            INNER JOIN barang
                ON pemesanan.id_barang = barang.id_barang
            INNER JOIN pengguna
                ON pemesanan.id_pengguna = pengguna.id_pengguna
            ORDER BY pemesanan.id_pemesanan DESC
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Menampilkan satu pemesanan
    public function getById($id_pemesanan)
    {
        $query = $this->db->prepare("
            SELECT *
            FROM pemesanan
            WHERE id_pemesanan = :id_pemesanan
        ");

        $query->bindParam(":id_pemesanan", $id_pemesanan);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Menambah pemesanan
    public function create($data)
    {
        $query = $this->db->prepare("
            INSERT INTO pemesanan
            (
                id_barang,
                id_pengguna,
                bukti_bayar,
                keterangan,
                status
            )
            VALUES
            (
                :id_barang,
                :id_pengguna,
                :bukti_bayar,
                :keterangan,
                :status
            )
        ");

        return $query->execute($data);
    }

    // Mengubah pemesanan
    public function update($data)
    {
        $query = $this->db->prepare("
            UPDATE pemesanan
            SET
                id_barang = :id_barang,
                id_pengguna = :id_pengguna,
                bukti_bayar = :bukti_bayar,
                keterangan = :keterangan,
                status = :status
            WHERE id_pemesanan = :id_pemesanan
        ");

        return $query->execute($data);
    }

    // Menghapus pemesanan
    public function delete($id_pemesanan)
    {
        $query = $this->db->prepare("
            DELETE FROM pemesanan
            WHERE id_pemesanan = :id_pemesanan
        ");

        return $query->execute([
            ":id_pemesanan" => $id_pemesanan
        ]);
    }
}