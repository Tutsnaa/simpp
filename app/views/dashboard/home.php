<div class="container-fluid py-3">

    <!-- Header / Welcoming -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 rounded-3 text-white shadow-sm" style="background-color: #2b5748;">
                <h3 class="fw-bold mb-1">Selamat Datang, <?= htmlspecialchars($_SESSION['nama'] ?? 'Pengguna'); ?>! 👋
                </h3>
                <p class="mb-0 text-white-50">Berikut adalah ringkasan performa toko Anda hari ini.</p>
            </div>
        </div>
    </div>

    <!-- 1. Ringkasan Kartu (Summary Cards) -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Pendapatan / Omset -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase">Total Omset</span>
                            <h4 class="mb-0 fw-bold mt-1 text-success">Rp
                                <?= number_format($totalOmset, 0, ',', '.'); ?></h4>
                        </div>
                        <div class="p-3 rounded-circle bg-success bg-opacity-10 text-success">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Transaksi -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase">Total Transaksi</span>
                            <h4 class="mb-0 fw-bold mt-1 text-primary">45</h4>
                        </div>
                        <div class="p-3 rounded-circle bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Produk -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase">Total Jenis Produk</span>
                            <h4 class="mb-0 fw-bold mt-1 text-info">120</h4>
                        </div>
                        <div class="p-3 rounded-circle bg-info bg-opacity-10 text-info">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Sisa Pembayaran (Piutang) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase">Piutang Belum Lunas</span>
                            <h4 class="mb-0 fw-bold mt-1 text-warning">Rp 250.000</h4>
                        </div>
                        <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-hand-holding-usd fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Section Konten Utama (Tabel Transaksi Terakhir & Stok Menipis) -->
    <div class="row g-3">

        <!-- Tabel Transaksi Terbaru -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold" style="color: #2b5748;">
                        <i class="fas fa-history me-2"></i>Transaksi Terbaru
                    </h6>
                    <a href="index.php?page=transaksi" class="btn btn-sm text-white"
                        style="background-color: #2b5748;">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Contoh Data Statis (Nanti di-loop dari DB) -->
                                <tr>
                                    <td><span class="fw-bold">#TR00012</span></td>
                                    <td>Ahmad Budi</td>
                                    <td>Rp 150.000</td>
                                    <td><span class="badge bg-success">Lunas</span></td>
                                </tr>
                                <tr>
                                    <td><span class="fw-bold">#TR00011</span></td>
                                    <td>Siti Rahma</td>
                                    <td>Rp 85.000</td>
                                    <td><span class="badge bg-warning text-dark">Belum Lunas</span></td>
                                </tr>
                                <tr>
                                    <td><span class="fw-bold">#TR00010</span></td>
                                    <td>Umum</td>
                                    <td>Rp 45.000</td>
                                    <td><span class="badge bg-success">Lunas</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning Stok Menipis -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="m-0 fw-bold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Peringatan Stok Menipis
                    </h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <h6 class="my-0 fw-bold">Kertas HVS A4</h6>
                                <small class="text-muted">Kategori: ATK</small>
                            </div>
                            <span class="badge bg-danger rounded-pill">Sisa 2 Pcs</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <h6 class="my-0 fw-bold">Tinta Printer Hitam</h6>
                                <small class="text-muted">Kategori: Tinta</small>
                            </div>
                            <span class="badge bg-danger rounded-pill">Sisa 1 Pcs</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <h6 class="my-0 fw-bold">Map Folio Bening</h6>
                                <small class="text-muted">Kategori: ATK</small>
                            </div>
                            <span class="badge bg-warning text-dark rounded-pill">Sisa 5 Pcs</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>