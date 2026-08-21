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

    <link rel="stylesheet" href="assets/css/tambah_transaksi.css?v=<?= time(); ?>">

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
                                <textarea class="form-control form-control-sm" name="catatan" id="catatan"
                                    rows="2"></textarea>
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
                        <?php 
                        // Urutkan array $barang: Stok > 0 di atas, Stok <= 0 di bawah
                        usort($barang, function($a, $b) {
                            $stokA = (int)($a['jumlah'] ?? 0);
                            $stokB = (int)($b['jumlah'] ?? 0);

                            if ($stokA <= 0 && $stokB > 0) return 1;  // $a habis, pindah ke bawah
                            if ($stokA > 0 && $stokB <= 0) return -1; // $a ada stok, tetap di atas
                            return 0;                                 // Urutan sama jika stok sama-sama ada/habis
                        });

                        foreach($barang as $b): 
                            $stokBarang = (int)($b['jumlah'] ?? 0);
                            $isOutOfStock = ($stokBarang <= 0);
                        ?>
                        <div class="col-6 col-sm-4 col-md-3 item-produk"
                            data-nama="<?= strtolower($b['nama_barang']); ?>">
                            <div class="product-card btn-add-cart <?= $isOutOfStock ? 'disabled-card' : ''; ?>"
                                data-id="<?=$b['id_barang'];?>" data-nama="<?=$b['nama_barang'];?>"
                                data-harga="<?= (int)preg_replace('/[^0-9]/', '', $b['harga_jual']); ?>"
                                data-stok="<?=$stokBarang;?>">
                                <div class="product-img-wrapper position-relative">
                                    <?php if(!empty($b['foto'])): ?>
                                    <img src="assets/img/barang/<?=$b['foto'];?>" alt="<?=$b['nama_barang'];?>"
                                        style="<?= $isOutOfStock ? 'opacity: 0.4;' : ''; ?>">
                                    <?php else: ?>
                                    <i class="fas fa-box fa-2x text-secondary opacity-50"></i>
                                    <?php endif; ?>

                                    <?php if($isOutOfStock): ?>
                                    <span
                                        class="position-absolute top-50 start-50 translate-middle badge bg-danger fs-6 shadow">
                                        HABIS
                                    </span>
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

                                    <div>
                                        <span class="badge <?= $isOutOfStock ? 'bg-danger' : 'bg-secondary'; ?>">
                                            Stok: <?=$stokBarang;?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>
        </div>

        <?php require "modal_pembayaran.php"; ?>
        <!-- Include Modal Struk -->
        <?php include 'modal_struk.php'; ?>
        <?php require "script.php"; ?>

    </form>
</body>

</html>