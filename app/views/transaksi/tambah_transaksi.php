<!DOCTYPE html>
<html>

<head>
    <title>Transaksi Baru</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/tambah_transaksi.css?v=<?=time();?>" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

    <div class="pos-container">

        <!-- HEADER -->
        <div class="pos-header">

            <div class="header-title">

                <div class="icon-box">
                    <i class="fas fa-cash-register"></i>
                </div>


                <div class="jenis-transaksi">

                    <label>
                        Jenis Transaksi
                    </label>

                    <select class="form-select" id="jenis_transaksi">

                        <option value="Penjualan">
                            Penjualan
                        </option>

                        <option value="Pemesanan">
                            Pemesanan
                        </option>

                    </select>

                </div>


            </div>



            <a href="index.php?controller=dashboard&action=index" class="btn-dashboard">

                <i class="fas fa-arrow-left"></i>

                Dashboard

            </a>


        </div>



        <div class="main-content">


            <!-- DATA PELANGGAN -->

            <div class="customer-box">

                <div class="box-header">
                    <i class="fas fa-user"></i>
                    Data Pelanggan
                </div>


                <div class="box-body">


                    <label>Nama Pelanggan</label>

                    <input type="text" class="form-control" id="nama_pelanggan" value="Pelanggan Umum">



                    <div id="data_pemesanan">


                        <label>No Telepon</label>

                        <input type="text" class="form-control" id="no_telepon">


                        <label>Tanggal Pengambilan</label>

                        <input type="date" class="form-control" id="tanggal_pengambilan">


                    </div>

                    <div id="box_catatan">

                        <label>Catatan</label>

                        <textarea class="form-control" id="catatan"></textarea>

                    </div>


                </div>

            </div>





            <!-- KERANJANG -->

            <div class="cart-box">


                <div class="box-header">

                    <i class="fas fa-shopping-cart"></i>

                    Keranjang Barang

                </div>



                <div class="box-body">


                    <div class="add-item">


                        <select class="form-select" id="pilih_barang">

                            <option value="">
                                -- Pilih Barang --
                            </option>


                            <?php foreach($barang as $b): ?>

                            <option value="<?=$b['id_barang'];?>" data-nama="<?=$b['nama_barang'];?>"
                                data-harga="<?=$b['harga_jual'];?>">

                                <?=$b['nama_barang'];?> -
                                Rp <?=number_format($b['harga_jual']);?>

                            </option>


                            <?php endforeach; ?>


                        </select>



                        <input type="number" id="qty_barang" class="form-control" value="1" min="1">



                        <button type="button" id="btn_tambah" class="btn btn-tambah">

                            <i class="fas fa-plus"></i>
                            Tambah

                        </button>


                    </div>





                    <div class="cart-table">

                        <table class="table table-hover">


                            <thead>

                                <tr>

                                    <th>No</th>
                                    <th>Barang</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>

                                </tr>

                            </thead>


                            <tbody id="cart_body">


                            </tbody>


                        </table>

                    </div>


                </div>


            </div>


        </div>





        <!-- PEMBAYARAN -->


        <div class="payment-box">

            <div>

                <label>Metode Pembayaran</label>


                <select class="form-select" id="metode_pembayaran">


                    <option value="Tunai">
                        Tunai
                    </option>


                    <option value="Transfer">
                        Transfer
                    </option>


                    <option value="QRIS">
                        QRIS
                    </option>


                </select>


            </div>

            <div>

                <label>Total</label>

                <input class="form-control total-harga" readonly value="Rp 0">

            </div>



            <div>

                <label>Jumlah Dibayar</label>

                <input type="number" id="jumlah_bayar" class="form-control" value="0">

            </div>



            <div id="box_kembalian">

                <label>Kembalian</label>

                <input class="form-control" id="kembalian" readonly value="Rp 0">

            </div>



            <div id="box_sisa">

                <label>Sisa Pembayaran</label>

                <input class="form-control" id="sisa_bayar" readonly value="Rp 0">

            </div>



            <div id="box_status_bayar">


                <label>Status Pembayaran</label>

                <select class="form-select" id="status_pembayaran">


                    <option value="Belum Bayar">
                        Belum Bayar
                    </option>


                    <option value="DP">
                        DP
                    </option>


                    <option value="Lunas">
                        Lunas
                    </option>


                </select>

            </div>



            <div id="box_status_transaksi">


                <label>Status Transaksi</label>

                <select class="form-select" id="status_transaksi">


                    <option value="Diproses">
                        Diproses
                    </option>


                    <option value="Siap Diambil">
                        Siap Diambil
                    </option>


                    <option value="Selesai">
                        Selesai
                    </option>


                    <option value="Dibatalkan">
                        Dibatalkan
                    </option>

                </select>
            </div>
        </div>





        <button class="btn-save">

            <i class="fas fa-save me-2"></i>

            Simpan Transaksi

        </button>


    </div>

</body>

</html>

<script>
// ===============================
// TAMBAH BARANG KE KERANJANG
// ===============================

