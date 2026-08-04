<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Transaksi Baru</title>

    <!-- BOOTSTRAP 5 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
    :root {
        /* TEMA WARNA UTAMA (#2b5748) */
        --pos-primary: #2b5748;
        --pos-primary-hover: #214337;
        --pos-primary-light: #f0f5f3;
        --pos-primary-border: #c3d4cd;
        --pos-bg: #f4f6f5;
    }

    body {
        background-color: var(--pos-bg);
        font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        overflow-x: hidden;
    }

    /* CUSTOM ACCENT COLOR OVERRIDES */
    .text-primary-custom {
        color: var(--pos-primary) !important;
    }

    .btn-primary-custom {
        background-color: var(--pos-primary) !important;
        border-color: var(--pos-primary) !important;
        color: #ffffff !important;
    }

    .btn-primary-custom:hover {
        background-color: var(--pos-primary-hover) !important;
        border-color: var(--pos-primary-hover) !important;
    }

    .pos-header {
        background: #ffffff;
        height: 60px;
        padding: 0 20px;
        border-bottom: 1px solid #e3e6f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pos-wrapper {
        height: calc(100vh - 60px);
    }

    .cart-panel {
        background: #ffffff;
        border-right: 1px solid #e3e6f0;
        height: 100%;
        display: flex;
        flex-direction: column;
        padding: 15px;
        overflow-y: auto;
    }

    .cart-table-box {
        flex-grow: 1;
        min-height: 180px;
        max-height: 35vh;
        overflow-y: auto;
        border: 1px solid #e3e6f0;
        border-radius: 8px;
        margin-bottom: 15px;
        background: #fff;
    }

    .total-box {
        background: var(--pos-primary);
        color: #fff;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .product-panel {
        height: 100%;
        overflow-y: auto;
        padding: 15px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(43, 87, 72, 0.12);
        border-color: var(--pos-primary);
    }

    .product-img-wrapper {
        margin: 0 auto;
        width: 200px;
        height: 200px;
        background: #f1f4f3;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info {
        padding: 10px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }

    .qty-control {
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .qty-control input {
        width: 38px;
        text-align: center;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 2px;
    }

    .box-pemesanan-kiri {
        background-color: var(--pos-primary-light);
        border: 1px solid var(--pos-primary-border);
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 12px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--pos-primary);
        box-shadow: 0 0 0 0.25rem rgba(43, 87, 72, 0.25);
    }
    </style>
</head>

