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
        require_once "app/views/login/Login.php";
    }


    // Proses login
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nama_pengguna = $_POST["nama_pengguna"];
            $kata_sandi = $_POST["kata_sandi"];


            $pengguna = $this->penggunaModel->getByNamaPengguna($nama_pengguna);


            if ($pengguna && $kata_sandi == $pengguna["kata_sandi"]) {

                session_start();

                $_SESSION["id_pengguna"] = $pengguna["id_pengguna"];
                $_SESSION["nama"] = $pengguna["nama"];
                $_SESSION["role"] = $pengguna["role"];


                header("Location: index.php?controller=beranda&action=index");
                exit;

            } else {

                echo "Nama pengguna atau kata sandi salah.";

            }
        }
    }


    // Logout
    public function logout()
    {
        session_start();

        session_destroy();

        header("Location: index.php?controller=auth&action=index");
        exit;
    }
}