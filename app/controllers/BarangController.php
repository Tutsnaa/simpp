<?php

require_once "app/models/BarangModel.php";

class BarangController
{
    private $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    /* ==========================================================
     * HALAMAN
     * ========================================================== */

    // Menampilkan data barang
    public function index()
    {
        if (!isset($_SESSION["id_pengguna"])) {

            header("Location: index.php?controller=auth&action=index");
            exit;

        }

        $barang = $this->barangModel->getAll();

        $kategori = $this->barangModel->getKategori();

        $title = "Barang";
        $content = "app/views/barang/barang.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    /* ==========================================================
     * CRUD START
     * ========================================================== */

    // Menambah barang
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $foto = null;

            // Upload foto
            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {

                $folder = "assets/img/barang/";

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

                "id_kategori" => $_POST["id_kategori"],

                "foto" => $foto,

                "nama_barang" => $_POST["nama_barang"],

                "jumlah" => $_POST["jumlah"],

                "harga_beli" => $_POST["harga_beli"],

                "harga_jual" => $_POST["harga_jual"],

                "status" => $_POST["status"]

            ];

            $this->barangModel->create($data);

            header("Location: index.php?controller=barang&action=index");
            exit;

        }
    }

    // Mengubah barang
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $barang = $this->barangModel->getById($_POST["id_barang"]);

            $foto = $barang["foto"];

            // Upload foto baru
            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {

                $folder = "assets/img/barang/";

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

                "id_barang" => $_POST["id_barang"],

                "id_kategori" => $_POST["id_kategori"],

                "foto" => $foto,

                "nama_barang" => $_POST["nama_barang"],

                "jumlah" => $_POST["jumlah"],

                "harga_beli" => $_POST["harga_beli"],

                "harga_jual" => $_POST["harga_jual"],

                "status" => $_POST["status"]

            ];

            $this->barangModel->update($data);

            header("Location: index.php?controller=barang&action=index");
            exit;

        }
    }

    // Menghapus barang
    public function delete()
    {
        if (isset($_GET["id"])) {

            $id_barang = $_GET["id"];

            $barang = $this->barangModel->getById($id_barang);

            // Menghapus foto barang
            if (
                !empty($barang["foto"]) &&
                file_exists("assets/img/barang/" . $barang["foto"])
            ) {

                unlink("assets/img/barang/" . $barang["foto"]);

            }

            $this->barangModel->delete($id_barang);

        }

        header("Location: index.php?controller=barang&action=index");
        exit;
    }

    /* ==========================================================
     * CRUD END
     * ========================================================== */
}