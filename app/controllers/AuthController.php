<?php

require_once "app/models/PenggunaModel.php";

class AuthController
{
    private $penggunaModel;

    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
    }

    // Menampilkan halaman login
    public function index()
    {
        require_once "app/views/login/login.php";
    }

    // Proses login
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nama_pengguna = $_POST["nama_pengguna"];
            $kata_sandi    = $_POST["kata_sandi"];

            $pengguna = $this->penggunaModel->getByNamaPengguna($nama_pengguna);

            if ($pengguna && $kata_sandi == $pengguna["kata_sandi"]) {

                // Session sudah dimulai di index.php,
                // jadi session_start() di sini tidak perlu.

                $_SESSION["id_pengguna"] = $pengguna["id_pengguna"];
                $_SESSION["nama"]        = $pengguna["nama"];
                $_SESSION["role"]        = $pengguna["role"];
                $_SESSION["foto"]        = $pengguna["foto"];

                header("Location: index.php?controller=dashboard&action=index");
                exit;

            }
        }
    }

    // Logout
    public function logout()
    {
        session_destroy();

        header("Location: index.php?controller=auth&action=index");
        exit;
    }
}