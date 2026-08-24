<?php

require_once "app/models/PenggunaModel.php";

class PenggunaController
{
    private $penggunaModel;

    public function __construct()
    {
        // Pastikan session sudah aktif
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->penggunaModel = new PenggunaModel();
    }

    /* ==========================================================
     * HALAMAN
     * ========================================================== */

    // Menampilkan seluruh data pengguna
    public function index()
    {
        if (!isset($_SESSION["id_pengguna"])) {
            header("Location: index.php?controller=auth&action=index");
            exit;
        }

        $pengguna = $this->penggunaModel->getAll();

        $title = "Data Pengguna";
        $content = "app/views/data_pengguna/data_pengguna.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    // Menampilkan profil pengguna yang sedang login
    public function profil()
    {
        if (!isset($_SESSION["id_pengguna"])) {
            header("Location: index.php?controller=auth&action=index");
            exit;
        }

        $pengguna = $this->penggunaModel->getById($_SESSION["id_pengguna"]);

        $foto = !empty($pengguna["foto"])
            ? "assets/img/profil/" . $pengguna["foto"]
            : "assets/img/default.png";

        $title = "Profil";
        $content = "app/views/pengguna/profil.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    /* ==========================================================
     * CRUD START
     * ========================================================== */

    // MENAMBAH DATA PENGGUNA
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $foto = null;

            // Upload foto
            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
                $folder = "assets/img/profil/";

                if (!is_dir($folder)) {
                    mkdir($folder, 0777, true);
                }

                $ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
                $foto = time() . "_" . uniqid() . "." . $ext;

                move_uploaded_file($_FILES["foto"]["tmp_name"], $folder . $foto);
            }

            $data = [
                "foto"          => $foto,
                "nama"          => $_POST["nama"],
                "email"         => $_POST["email"],
                "no_telepon"    => $_POST["no_telepon"],
                "alamat"        => $_POST["alamat"],
                "nama_pengguna" => $_POST["nama_pengguna"],
                "kata_sandi"    => password_hash($_POST["kata_sandi"], PASSWORD_DEFAULT),
                "role"          => $_POST["role"],
                "status"        => $_POST["status"]
            ];

            $simpan = $this->penggunaModel->create($data);

            if ($simpan) {
                $_SESSION['flash_type']    = 'success';
                $_SESSION['flash_message'] = 'Data berhasil ditambahkan.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal menambahkan data pengguna.';
            }

            header("Location: index.php?controller=pengguna&action=index");
            exit;
        }
    }

    // MENGUPDATE DATA PENGGUNA
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $pengguna = $this->penggunaModel->getById($_POST["id_pengguna"]);
            $foto = $pengguna["foto"];

            // Upload foto baru
            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
                $folder = "assets/img/profil/";

                if (!is_dir($folder)) {
                    mkdir($folder, 0777, true);
                }

                // Hapus foto lama jika ada
                if (!empty($foto) && file_exists($folder . $foto)) {
                    unlink($folder . $foto);
                }

                $ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
                $foto = time() . "_" . uniqid() . "." . $ext;

                move_uploaded_file($_FILES["foto"]["tmp_name"], $folder . $foto);
            }

            $data = [
                "id_pengguna"   => $_POST["id_pengguna"],
                "foto"          => $foto,
                "nama"          => $_POST["nama"],
                "email"         => $_POST["email"],
                "no_telepon"    => $_POST["no_telepon"],
                "alamat"        => $_POST["alamat"],
                "nama_pengguna" => $_POST["nama_pengguna"],
                "kata_sandi"    => $pengguna["kata_sandi"],
                "role"          => $_POST["role"],
                "status"        => $_POST["status"]
            ];

            $update = $this->penggunaModel->update($data);

            if ($update) {
                $_SESSION['flash_type']    = 'success';
                $_SESSION['flash_message'] = 'Data berhasil diubah.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal mengubah data pengguna.';
            }

            header("Location: index.php?controller=pengguna&action=index");
            exit;
        }
    }

    // MENGHAPUS DATA PENGGUNA
    public function delete()
    {
        if (isset($_GET["id"])) {
            $delete = $this->penggunaModel->delete($_GET["id"]);

            if ($delete) {
                $_SESSION['flash_type']    = 'success';
                $_SESSION['flash_message'] = 'Data berhasil dihapus.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal menghapus data pengguna.';
            }
        }

        header("Location: index.php?controller=pengguna&action=index");
        exit;
    }

    /* ==========================================================
     * PROFIL PENGGUNA & KEAMANAN
     * ========================================================== */

    // Memperbarui profil pengguna yang sedang login
    public function updateProfil()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $pengguna = $this->penggunaModel->getById($_POST["id_pengguna"]);
            $foto = $pengguna["foto"];

            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
                $folder = "assets/img/profil/";

                if (!is_dir($folder)) {
                    mkdir($folder, 0777, true);
                }

                if (!empty($foto) && file_exists($folder . $foto)) {
                    unlink($folder . $foto);
                }

                $ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
                $foto = time() . "_" . uniqid() . "." . $ext;

                move_uploaded_file($_FILES["foto"]["tmp_name"], $folder . $foto);
            }

            $data = [
                "id_pengguna"   => $_POST["id_pengguna"],
                "foto"          => $foto,
                "nama"          => $_POST["nama"],
                "email"         => $_POST["email"],
                "no_telepon"    => $_POST["no_telepon"],
                "alamat"        => $_POST["alamat"],
                "nama_pengguna" => $_POST["nama_pengguna"]
            ];

            $update = $this->penggunaModel->updateProfil($data);

            if ($update) {
                $_SESSION["nama"] = $_POST["nama"];
                $_SESSION["foto"] = $foto;
                
                $_SESSION['flash_type']    = 'success';
                $_SESSION['flash_message'] = 'Profil berhasil diperbarui.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal memperbarui profil.';
            }

            header("Location: index.php?controller=pengguna&action=profil");
            exit;
        }
    }

    // Mengubah kata sandi pengguna
    public function ubahKataSandi()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id_pengguna = $_POST["id_pengguna"];
            $kata_sandi_lama = $_POST["password_lama"];
            $kata_sandi_baru = $_POST["password_baru"];
            $konfirmasi_kata_sandi = $_POST["konfirmasi_password"];

            $pengguna = $this->penggunaModel->getById($id_pengguna);

            // Memastikan kata sandi lama benar
            if (!password_verify($kata_sandi_lama, $pengguna["kata_sandi"])) {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Kata sandi lama salah.';
                
                header("Location: index.php?controller=pengguna&action=profil");
                exit;
            }

            // Memastikan konfirmasi kata sandi sesuai
            if ($kata_sandi_baru != $konfirmasi_kata_sandi) {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Konfirmasi kata sandi tidak sesuai.';
                
                header("Location: index.php?controller=pengguna&action=profil");
                exit;
            }

            $data = [
                "id_pengguna" => $id_pengguna,
                "kata_sandi"  => password_hash($kata_sandi_baru, PASSWORD_DEFAULT)
            ];

            $ubah = $this->penggunaModel->ubahKataSandi($data);

            if ($ubah) {
                $_SESSION['flash_type']    = 'success';
                $_SESSION['flash_message'] = 'Kata sandi berhasil diubah.';
            } else {
                $_SESSION['flash_type']    = 'danger';
                $_SESSION['flash_message'] = 'Gagal mengubah kata sandi.';
            }

            header("Location: index.php?controller=pengguna&action=profil");
            exit;
        }
    }
}