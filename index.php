<?php

session_start();

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'index';


switch ($controller) {

    case 'auth':
        require_once "app/controllers/AuthController.php";
        $controller = new AuthController();
        break;

    case 'dashboard':
        require_once "app/controllers/DashboardController.php";
        $controller = new DashboardController();
        break;

    case 'pengguna':
        require_once "app/controllers/PenggunaController.php";
        $controller = new PenggunaController();
        break;

    case 'kategori':
        require_once "app/controllers/KategoriController.php";
        $controller = new KategoriController();
        break;

    case 'barang':
        require_once "app/controllers/BarangController.php";
        $controller = new BarangController();
        break;

    case 'pemesanan':
        require_once "app/controllers/PemesananController.php";
        $controller = new PemesananController();
        break;

    case 'banner':
        require_once "app/controllers/BannerController.php";
        $controller = new BannerController();
        break;

    default:
        die("Controller tidak ditemukan");
}


$controller->$action();