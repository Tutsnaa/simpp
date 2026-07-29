<?php

require_once "app/models/PenggunaModel.php";

class PenggunaController
{
    private $penggunaModel;

    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
    }

    // Menampilkan seluruh data pengguna
    public function index()
    {
        if (!isset($_SESSION['id_pengguna'])) {

            header("Location: index.php?controller=auth&action=index");
            exit;

        }

        $pengguna = $this->penggunaModel->getAll();

        $title = "Data Pengguna";
        $content = "app/views/pengguna/index.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    // Menampilkan profil pengguna yang sedang login
    public function profil()
    {
        if (!isset($_SESSION['id_pengguna'])) {

            header("Location: index.php?controller=auth&action=index");
            exit;

        }

        $pengguna = $this->penggunaModel->getById($_SESSION['id_pengguna']);

        $foto = !empty($pengguna['foto'])
            ? "assets/img/profil/" . $pengguna['foto']
            : "assets/img/default.png";

        $title = "Profil";
        $content = "app/views/pengguna/profil.php";

        require_once "app/views/dashboard/dashboard.php";
    }
}