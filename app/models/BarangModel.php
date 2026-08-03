<?php

require_once "app/config/Database.php";

class BarangModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /* ==========================================================
     * DATA BARANG
     * ========================================================== */

    // Menampilkan seluruh data barang
    public function getAll()
    {
        $query = $this->db->prepare("
            SELECT
                barang.*,
                kategori.nama_kategori
            FROM barang
            INNER JOIN kategori
                ON barang.id_kategori = kategori.id_kategori
            ORDER BY barang.id_barang DESC
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Menampilkan satu data barang berdasarkan ID
    public function getById($id_barang)
    {
        $query = $this->db->prepare("
            SELECT *
            FROM barang
            WHERE id_barang = :id_barang
        ");

        $query->bindParam(":id_barang", $id_barang);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /* ==========================================================
     * CRUD START
     * ========================================================== */

    // Menambah barang
    public function create($data)
    {
        $query = $this->db->prepare("
            INSERT INTO barang
            (
                id_kategori,
                foto,
                nama_barang,
                jumlah,
                harga_beli,
                harga_jual,
                status
            )
            VALUES
            (
                :id_kategori,
                :foto,
                :nama_barang,
                :jumlah,
                :harga_beli,
                :harga_jual,
                :status
            )
        ");

        return $query->execute($data);
    }

    // Mengubah barang
    public function update($data)
    {
        $query = $this->db->prepare("
            UPDATE barang
            SET
                id_kategori = :id_kategori,
                foto = :foto,
                nama_barang = :nama_barang,
                jumlah = :jumlah,
                harga_beli = :harga_beli,
                harga_jual = :harga_jual,
                status = :status
            WHERE id_barang = :id_barang
        ");

        return $query->execute($data);
    }

    // Menghapus barang
    public function delete($id_barang)
    {
        $query = $this->db->prepare("
            DELETE FROM barang
            WHERE id_barang = :id_barang
        ");

        return $query->execute([
            ":id_barang" => $id_barang
        ]);
    }

    /* ==========================================================
     * CRUD END
     * ========================================================== */


    /* ==========================================================
     * DATA KATEGORI
     * ========================================================== */

    // Menampilkan seluruh kategori
    public function getKategori()
    {
        $query = $this->db->prepare("
            SELECT *
            FROM kategori
            ORDER BY nama_kategori ASC
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}