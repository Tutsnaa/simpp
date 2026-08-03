<?php

require_once "app/models/TransaksiModel.php";
require_once "app/models/DetailTransaksiModel.php";


class TransaksiController
{

    private $transaksiModel;
    private $detailModel;


    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();

        $this->detailModel = new DetailTransaksiModel();
    }



    // =====================================================
    // HALAMAN TRANSAKSI
    // =====================================================

    public function index()
    {

        if (!isset($_SESSION['id_pengguna'])) {

            header("Location: index.php?controller=auth&action=index");
            exit;

        }


        $transaksi = $this->transaksiModel->getAll();

        $barang = $this->transaksiModel->getBarang();


        $title = "Transaksi";

        $content = "app/views/transaksi/transaksi.php";


        require_once "app/views/dashboard/dashboard.php";

    }





    // =====================================================
    // CRUD START
    // =====================================================



    // ==============================
    // TAMBAH TRANSAKSI
    // ==============================

    public function create()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            $data = [


                "id_pengguna" => $_SESSION["id_pengguna"],


                "nama_pelanggan" => $_POST["nama_pelanggan"],


                "no_telepon" => $_POST["no_telepon"],


                "jenis_transaksi" => $_POST["jenis_transaksi"],


                "total" => $_POST["total"],


                "jumlah_dibayar" => $_POST["jumlah_dibayar"],


                "sisa_pembayaran" => $_POST["sisa_pembayaran"],


                "status_pembayaran" => $_POST["status_pembayaran"],


                "status_transaksi" => "Diproses",


                "metode_pembayaran" => $_POST["metode_pembayaran"],


                "tanggal_pengambilan" => $_POST["tanggal_pengambilan"],


                "catatan" => $_POST["catatan"]

            ];



            // simpan transaksi utama

            $id_transaksi = $this->transaksiModel->create($data);



            // simpan detail barang

            foreach ($_POST["barang"] as $item) {


                $detail = [


                    "id_transaksi" => $id_transaksi,


                    "id_barang" => $item["id_barang"],


                    "harga" => $item["harga"],


                    "jumlah" => $item["jumlah"],


                    "subtotal" => $item["subtotal"]


                ];


                $this->detailModel->create($detail);



                // kurangi stok

                $this->transaksiModel->kurangiStok(
                    $item["id_barang"],
                    $item["jumlah"]
                );

            }



            header(
                "Location: index.php?controller=transaksi&action=index"
            );

            exit;

        }

    }





    // ==============================
    // DETAIL TRANSAKSI
    // ==============================

    public function detail()
    {


        $id_transaksi = $_GET["id"];



        $transaksi =
            $this->transaksiModel
            ->getById($id_transaksi);



        $detail =
            $this->detailModel
            ->getByTransaksi($id_transaksi);



        $title = "Detail Transaksi";


        $content =
        "app/views/transaksi/detail.php";



        require_once
        "app/views/dashboard/dashboard.php";

    }





    // ==============================
    // UPDATE STATUS TRANSAKSI
    // ==============================

    public function updateStatus()
    {


        if ($_SERVER["REQUEST_METHOD"]=="POST") {


            $this->transaksiModel->updateStatus(

                $_POST["id_transaksi"],

                $_POST["status_transaksi"]

            );


            header(
                "Location:index.php?controller=transaksi&action=index"
            );

            exit;

        }

    }





    // ==============================
    // PELUNASAN
    // ==============================

    public function pelunasan()
    {


        if($_SERVER["REQUEST_METHOD"]=="POST"){


            $id =
            $_POST["id_transaksi"];



            $bayar =
            $_POST["jumlah_bayar"];



            $transaksi =
            $this->transaksiModel
            ->getById($id);



            $totalBayar =
            $transaksi["jumlah_dibayar"] + $bayar;



            $sisa =
            $transaksi["total"] - $totalBayar;



            $status =
            ($sisa <= 0)
            ? "Lunas"
            : "DP";



            $this->transaksiModel
            ->pelunasan(

                $id,

                $totalBayar,

                $sisa,

                $status

            );



            header(
                "Location:index.php?controller=transaksi&action=index"
            );

            exit;

        }


    }





    // ==============================
    // HAPUS TRANSAKSI
    // ==============================

    public function delete()
    {


        $id =
        $_GET["id"];



        $this->detailModel
        ->deleteByTransaksi($id);



        $this->transaksiModel
        ->delete($id);



        header(
            "Location:index.php?controller=transaksi&action=index"
        );

        exit;

    }



    // =====================================================
    // CRUD END
    // =====================================================


    // ===============================
// HALAMAN TAMBAH TRANSAKSI KASIR
// ===============================

public function tambah()
{

    if(!isset($_SESSION['id_pengguna'])){

        header(
            "Location:index.php?controller=auth&action=index"
        );

        exit;

    }


    $barang = $this->transaksiModel->getBarang();


    require_once "app/views/transaksi/tambah_transaksi.php";

}

}