<?php

require_once "app/config/Database.php";

class KategoriModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /* ==========================================================
     * DATA KATEGORI
     * ========================================================== */

    // Menampilkan seluruh data kategori
    public function getAll()
    {
        $query = $this->db->prepare("
            SELECT *
            FROM kategori
            ORDER BY id_kategori DESC
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Menampilkan satu data kategori berdasarkan ID
    public function getById($id_kategori)
    {
        $query = $this->db->prepare("
            SELECT *
            FROM kategori
            WHERE id_kategori = :id_kategori
        ");

        $query->bindParam(":id_kategori", $id_kategori);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /* ==========================================================
     * CRUD START
     * ========================================================== */

    // Menambah kategori
    public function create($data)
    {
        $query = $this->db->prepare("
            INSERT INTO kategori
            (
                nama_kategori,
                keterangan
            )
            VALUES
            (
                :nama_kategori,
                :keterangan
            )
        ");

        return $query->execute($data);
    }

    // Mengubah kategori
    public function update($data)
    {
        $query = $this->db->prepare("
            UPDATE kategori
            SET
                nama_kategori = :nama_kategori,
                keterangan = :keterangan
            WHERE id_kategori = :id_kategori
        ");

        return $query->execute($data);
    }

    // Menghapus kategori
    public function delete($id_kategori)
    {
        $query = $this->db->prepare("
            DELETE FROM kategori
            WHERE id_kategori = :id_kategori
        ");

        return $query->execute([
            ":id_kategori" => $id_kategori
        ]);
    }

    /* ==========================================================
     * CRUD END
     * ========================================================== */
}