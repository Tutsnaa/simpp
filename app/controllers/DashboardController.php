<?php

require_once "app/models/TransaksiModel.php";
require_once "app/models/BarangModel.php";

class DashboardController
{
    private $transaksiModel;
    private $barangModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->barangModel    = new BarangModel();
    }

    public function index()
    {
        if (!isset($_SESSION['id_pengguna'])) {
            header("Location: index.php?controller=auth&action=index");
            exit;
        }


        //TRANSAKSI
        // 1. Ambil Total Omset (Nilai Belanja)
        $totalOmset = $this->transaksiModel->getTotalOmset();

        // 2. Ambil Total Banyaknya Transaksi
        $totalTransaksi = $this->transaksiModel->getTotalTransaksi();

        // 3. Ambil Total Jenis Transaksi Pemesanan
        $totalPemesanan = $this->transaksiModel->getTotalPemesanan();

        // 4. Ambil 5 Transaksi Terbaru
        $transaksiTerbaru = $this->transaksiModel->getTransaksiTerbaru(5);

        //BARANG
        // 1. Ambil Total Jumlah Barang
        $totalBarang    = $this->barangModel->getTotalBarang();
        // 2. Ambil 5 Barang Stok Menipis
        $stokMenipis = $this->barangModel->getStokMenipis();

        $title   = "Dashboard";
        $content = "app/views/dashboard/home.php";

        require_once "app/views/dashboard/dashboard.php";
    }
}