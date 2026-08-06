<div class="container-fluid">
    <!-- HEADER -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 text-success">
                    <i class="fas fa-cash-register me-2"></i> Transaksi
                </h4>
                <p class="text-muted mb-0">
                    Kelola transaksi penjualan dan pemesanan toko
                </p>
            </div>
            <a href="index.php?controller=transaksi&action=tambah" class="btn-tambah">
                <span class="material-symbols-outlined">add_circle</span>Transaksi Baru
            </a>
        </div>
    </div>

    <!-- TABLE TRANSAKSI -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i> Data Transaksi
            </h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-success">
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
                                    <span class="material-symbols-outlined">
                                        visibility
                                    </span>
                                </button>

                                <!-- PELUNASAN -->
                                <?php if (in_array($row['status_pembayaran'], ['DP', 'Belum Bayar'])): ?>
                                <button class="btn-aksi-ubah" data-bs-toggle="modal"
                                    data-bs-target="#modalPelunasan<?= $row['id_transaksi']; ?>">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                </button>
                                <?php endif; ?>

                                <!-- HAPUS -->
                                <a href="index.php?controller=transaksi&action=delete&id=<?= $row['id_transaksi']; ?>"
                                    onclick="return confirm('Hapus transaksi ini?')" class="btn-aksi-hapus">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Belum ada transaksi</td>
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