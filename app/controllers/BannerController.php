<?php

require_once "app/models/BannerModel.php";

class BannerController
{
    private $bannerModel;

    public function __construct()
    {
        $this->bannerModel = new BannerModel();
    }

    // Menampilkan data banner
    public function index()
    {
        if (!isset($_SESSION['id_pengguna'])) {

            header("Location: index.php?controller=auth&action=index");
            exit;

        }

        $banner = $this->bannerModel->getAll();

        $title = "Banner";
        $content = "app/views/banner/banner.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    // Menambah banner
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                "judul" => $_POST["judul"],
                "keterangan" => $_POST["keterangan"],
                "gambar" => $_POST["gambar"],
                "status" => $_POST["status"]
            ];

            $this->bannerModel->create($data);

            header("Location: index.php?controller=banner&action=index");
            exit;
        }
    }

    // Menampilkan form edit
    public function edit()
    {
        $id_banner = $_GET["id"];

        $banner = $this->bannerModel->getById($id_banner);

        $title = "Edit Banner";
        $content = "app/views/banner/edit.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    // Mengubah banner
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                "id_banner" => $_POST["id_banner"],
                "judul" => $_POST["judul"],
                "keterangan" => $_POST["keterangan"],
                "gambar" => $_POST["gambar"],
                "status" => $_POST["status"]
            ];

            $this->bannerModel->update($data);

            header("Location: index.php?controller=banner&action=index");
            exit;
        }
    }

    // Menghapus banner
    public function delete()
    {
        $id_banner = $_GET["id"];

        $this->bannerModel->delete($id_banner);

        header("Location: index.php?controller=banner&action=index");
        exit;
    }
}