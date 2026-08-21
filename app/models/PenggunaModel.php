<?php

require_once "app/config/Database.php";

class PenggunaModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /* ==========================================================
     * DATA PENGGUNA
     * ========================================================== */

    // Menampilkan seluruh data pengguna
    public function getAll()
    {
        $query = $this->db->prepare("
            SELECT *
            FROM pengguna
            ORDER BY id_pengguna DESC
        ");

        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Menampilkan satu data pengguna berdasarkan ID
    public function getById($id_pengguna)
    {
        $query = $this->db->prepare("
            SELECT *
            FROM pengguna
            WHERE id_pengguna = :id_pengguna
        ");

        $query->bindParam(":id_pengguna", $id_pengguna);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Mencari pengguna berdasarkan nama pengguna (untuk login)
    public function getByNamaPengguna($nama_pengguna)
    {
        $query = $this->db->prepare("
            SELECT *
            FROM pengguna
            WHERE nama_pengguna = :nama_pengguna
            AND status = 'Aktif'
            LIMIT 1
        ");

        $query->bindParam(":nama_pengguna", $nama_pengguna);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /* ==========================================================
     * CRUD START
     * ========================================================== */

    // Menambah pengguna
    public function create($data)
    {
        $query = $this->db->prepare("
            INSERT INTO pengguna
            (
                foto,
                nama,
                email,
                no_telepon,
                alamat,
                nama_pengguna,
                kata_sandi,
                role,
                status
            )
            VALUES
            (
                :foto,
                :nama,
                :email,
                :no_telepon,
                :alamat,
                :nama_pengguna,
                :kata_sandi,
                :role,
                :status
            )
        ");

        return $query->execute($data);
    }

    // Mengubah pengguna
    public function update($data)
    {
        $query = $this->db->prepare("
            UPDATE pengguna
            SET
                foto = :foto,
                nama = :nama,
                email = :email,
                no_telepon = :no_telepon,
                alamat = :alamat,
                nama_pengguna = :nama_pengguna,
                kata_sandi = :kata_sandi,
                role = :role,
                status = :status
            WHERE id_pengguna = :id_pengguna
        ");

        return $query->execute($data);
    }

    // Menghapus pengguna
    public function delete($id_pengguna)
    {
        $query = $this->db->prepare("
            DELETE FROM pengguna
            WHERE id_pengguna = :id_pengguna
        ");

        return $query->execute([
            ":id_pengguna" => $id_pengguna
        ]);
    }

    /* ==========================================================
     * CRUD END
     * ========================================================== */


    /* ==========================================================
     * PROFIL PENGGUNA
     * ========================================================== */

    // Mengubah profil pengguna
    public function updateProfil($data)
    {
        $query = $this->db->prepare("
            UPDATE pengguna
            SET
                foto = :foto,
                nama = :nama,
                email = :email,
                no_telepon = :no_telepon,
                alamat = :alamat,
                nama_pengguna = :nama_pengguna
            WHERE id_pengguna = :id_pengguna
        ");

        return $query->execute($data);
    }


    /* ==========================================================
     * KEAMANAN AKUN
     * ========================================================== */

    // Mengubah kata sandi pengguna
    public function ubahKataSandi($data)
    {
        $query = $this->db->prepare("
            UPDATE pengguna
            SET
                kata_sandi = :kata_sandi
            WHERE id_pengguna = :id_pengguna
        ");

        return $query->execute($data);
    }
}