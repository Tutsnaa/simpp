<?php

require_once "app/models/TransaksiModel.php";

class DashboardController
{
    private $transaksiModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        if (!isset($_SESSION['id_pengguna'])) {
            header("Location: index.php?controller=auth&action=index");
            exit;
        }

        // Ambil 1 data saja: Total Omset Seluruh Transaksi
        $totalOmset = $this->transaksiModel->getTotalOmset();

        $title   = "Dashboard";
        $content = "app/views/dashboard/home.php";

        require_once "app/views/dashboard/dashboard.php";
    }
}