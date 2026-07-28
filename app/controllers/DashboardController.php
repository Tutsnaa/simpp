<?php

class DashboardController
{

    public function index()
{
    if (!isset($_SESSION['id_pengguna'])) {
        header("Location: index.php?controller=auth&action=index");
        exit;
    }

    if ($_SESSION['role'] == 'Pelanggan') {

        require_once "app/views/pelanggan/beranda.php";

    } else {

        require_once "app/views/dashboard/dashboard.php";

    }
}

}