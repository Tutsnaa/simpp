<?php

session_start();

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'index';


switch ($controller) {

    case 'auth':
        require_once "app/controllers/AuthController.php";
        $controller = new AuthController();
        break;


    case 'beranda':
        require_once "app/controllers/BerandaController.php";
        $controller = new BerandaController();
        break;


    default:
        die("Controller tidak ditemukan");
}


$controller->$action();