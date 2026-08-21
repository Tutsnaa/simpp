<?php

require_once "app/models/KategoriModel.php";

class KategoriController
{
    private $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    /* ==========================================================
     * HALAMAN
     * ========================================================== */

    // Menampilkan data kategori
    public function index()
    {
        if (!isset($_SESSION["id_pengguna"])) {

            header("Location: index.php?controller=auth&action=index");
            exit;

        }

        $kategori = $this->kategoriModel->getAll();

        $title = "Kategori";
        $content = "app/views/kategori/kategori.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    /* ==========================================================
     * CRUD START
     * ========================================================== */

    // Menambah kategori
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [

                "nama_kategori" => $_POST["nama_kategori"],

                "keterangan" => $_POST["keterangan"]

            ];

            $this->kategoriModel->create($data);

            header("Location: index.php?controller=kategori&action=index");
            exit;

        }
    }

    // Mengubah kategori
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [

                "id_kategori" => $_POST["id_kategori"],

                "nama_kategori" => $_POST["nama_kategori"],

                "keterangan" => $_POST["keterangan"]

            ];

            $this->kategoriModel->update($data);

            header("Location: index.php?controller=kategori&action=index");
            exit;

        }
    }

    // Menghapus kategori
    public function delete()
    {
        if (isset($_GET["id"])) {

            $this->kategoriModel->delete($_GET["id"]);

        }

        header("Location: index.php?controller=kategori&action=index");
        exit;
    }

    /* ==========================================================
     * CRUD END
     * ========================================================== */
}