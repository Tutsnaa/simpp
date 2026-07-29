<?php

require_once "app/models/BarangModel.php";

class BarangController
{
    private $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    // Menampilkan data barang
    public function index()
    {
        if (!isset($_SESSION['id_pengguna'])) {

            header("Location: index.php?controller=auth&action=index");
            exit;

        }

        $barang = $this->barangModel->getAll();

        $title = "Barang";
        $content = "app/views/barang/barang.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    // Menyimpan barang
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                'id_kategori' => $_POST['id_kategori'],
                'foto' => $_POST['foto'],
                'nama_barang' => $_POST['nama_barang'],
                'jumlah' => $_POST['jumlah'],
                'harga_beli' => $_POST['harga_beli'],
                'harga_jual' => $_POST['harga_jual'],
                'status' => $_POST['status']
            ];

            $this->barangModel->create($data);

            header("Location: index.php?controller=barang&action=index");
            exit;

        }
    }

    // Form edit
    public function edit()
    {
        $id_barang = $_GET['id'];

        $barang = $this->barangModel->getById($id_barang);

        $title = "Edit Barang";
        $content = "app/views/barang/edit.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    // Update barang
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $data = [
                'id_barang' => $_POST['id_barang'],
                'id_kategori' => $_POST['id_kategori'],
                'foto' => $_POST['foto'],
                'nama_barang' => $_POST['nama_barang'],
                'jumlah' => $_POST['jumlah'],
                'harga_beli' => $_POST['harga_beli'],
                'harga_jual' => $_POST['harga_jual'],
                'status' => $_POST['status']
            ];

            $this->barangModel->update($data);

            header("Location: index.php?controller=barang&action=index");
            exit;

        }
    }

    // Hapus barang
    public function delete()
    {
        $id_barang = $_GET['id'];

        $this->barangModel->delete($id_barang);

        header("Location: index.php?controller=barang&action=index");
        exit;
    }
}