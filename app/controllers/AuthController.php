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
        // Pemicu otomatis: Jika belum ada data pengguna sama sekali, buatkan Admin default
        $this->cekDanBuatAdminDefault();

        require_once "app/views/login/login.php";
    }

    // Fungsi otomatis untuk memeriksa dan membuat akun admin jika tabel kosong
    private function cekDanBuatAdminDefault()
    {
        // Memeriksa apakah tabel pengguna masih kosong
        if (method_exists($this->penggunaModel, 'countAll')) {
            $totalPengguna = $this->penggunaModel->countAll();
        } else {
            // Alternatif jika method countAll belum ada di model
            $semuaPengguna = $this->penggunaModel->getAll();
            $totalPengguna = is_array($semuaPengguna) ? count($semuaPengguna) : 0;
        }

        // Jika 0 (kosong total), buatkan akun Admin default secara otomatis
        if ($totalPengguna == 0) {
            $dataAdmin = [
                "foto"          => null,
                "nama"          => "Administrator",
                "email"         => "admin@gmail.com",
                "no_telepon"    => "081234567890",
                "alamat"        => "Sistem Utama",
                "nama_pengguna" => "admin",
                "kata_sandi"    => password_hash("12345", PASSWORD_DEFAULT),
                "role"          => "Admin",
                "status"        => "Aktif"
            ];

            $this->penggunaModel->create($dataAdmin);
        }
    }

    // Proses login
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nama_pengguna = $_POST["nama_pengguna"];
            $kata_sandi    = $_POST["kata_sandi"];

            $pengguna = $this->penggunaModel->getByNamaPengguna($nama_pengguna);

            if ($pengguna && password_verify($kata_sandi, $pengguna["kata_sandi"])) {

                $_SESSION["id_pengguna"] = $pengguna["id_pengguna"];
                $_SESSION["nama"]        = $pengguna["nama"];
                $_SESSION["role"]        = $pengguna["role"];
                $_SESSION["foto"]        = $pengguna["foto"];

                header("Location: index.php?controller=dashboard&action=index");
                exit;

            } else {

                echo "<script>
                        alert('Nama pengguna atau kata sandi salah.');
                        window.location='index.php?controller=auth&action=index';
                      </script>";
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