<?php

require_once "app/config/Database.php";

class BannerModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Menampilkan seluruh banner
    public function getAll()
    {
        $query = $this->db->prepare("
            SELECT *
            FROM banner
            ORDER BY id_banner DESC
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Menampilkan satu banner
    public function getById($id_banner)
    {
        $query = $this->db->prepare("
            SELECT *
            FROM banner
            WHERE id_banner = :id_banner
        ");

        $query->bindParam(":id_banner", $id_banner);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Menambah banner
    public function create($data)
    {
        $query = $this->db->prepare("
            INSERT INTO banner
            (
                judul,
                keterangan,
                gambar,
                status
            )
            VALUES
            (
                :judul,
                :keterangan,
                :gambar,
                :status
            )
        ");

        return $query->execute($data);
    }

    // Mengubah banner
    public function update($data)
    {
        $query = $this->db->prepare("
            UPDATE banner
            SET
                judul = :judul,
                keterangan = :keterangan,
                gambar = :gambar,
                status = :status
            WHERE id_banner = :id_banner
        ");

        return $query->execute($data);
    }

    // Menghapus banner
    public function delete($id_banner)
    {
        $query = $this->db->prepare("
            DELETE FROM banner
            WHERE id_banner = :id_banner
        ");

        return $query->execute([
            ":id_banner" => $id_banner
        ]);
    }
}