document.getElementById("btn_tambah")
    .addEventListener("click", function() {


        let select = document.getElementById("pilih_barang");

        let option = select.options[select.selectedIndex];


        if (select.value == "") {

            alert("Silahkan pilih barang");

            return;

        }



        let nama = option.dataset.nama;

        let harga = parseInt(option.dataset.harga);


        let qty = parseInt(
            document.getElementById("qty_barang").value
        );



        let subtotal = harga * qty;



        let html = `

<tr>


<td class="nomor"></td>


<td>
${nama}
</td>


<td class="harga">
Rp ${harga.toLocaleString('id-ID')}
</td>



<td>


<div class="qty-control">


<button type="button" class="btn-minus">

<i class="fas fa-minus"></i>

</button>



<input 
type="number"
class="qty-input"
value="${qty}"
min="1">



<button type="button" class="btn-plus">

<i class="fas fa-plus"></i>

</button>


</div>


</td>




<td class="subtotal">

Rp ${subtotal.toLocaleString('id-ID')}

</td>



<td>


<button 
type="button"
class="btn btn-danger btn-sm btn-hapus">


<i class="fas fa-trash"></i>


</button>


</td>


</tr>

`;



        document
            .getElementById("cart_body")
            .insertAdjacentHTML(
                "beforeend",
                html
            );




        // reset pilihan barang

        document.getElementById("pilih_barang").value = "";

        document.getElementById("qty_barang").value = 1;



        resetNomor();

        hitungTotal();



    });







// ===============================
// LOGIKA JENIS TRANSAKSI
// ===============================


let jenisTransaksi =
    document.getElementById("jenis_transaksi");



function aturTransaksi() {



    let penjualan =
        jenisTransaksi.value == "Penjualan";

    document
        .getElementById("box_catatan")
        .style.display =
        penjualan ? "none" : "block";


    // data pemesanan

    document
        .getElementById("data_pemesanan")
        .style.display =
        penjualan ? "none" : "block";




    // status pembayaran

    document
        .getElementById("box_status_bayar")
        .style.display =
        penjualan ? "none" : "block";




    // status transaksi

    document
        .getElementById("box_status_transaksi")
        .style.display =
        penjualan ? "none" : "block";




    // kembalian

    document
        .getElementById("box_kembalian")
        .style.display =
        penjualan ? "block" : "none";




    // sisa pembayaran

    document
        .getElementById("box_sisa")
        .style.display =
        penjualan ? "none" : "block";





    if (penjualan) {



        document
            .getElementById("nama_pelanggan")
            .value =
            "Pelanggan Umum";



        document
            .getElementById("metode_pembayaran")
            .value =
            "Tunai";



    } else {



        document
            .getElementById("nama_pelanggan")
            .value =
            "";


        document
            .getElementById("status_pembayaran")
            .value =
            "Belum Bayar";


        document
            .getElementById("status_transaksi")
            .value =
            "Diproses";


    }


}




jenisTransaksi
    .addEventListener(
        "change",
        aturTransaksi
    );



aturTransaksi();








// ===============================
// EVENT QTY DAN HAPUS
// ===============================


document
    .addEventListener("click", function(e) {



        // tambah qty

        if (e.target.closest(".btn-plus")) {


            let input =
                e.target
                .closest("tr")
                .querySelector(".qty-input");



            input.value =
                parseInt(input.value) + 1;



            updateRow(input);



        }





        // kurang qty


        if (e.target.closest(".btn-minus")) {


            let input =
                e.target
                .closest("tr")
                .querySelector(".qty-input");



            if (parseInt(input.value) > 1) {


                input.value =
                    parseInt(input.value) - 1;


            }



            updateRow(input);



        }







        // hapus barang


        if (e.target.closest(".btn-hapus")) {


            e.target
                .closest("tr")
                .remove();



            resetNomor();

            hitungTotal();



        }




    });









// ===============================
// UPDATE SUBTOTAL
// ===============================


function updateRow(input) {


    let row =
        input.closest("tr");



    let harga =
        parseInt(

            row
            .querySelector(".harga")
            .innerText
            .replace(/[^0-9]/g, '')

        );



    let qty =
        parseInt(input.value);



    let subtotal =
        harga * qty;



    row
        .querySelector(".subtotal")
        .innerText =
        "Rp " + subtotal.toLocaleString('id-ID');



    hitungTotal();



}









// ===============================
// RESET NOMOR
// ===============================


function resetNomor() {


    let nomor = 1;



    document
        .querySelectorAll("#cart_body tr")
        .forEach(function(row) {


            row
                .querySelector(".nomor")
                .innerText =
                nomor;



            nomor++;



        });


}









// ===============================
// HITUNG TOTAL
// ===============================


function hitungTotal() {


    let total = 0;



    document
        .querySelectorAll(".subtotal")
        .forEach(function(item) {


            total += parseInt(

                item.innerText
                .replace(/[^0-9]/g, '')

            );



        });




    document
        .querySelector(".total-harga")
        .value =
        "Rp " + total.toLocaleString('id-ID');



    hitungKembalian();

    hitungSisa();



}









// ===============================
// HITUNG KEMBALIAN
// ===============================


document
    .getElementById("jumlah_bayar")
    .addEventListener(
        "input",
        function() {

            hitungKembalian();

            hitungSisa();

        }

    );





function hitungKembalian() {


    let total =
        ambilAngka(
            document
            .querySelector(".total-harga")
            .value
        );



    let bayar =
        parseInt(
            document
            .getElementById("jumlah_bayar")
            .value
        ) ||
        0;



    let kembali =
        bayar - total;



    if (kembali < 0) {

        kembali = 0;

    }



    document
        .getElementById("kembalian")
        .value =
        "Rp " + kembali.toLocaleString('id-ID');



}









// ===============================
// HITUNG SISA PEMBAYARAN
// ===============================


function hitungSisa() {



    let total =
        ambilAngka(
            document
            .querySelector(".total-harga")
            .value
        );



    let bayar =
        parseInt(
            document
            .getElementById("jumlah_bayar")
            .value
        ) ||
        0;



    let sisa =
        total - bayar;



    if (sisa < 0) {

        sisa = 0;

    }



    document
        .getElementById("sisa_bayar")
        .value =
        "Rp " + sisa.toLocaleString('id-ID');



}









function ambilAngka(text) {


    return parseInt(

            text.replace(/[^0-9]/g, '')

        ) ||
        0;


}
</script>