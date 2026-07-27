<?php

class BerandaController
{

    public function index()
    {
        if (!isset($_SESSION['id_pengguna'])) {

            header("Location: index.php?controller=auth&action=index");
            exit;

        }

        require_once "app/views/beranda/beranda.php";
    }

}