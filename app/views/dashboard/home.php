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
                            <h4 class="mb-0 fw-bold mt-1 text-primary">
                                <?= number_format($totalTransaksi ?? 0, 0, ',', '.'); ?>
                            </h4>
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
                            <h4 class="mb-0 fw-bold mt-1 text-info">
                                <?= number_format($totalBarang ?? 0, 0, ',', '.'); ?>
                            </h4>
                        </div>
                        <div class="p-3 rounded-circle bg-info bg-opacity-10 text-info">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Pemesanan -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase">Total Pemesanan</span>
                            <h4 class="mb-0 fw-bold mt-1 text-info">
                                <?= number_format($totalPemesanan ?? 0, 0, ',', '.'); ?>
                            </h4>
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
                    <a href="index.php?controller=transaksi&action=index" class="btn btn-sm text-white"
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
                                    <th>Status Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($transaksiTerbaru)): ?>
                                <?php foreach ($transaksiTerbaru as $row): ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold">
                                            TR<?= str_pad($row['id_transaksi'], 5, "0", STR_PAD_LEFT); ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($row['nama_pelanggan'] ?? 'Umum'); ?></td>
                                    <td>Rp <?= number_format($row['total'], 0, ",", "."); ?></td>
                                    <td>
                                        <?php if ($row['status_pembayaran'] == "Lunas"): ?>
                                        <span class="badge bg-success">Lunas</span>
                                        <?php elseif ($row['status_pembayaran'] == "DP"): ?>
                                        <span class="badge bg-warning text-dark">DP</span>
                                        <?php else: ?>
                                        <span
                                            class="badge bg-danger"><?= htmlspecialchars($row['status_pembayaran']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada transaksi terbaru</td>
                                </tr>
                                <?php endif; ?>
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

                <!-- Tambahkan style max-height dan overflow-y: auto di sini -->
                <div class="card-body p-0" style="max-height: 350px; overflow-y: auto;">
                    <ul class="list-group list-group-flush">
                        <?php if (!empty($stokMenipis)): ?>
                        <?php foreach ($stokMenipis as $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <h6 class="my-0 fw-bold"><?= htmlspecialchars($item['nama_barang']); ?></h6>
                                <small class="text-muted">
                                    Kategori: <?= htmlspecialchars($item['nama_kategori'] ?? 'Umum'); ?>
                                </small>
                            </div>
                            <?php if ($item['jumlah'] <= 0): ?>
                            <span class="badge bg-danger rounded-pill">Habis</span>
                            <?php elseif ($item['jumlah'] <= 3): ?>
                            <span class="badge bg-danger rounded-pill">Sisa <?= $item['jumlah']; ?> Pcs</span>
                            <?php else: ?>
                            <span class="badge bg-warning text-dark rounded-pill">Sisa <?= $item['jumlah']; ?>
                                Pcs</span>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <li class="list-group-item text-center text-muted py-4">
                            <i class="fas fa-check-circle text-success me-1"></i> Semua stok aman
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>