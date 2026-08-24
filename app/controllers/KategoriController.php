<?php

require_once "app/models/KategoriModel.php";

class KategoriController
{
    private $kategoriModel;

    public function __construct()
    {
        // Pastikan session sudah aktif
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->kategoriModel = new KategoriModel();
    }

    /* ==========================================================
     * HALAMAN
     * ========================================================== */

    public function index()
    {
        if (!isset($_SESSION["id_pengguna"])) {
            header("Location: index.php?controller=auth&action=index");
            exit;
        }

        $kategori = $this->kategoriModel->getAll();

        $title = "Data Kategori";
        $content = "app/views/kategori/kategori.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    /* ==========================================================
     * CRUD START
     * ========================================================== */

    // MENAMBAH DATA KATEGORI
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                "nama_kategori" => $_POST["nama_kategori"],
                "keterangan"    => $_POST["keterangan"] ?? null
            ];

            $simpan = $this->kategoriModel->create($data);

            if ($simpan) {
                $_SESSION['flash_type']    = 'success';
                $_SESSION['flash_message'] = 'Kategori berhasil ditambahkan.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal menambahkan kategori.';
            }

            header("Location: index.php?controller=kategori&action=index");
            exit;
        }
    }

    // MENGUPDATE DATA KATEGORI
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                "id_kategori"   => $_POST["id_kategori"],
                "nama_kategori" => $_POST["nama_kategori"],
                "keterangan"    => $_POST["keterangan"] ?? null
            ];

            $update = $this->kategoriModel->update($data);

            if ($update) {
                $_SESSION['flash_type']    = 'success';
                $_SESSION['flash_message'] = 'Kategori berhasil diubah.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal mengubah kategori.';
            }

            header("Location: index.php?controller=kategori&action=index");
            exit;
        }
    }

    // MENGHAPUS DATA KATEGORI
    public function delete()
    {
        if (isset($_GET["id"])) {
            $delete = $this->kategoriModel->delete($_GET["id"]);

            if ($delete) {
                $_SESSION['flash_type']    = 'success';
                $_SESSION['flash_message'] = 'Kategori berhasil dihapus.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal menghapus kategori.';
            }
        }

        header("Location: index.php?controller=kategori&action=index");
        exit;
    }

    /* ==========================================================
     * CRUD END
     * ========================================================== */
}