<body>

    <form action="index.php?controller=transaksi&action=create" method="POST" id="form_transaksi">

        <!-- HEADER -->
        <div class="pos-header">
            <div class="d-flex align-items-center gap-3">
                <h5 class="m-0 fw-bold text-primary-custom">
                    <i class="fas fa-cash-register me-2"></i>Kasir POS
                </h5>
                <div class="d-flex align-items-center gap-2 border-start ps-3">
                    <label class="fw-bold small text-muted mb-0">Jenis Transaksi:</label>
                    <select class="form-select form-select-sm fw-bold text-primary-custom" id="jenis_transaksi"
                        name="jenis_transaksi" style="width: 150px;">
                        <option value="Penjualan">Penjualan</option>
                        <option value="Pemesanan">Pemesanan</option>
                    </select>
                </div>
            </div>
            <a href="index.php?controller=transaksi&action=index" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- SPLIT CONTAINER -->
        <div class="container-fluid pos-wrapper">
            <div class="row h-100">

                <!-- PANEL KIRI: KERANJANG & DATA PELANGGAN -->
                <div class="col-lg-5 col-xl-4 cart-panel">

                    <!-- DATA PELANGGAN UTAMA -->
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted mb-1">Nama Pelanggan <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="nama_pelanggan"
                            id="nama_pelanggan" value="Pelanggan Umum" required>
                    </div>

                    <!-- BOX DATA TAMBAHAN (HANYA MUNCUL SAAT PEMESANAN) -->
                    <div id="box_pemesanan_kiri" class="box-pemesanan-kiri" style="display: none;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar-alt text-primary-custom me-2"></i>
                            <strong class="small text-primary-custom">Detail Pemesanan</strong>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label small text-muted mb-1" style="font-size: 11px;">No. HP /
                                    WA</label>
                                <input type="text" class="form-control form-control-sm" name="no_telepon"
                                    id="no_telepon" placeholder="08xxx">
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted mb-1" style="font-size: 11px;">Tgl
                                    Pengambilan</label>
                                <input type="date" class="form-control form-control-sm" name="tanggal_pengambilan"
                                    id="tanggal_pengambilan">
                            </div>
                            <div class="col-12">
                                <label class="form-label small text-muted mb-1" style="font-size: 11px;">Catatan
                                    Pesanan</label>
                                <textarea class="form-control form-control-sm" name="catatan" id="catatan" rows="2"
                                    placeholder="Contoh: Tanpa pedas, bungkus terpisah, dll"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- TABEL KERANJANG BELANJA -->
                    <label class="form-label small fw-bold text-muted mb-1">Daftar Item</label>
                    <div class="cart-table-box">
                        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Item</th>
                                    <th style="width: 85px;">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                    <th style="width: 25px;"></th>
                                </tr>
                            </thead>
                            <tbody id="cart_body">
                                <!-- Item belanjaan akan dimasukkan via Javascript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- RINGKASAN TOTAL & TOMBOL PROSES -->
                    <div class="mt-auto">
                        <div class="total-box d-flex justify-content-between align-items-center">
                            <div>
                                <small class="d-block text-white-50" style="font-size: 11px;">TOTAL BELANJA</small>
                                <h4 class="m-0 fw-bold" id="label_total">Rp 0</h4>
                                <input type="hidden" name="total" id="input_total" value="0">
                            </div>
                            <i class="fas fa-shopping-cart fa-2x text-white-50"></i>
                        </div>

                        <button type="button" class="btn btn-primary-custom btn-lg w-100 fw-bold shadow-sm py-2"
                            id="btn_lanjut_bayar">
                            <i class="fas fa-credit-card me-2"></i>Lanjut Pembayaran
                        </button>
                    </div>
                </div>

                <!-- PANEL KANAN: KATALOG BARANG -->
                <div class="col-lg-7 col-xl-8 product-panel">

                    <!-- SEARCH BAR -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" id="search_produk" class="form-control" placeholder="Cari barang...">
                            </div>
                        </div>
                    </div>

                    <!-- GRID PRODUK -->
                    <div class="row g-3" id="product_container">
                        <?php foreach($barang as $b): ?>
                        <div class="col-6 col-sm-4 col-md-3 item-produk"
                            data-nama="<?= strtolower($b['nama_barang']); ?>">
                            <div class="product-card btn-add-cart" data-id="<?=$b['id_barang'];?>"
                                data-nama="<?=$b['nama_barang'];?>" data-harga="<?=$b['harga_jual'];?>">

                                <div class="product-img-wrapper">
                                    <?php if(!empty($b['foto'])): ?>
                                    <img src="assets/img/barang/<?=$b['foto'];?>" alt="<?=$b['nama_barang'];?>">
                                    <?php else: ?>
                                    <i class="fas fa-box fa-2x text-secondary opacity-50"></i>
                                    <?php endif; ?>
                                </div>

                                <div class="product-info text-center">
                                    <h6 class="fw-bold text-dark mb-1 text-truncate" title="<?=$b['nama_barang'];?>"
                                        style="font-size: 13px;">
                                        <?=$b['nama_barang'];?>
                                    </h6>
                                    <span class="text-primary-custom fw-bold" style="font-size: 13px;">
                                        Rp <?=number_format($b['harga_jual'], 0, ',', '.');?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>
        </div>

        <?php require "modal_pembayaran.php"; ?>
        <?php require "script.php"; ?>

    </form>
</body>

</html>