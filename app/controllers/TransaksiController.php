<?php

require_once "app/models/TransaksiModel.php";
require_once "app/models/DetailTransaksiModel.php";
require_once "app/models/BarangModel.php";

class TransaksiController
{
    private $transaksiModel;
    private $detailModel;
    private $barangModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->detailModel    = new DetailTransaksiModel();
        $this->barangModel    = new BarangModel();
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
        $barang    = $this->transaksiModel->getBarang();

        $title   = "Transaksi";
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

            $id_pengguna = $_SESSION["id_pengguna"] ?? 1;
            $jenis       = $_POST["jenis_transaksi"] ?? "Penjualan";

            $data = [
                "id_pengguna"         => $id_pengguna,
                "nama_pelanggan"      => $_POST["nama_pelanggan"] ?? "Pelanggan Umum",
                "no_telepon"          => $_POST["no_telepon"] ?? null,
                "jenis_transaksi"     => $jenis,
                "total"               => $_POST["total"] ?? 0,
                "jumlah_dibayar"      => $_POST["jumlah_dibayar"] ?? 0,
                "sisa_pembayaran"     => $_POST["sisa_pembayaran"] ?? 0,
                "status_pembayaran"   => $_POST["status_pembayaran"] ?? ($jenis == "Penjualan" ? "Lunas" : "Belum Bayar"),
                "status_transaksi"    => $_POST["status_transaksi"] ?? ($jenis == "Penjualan" ? "Selesai" : "Diproses"),
                "metode_pembayaran"   => $_POST["metode_pembayaran"] ?? "Tunai",
                "tanggal_pengambilan" => !empty($_POST["tanggal_pengambilan"]) ? $_POST["tanggal_pengambilan"] : null,
                "catatan"             => !empty($_POST["catatan"]) ? $_POST["catatan"] : null
            ];

            // 1. Simpan transaksi utama
            $id_transaksi = $this->transaksiModel->create($data);

            // 2. Simpan detail barang & kurangi stok
            if ($id_transaksi && isset($_POST["barang"]) && is_array($_POST["barang"])) {
                foreach ($_POST["barang"] as $item) {
                    $detail = [
                        "id_transaksi" => $id_transaksi,
                        "id_barang"    => $item["id_barang"],
                        "harga"        => $item["harga"],
                        "jumlah"       => $item["jumlah"],
                        "subtotal"     => $item["subtotal"]
                    ];

                    $this->detailModel->create($detail);

                    if (method_exists($this->transaksiModel, 'kurangiStok')) {
                        $this->transaksiModel->kurangiStok($item["id_barang"], $item["jumlah"]);
                    }
                }
            }

            // 3. Set pesan sukses
            $pesan_sukses = "Transaksi berhasil disimpan!";
            $barang       = $this->barangModel->getAll();
            
            require_once "app/views/transaksi/tambah_transaksi.php";
            return;
        }

        // Jika diakses via method GET
        $barang = $this->barangModel->getAll();
        require_once "app/views/transaksi/tambah_transaksi.php";
    }

    // ==============================
    // DETAIL TRANSAKSI
    // ==============================
    public function detail()
    {
        $id_transaksi = $_GET["id"];

        $transaksi = $this->transaksiModel->getById($id_transaksi);
        $detail    = $this->detailModel->getByTransaksi($id_transaksi);

        $title   = "Detail Transaksi";
        $content = "app/views/transaksi/detail.php";

        require_once "app/views/dashboard/dashboard.php";
    }

    // ==============================
    // UPDATE STATUS TRANSAKSI
    // ==============================
    public function updateStatus()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $this->transaksiModel->updateStatus(
                $_POST["id_transaksi"],
                $_POST["status_transaksi"]
            );

            header("Location: index.php?controller=transaksi&action=index");
            exit;
        }
    }

    // ==============================
    // PELUNASAN (SUDAH DISESUAIKAN DENGAN MODAL)
    // ==============================
    public function pelunasan()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $id = $_POST["id_transaksi"];
            // Menyesuaikan name input dari modal_pelunasan.php
            $bayar = $_POST["bayar_pelunasan"] ?? $_POST["jumlah_bayar"] ?? 0;
            $metode = $_POST["metode_pembayaran"] ?? "Tunai";

            $transaksi  = $this->transaksiModel->getById($id);

            $totalBayar = $transaksi["jumlah_dibayar"] + $bayar;
            $sisa       = $transaksi["total"] - $totalBayar;
            
            if ($sisa < 0) {
                $sisa = 0; // Menghindari sisa bernilai minus
            }

            $status = ($sisa <= 0) ? "Lunas" : "DP";

            // Eksekusi pelunasan di model
            if (method_exists($this->transaksiModel, 'pelunasan')) {
                $this->transaksiModel->pelunasan($id, $totalBayar, $sisa, $status);
            }

            header("Location: index.php?controller=transaksi&action=index");
            exit;
        }
    }

    // ==============================
    // HAPUS TRANSAKSI
    // ==============================
    public function delete()
    {
        $id = $_GET["id"];

        $this->detailModel->deleteByTransaksi($id);
        $this->transaksiModel->delete($id);

        header("Location: index.php?controller=transaksi&action=index");
        exit;
    }

    // =====================================================
    // HALAMAN TAMBAH TRANSAKSI KASIR
    // =====================================================
    public function tambah()
    {
        if (!isset($_SESSION['id_pengguna'])) {
            header("Location: index.php?controller=auth&action=index");
            exit;
        }

        $barang = $this->transaksiModel->getBarang();

        require_once "app/views/transaksi/tambah_transaksi.php";
    }
}