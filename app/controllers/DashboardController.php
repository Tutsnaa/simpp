<?php

class DashboardController
{

   public function index()
{
    if (!isset($_SESSION['id_pengguna'])) {

        header("Location: index.php?controller=auth&action=index");
        exit;

    }

    $title = "Dashboard";
    $content = "app/views/dashboard/home.php"; // isi dashboard

    require_once "app/views/dashboard/dashboard.php";
}

}