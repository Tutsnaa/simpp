<?php

require_once "app/config/Database.php";


class DetailTransaksiModel
{

    private $db;


    public function __construct()
    {

        $database = new Database();

        $this->db = $database->connect();

    }



    // =====================================================
    // CRUD START
    // =====================================================



    // ==============================
    // TAMPIL DETAIL BERDASARKAN TRANSAKSI
    // ==============================

    public function getByTransaksi($id_transaksi)
    {

        $query = $this->db->prepare("

            SELECT

                detail_transaksi.*,

                barang.nama_barang,

                barang.foto


            FROM detail_transaksi


            INNER JOIN barang

            ON detail_transaksi.id_barang = barang.id_barang


            WHERE detail_transaksi.id_transaksi = :id_transaksi


            ORDER BY detail_transaksi.id_detail_transaksi ASC


        ");


        $query->execute([

            ":id_transaksi" => $id_transaksi

        ]);


        return $query->fetchAll(PDO::FETCH_ASSOC);

    }





    // ==============================
    // TAMBAH DETAIL TRANSAKSI
    // ==============================

    public function create($data)
    {

        $query = $this->db->prepare("

            INSERT INTO detail_transaksi

            (

                id_transaksi,

                id_barang,

                harga,

                jumlah,

                subtotal

            )


            VALUES

            (

                :id_transaksi,

                :id_barang,

                :harga,

                :jumlah,

                :subtotal

            )


        ");


        return $query->execute($data);


    }





    // ==============================
    // UBAH DETAIL TRANSAKSI
    // ==============================

    public function update($data)
    {

        $query = $this->db->prepare("

            UPDATE detail_transaksi


            SET

                id_barang = :id_barang,

                harga = :harga,

                jumlah = :jumlah,

                subtotal = :subtotal


            WHERE id_detail_transaksi = :id_detail_transaksi


        ");


        return $query->execute($data);


    }





    // ==============================
    // HAPUS DETAIL SATU ITEM
    // ==============================

    public function delete($id_detail_transaksi)
    {

        $query = $this->db->prepare("

            DELETE FROM detail_transaksi


            WHERE id_detail_transaksi = :id_detail_transaksi


        ");


        return $query->execute([

            ":id_detail_transaksi" => $id_detail_transaksi

        ]);

    }





    // ==============================
    // HAPUS SEMUA DETAIL TRANSAKSI
    // DIGUNAKAN SAAT HAPUS TRANSAKSI UTAMA
    // ==============================

    public function deleteByTransaksi($id_transaksi)
    {

        $query = $this->db->prepare("

            DELETE FROM detail_transaksi


            WHERE id_transaksi = :id_transaksi


        ");


        return $query->execute([

            ":id_transaksi" => $id_transaksi

        ]);

    }



    // =====================================================
    // CRUD END
    // =====================================================


}