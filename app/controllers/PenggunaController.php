<?php

require_once "app/models/PenggunaModel.php";

class PenggunaController
{
    private $penggunaModel;

    public function __construct()
    {
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
        $content = "app/views/pengguna/index.php";
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

                $ext = pathinfo(
                    $_FILES["foto"]["name"],
                    PATHINFO_EXTENSION
                );

                $foto = time() . "_" . uniqid() . "." . $ext;

                move_uploaded_file(
                    $_FILES["foto"]["tmp_name"],
                    $folder . $foto
                );
            }

            $data = [

                "foto" => $foto,

                "nama" => $_POST["nama"],

                "email" => $_POST["email"],

                "no_telepon" => $_POST["no_telepon"],

                "alamat" => $_POST["alamat"],

                "nama_pengguna" => $_POST["nama_pengguna"],

                "kata_sandi" => password_hash(
                    $_POST["kata_sandi"],
                    PASSWORD_DEFAULT
                ),

                "role" => $_POST["role"],

                "status" => $_POST["status"]

            ];

            $this->penggunaModel->create($data);

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

                // Hapus foto lama
                if (!empty($foto) && file_exists($folder . $foto)) {

                    unlink($folder . $foto);

                }

                $ext = pathinfo(
                    $_FILES["foto"]["name"],
                    PATHINFO_EXTENSION
                );

                $foto = time() . "_" . uniqid() . "." . $ext;

                move_uploaded_file(
                    $_FILES["foto"]["tmp_name"],
                    $folder . $foto
                );
            }

            $data = [

                "id_pengguna" => $_POST["id_pengguna"],

                "foto" => $foto,

                "nama" => $_POST["nama"],

                "email" => $_POST["email"],

                "no_telepon" => $_POST["no_telepon"],

                "alamat" => $_POST["alamat"],

                "nama_pengguna" => $_POST["nama_pengguna"],

                // Password tetap menggunakan password lama
                "kata_sandi" => $pengguna["kata_sandi"],

                "role" => $_POST["role"],

                "status" => $_POST["status"]

            ];

            $this->penggunaModel->update($data);

            header("Location: index.php?controller=pengguna&action=index");
            exit;
        }
    }

    // MENGHAPUS DATA PENGGUNA
    public function delete()
    {
        if (isset($_GET["id"])) {

            $this->penggunaModel->delete($_GET["id"]);

        }

        header("Location: index.php?controller=pengguna&action=index");
        exit;
    }

    /* ==========================================================
     * CRUD END
     * ========================================================== */

    
    /* ==========================================================
     * PROFIL PENGGUNA
     * ========================================================== */

    // Memperbarui profil pengguna yang sedang login
    public function updateProfil()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Mengambil data pengguna
            $pengguna = $this->penggunaModel->getById($_POST["id_pengguna"]);

            $foto = $pengguna["foto"];

            // Upload foto baru
            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {

                $folder = "assets/img/profil/";

                if (!is_dir($folder)) {

                    mkdir($folder, 0777, true);

                }

                // Menghapus foto lama
                if (!empty($foto) && file_exists($folder . $foto)) {

                    unlink($folder . $foto);

                }

                $ext = pathinfo(
                    $_FILES["foto"]["name"],
                    PATHINFO_EXTENSION
                );

                $foto = time() . "_" . uniqid() . "." . $ext;

                move_uploaded_file(
                    $_FILES["foto"]["tmp_name"],
                    $folder . $foto
                );

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

            $this->penggunaModel->updateProfil($data);

            // Memperbarui session
            $_SESSION["nama"] = $_POST["nama"];
            $_SESSION["foto"] = $foto;

            echo "<script>

                    alert('Profil berhasil diperbarui.');

                    window.location='index.php?controller=pengguna&action=profil';

                  </script>";

            exit;

        }
    }

    /* ==========================================================
     * KEAMANAN AKUN
     * ========================================================== */

    // Mengubah kata sandi pengguna
    public function ubahKataSandi()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id_pengguna = $_POST["id_pengguna"];
            $kata_sandi_lama = $_POST["password_lama"];
            $kata_sandi_baru = $_POST["password_baru"];
            $konfirmasi_kata_sandi = $_POST["konfirmasi_password"];

            // Mengambil data pengguna
            $pengguna = $this->penggunaModel->getById($id_pengguna);

            // Memastikan kata sandi lama benar
            if (!password_verify($kata_sandi_lama, $pengguna["kata_sandi"])) {

                echo "<script>

                        alert('Kata sandi lama salah.');

                        window.location='index.php?controller=pengguna&action=profil';

                      </script>";

                exit;

            }

            // Memastikan konfirmasi kata sandi sesuai
            if ($kata_sandi_baru != $konfirmasi_kata_sandi) {

                echo "<script>

                        alert('Konfirmasi kata sandi tidak sesuai.');

                        window.location='index.php?controller=pengguna&action=profil';

                      </script>";

                exit;

            }

            /* -------------------------
             * UBAH KATA SANDI
             * ------------------------- */

            $data = [

                "id_pengguna" => $id_pengguna,

                "kata_sandi" => password_hash(
                    $kata_sandi_baru,
                    PASSWORD_DEFAULT
                )

            ];

            $this->penggunaModel->ubahKataSandi($data);

            echo "<script>

                    alert('Kata sandi berhasil diubah.');

                    window.location='index.php?controller=pengguna&action=profil';

                  </script>";

            exit;

        }
    }
}