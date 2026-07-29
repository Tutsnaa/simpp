<?php

require_once "app/models/PemesananModel.php";

class PemesananController
{
    private $pemesananModel;

    public function __construct()
    {
        $this->pemesananModel = new PemesananModel();
    }

    // Menampilkan data pemesanan
    public function index()
    {
        if (!isset($_SESSION['id_pengguna'])) {

            header("Location: index.php?controller=auth&action=index");
            exit;

        }

        $pemesanan = $this->pemesananModel->getAll();

        $title = "Pemesanan";
        $content = "app/views/pemesanan/pemesanan.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    // Menambah pemesanan
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                "id_barang" => $_POST["id_barang"],
                "id_pengguna" => $_POST["id_pengguna"],
                "bukti_bayar" => $_POST["bukti_bayar"],
                "keterangan" => $_POST["keterangan"],
                "status" => $_POST["status"]
            ];

            $this->pemesananModel->create($data);

            header("Location: index.php?controller=pemesanan&action=index");
            exit;
        }
    }

    // Form edit
    public function edit()
    {
        $id_pemesanan = $_GET["id"];

        $pemesanan = $this->pemesananModel->getById($id_pemesanan);

        $title = "Edit Pemesanan";
        $content = "app/views/pemesanan/edit.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    // Update pemesanan
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                "id_pemesanan" => $_POST["id_pemesanan"],
                "id_barang" => $_POST["id_barang"],
                "id_pengguna" => $_POST["id_pengguna"],
                "bukti_bayar" => $_POST["bukti_bayar"],
                "keterangan" => $_POST["keterangan"],
                "status" => $_POST["status"]
            ];

            $this->pemesananModel->update($data);

            header("Location: index.php?controller=pemesanan&action=index");
            exit;
        }
    }

    // Hapus pemesanan
    public function delete()
    {
        $id_pemesanan = $_GET["id"];

        $this->pemesananModel->delete($id_pemesanan);

        header("Location: index.php?controller=pemesanan&action=index");
        exit;
    }
}