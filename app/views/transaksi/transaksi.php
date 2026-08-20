<div class="container-fluid">
    <!-- HEADER -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1">Data Transaksi</h3>
                <span class="badge bg-success text-nowrap">
                    Total <?= count($transaksi) ?>
                </span>
            </div>

            <a href="index.php?controller=transaksi&action=tambah" class="btn-tambah">
                <span class="material-symbols-outlined">add_circle</span>Transaksi Baru
            </a>
        </div>
    </div>

    <!-- Filter Data Transaksi -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-3">
            <!-- Title Filter -->
            <!-- <div class="d-flex align-items-center mb-3">
                <span class="material-symbols-outlined text-success me-2">filter_alt</span>
                <h5 class="fw-bold mb-0">Filter Data Transaksi</h5>
            </div> -->

            <!-- Form Grid Filter -->
            <div class="row g-3">
                <!-- Search Input (Nama / ID Transaksi) -->
                <div class="col-lg-6 col-md-12">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" id="searchTransaksi" class="form-control border-start-0 bg-light"
                            placeholder="Cari ID transaksi, pelanggan, atau no telp...">
                    </div>
                </div>

                <!-- Filter Jenis Transaksi -->
                <div class="col-lg-2 col-md-4 col-12">
                    <select id="filterJenis" class="form-select bg-light">
                        <option value="">Semua Jenis</option>
                        <option value="Penjualan">Penjualan</option>
                        <option value="Pemesanan">Pemesanan</option>
                    </select>
                </div>

                <!-- Filter Status Pembayaran -->
                <div class="col-lg-2 col-md-4 col-12">
                    <select id="filterPembayaran" class="form-select bg-light">
                        <option value="">Status Bayar</option>
                        <option value="Belum Bayar">Belum Bayar</option>
                        <option value="DP">DP</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>

                <!-- Filter Status Transaksi -->
                <div class="col-lg-2 col-md-4 col-12">
                    <select id="filterStatus" class="form-select bg-light">
                        <option value="">Status Transaksi</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE TRANSAKSI -->
    <div class="card shadow-sm border-0">
        <!-- class border-0 ditaruh di sini agar garis pembatas di bawah tombol PDF hilang -->
        <div class="card-header bg-white border-0 pt-3 pb-0">
            <h5 class="mb-0 d-flex align-items-center gap-3">
                <a href="index.php?controller=transaksi&action=cetakLaporanPdf" target="_blank"
                    class="btn btn-sm text-white" style="background-color: #2b5748;">
                    <i class="fas fa-file-pdf me-1"></i> Unduh PDF
                </a>
            </h5>
        </div>

        <div class="card-body">
            <div class="table-responsive" style="max-height: 400px; overflow: auto;">
                <table class="table table-hover align-middle text-nowrap mb-0" style="min-width: 1000px;">
                    <thead class="sticky-top table-success" style="z-index: 1;">
                        <tr class="text-center">
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Jenis</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transaksi)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($transaksi as $row): ?>
                        <tr class="text-center">
                            <td><?= $no++; ?></td>
                            <td><?= str_pad($row['id_transaksi'], 5, "0", STR_PAD_LEFT); ?></td>
                            <td>
                                <?= $row['nama_pelanggan'] ?? '-'; ?><br>
                                <small class="text-muted"><?= $row['no_telepon']; ?></small>
                            </td>
                            <td>
                                <?php if ($row['jenis_transaksi'] == "Penjualan"): ?>
                                <span class="badge bg-primary">Penjualan</span>
                                <?php else: ?>
                                <span class="badge bg-warning text-dark">Pemesanan</span>
                                <?php endif; ?>
                            </td>
                            <td>Rp <?= number_format($row['total'], 0, ",", "."); ?></td>
                            <td>
                                <span class="badge bg-info text-dark"><?= $row['status_pembayaran']; ?></span>
                            </td>
                            <td>
                                <?php if ($row['status_transaksi'] == "Selesai"): ?>
                                <span class="badge bg-success">Selesai</span>
                                <?php elseif ($row['status_transaksi'] == "Dibatalkan"): ?>
                                <span class="badge bg-danger">Dibatalkan</span>
                                <?php else: ?>
                                <span class="badge bg-secondary"><?= $row['status_transaksi']; ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= date("d-m-Y", strtotime($row['tanggal_dibuat'])); ?></td>
                            <td>
                                <!-- DETAIL -->
                                <button class="btn-aksi-detail" data-bs-toggle="modal"
                                    data-bs-target="#modalDetail<?= $row['id_transaksi']; ?>">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>

                                <!-- PELUNASAN -->
                                <?php if (in_array($row['status_pembayaran'], ['DP', 'Belum Bayar'])): ?>
                                <button class="btn-aksi-ubah" data-bs-toggle="modal"
                                    data-bs-target="#modalPelunasan<?= $row['id_transaksi']; ?>">
                                    <span class="material-symbols-outlined">edit</span>
                                </button>
                                <?php endif; ?>

                                <!-- HAPUS -->
                                <a href="index.php?controller=transaksi&action=delete&id=<?= $row['id_transaksi']; ?>"
                                    onclick="return confirm('Hapus transaksi ini?')" class="btn-aksi-hapus">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Belum ada transaksi</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL & SCRIPT -->
<?php require "modal_detail.php"; ?>
<?php require "modal_pelunasan.php"; ?>
<?php require "script.php"; ?>