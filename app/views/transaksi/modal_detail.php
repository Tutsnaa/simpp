<?php if (!empty($transaksi)): ?>
<?php foreach ($transaksi as $row): ?>
<div class="modal fade" id="modalDetail<?= $row['id_transaksi']; ?>" tabindex="-1"
    aria-labelledby="modalDetailLabel<?= $row['id_transaksi']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- HEADER DENGAN TEMA UTAMA #2b5748 -->
            <div class="modal-header text-white" style="background-color: #2b5748;">
                <h5 class="modal-title" id="modalDetailLabel<?= $row['id_transaksi']; ?>">
                    <i class="fas fa-receipt me-2"></i> Detail Transaksi
                    #TR<?= str_pad($row['id_transaksi'], 5, "0", STR_PAD_LEFT); ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Informasi Transaksi & Pelanggan -->
                <div class="row mb-3 g-2">
                    <div class="col-md-6">
                        <div class="p-2 border rounded bg-light" style="border-left: 4px solid #2b5748 !important;">
                            <small class="d-block fw-bold" style="color: #2b5748;">INFORMASI PELANGGAN</small>
                            <strong>Nama:</strong> <?= htmlspecialchars($row['nama_pelanggan'] ?? '-'); ?><br>
                            <strong>No. Telepon:</strong> <?= htmlspecialchars($row['no_telepon'] ?? '-'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 border rounded bg-light" style="border-left: 4px solid #2b5748 !important;">
                            <small class="d-block fw-bold" style="color: #2b5748;">INFORMASI TRANSAKSI</small>
                            <strong>Tanggal:</strong> <?= date("d-m-Y H:i", strtotime($row['tanggal_dibuat'])); ?><br>
                            <strong>Jenis:</strong>
                            <span
                                class="badge <?= $row['jenis_transaksi'] == 'Penjualan' ? 'bg-primary' : 'bg-warning text-dark'; ?>">
                                <?= $row['jenis_transaksi']; ?>
                            </span> |
                            <strong>Metode:</strong> <?= $row['metode_pembayaran'] ?? 'Tunai'; ?>
                        </div>
                    </div>
                </div>

                <!-- Status Pembayaran & Transaksi -->
                <div class="row mb-3 g-2">
                    <div class="col-md-6">
                        <strong>Status Pembayaran:</strong>
                        <span class="badge bg-info text-dark"><?= $row['status_pembayaran']; ?></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Status Transaksi:</strong>
                        <?php if ($row['status_transaksi'] == "Selesai"): ?>
                        <span class="badge" style="background-color: #2b5748;">Selesai</span>
                        <?php elseif ($row['status_transaksi'] == "Dibatalkan"): ?>
                        <span class="badge bg-danger">Dibatalkan</span>
                        <?php else: ?>
                        <span class="badge bg-secondary"><?= $row['status_transaksi']; ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($row['tanggal_pengambilan'])): ?>
                    <div class="col-md-12 mt-2">
                        <strong>Tanggal Pengambilan:</strong>
                        <?= date("d-m-Y", strtotime($row['tanggal_pengambilan'])); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Table Rincian Barang -->
                <h6 class="fw-bold mb-2" style="color: #2b5748;"><i class="fas fa-boxes me-1"></i> Rincian Barang</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered align-middle mb-0">
                        <thead>
                            <tr style="background-color: #2b5748; color: #ffffff;">
                                <th width="50" class="text-center">#</th>
                                <th>Nama Barang</th>
                                <th width="120" class="text-end">Harga</th>
                                <th width="80" class="text-center">Jumlah</th>
                                <th width="140" class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                    // 1. Ambil detail barang menggunakan DetailTransaksiModel jika belum diset dari controller
                                    if (!isset($row['detail']) || empty($row['detail'])) {
                                        if (!class_exists('DetailTransaksiModel')) {
                                            require_once "app/models/DetailTransaksiModel.php";
                                        }
                                        $detailModel = new DetailTransaksiModel();
                                        $details = $detailModel->getByTransaksi($row['id_transaksi']);
                                    } else {
                                        $details = $row['detail'];
                                    }

                                    // 2. Tampilkan data detail barang
                                    if (!empty($details)): 
                                        $noDetail = 1;
                                        foreach ($details as $d): 
                            ?>
                            <tr>
                                <td class="text-center"><?= $noDetail++; ?></td>
                                <td><?= htmlspecialchars($d['nama_barang'] ?? 'Barang'); ?></td>
                                <td class="text-end">Rp <?= number_format($d['harga'], 0, ",", "."); ?></td>
                                <td class="text-center"><?= $d['jumlah']; ?></td>
                                <td class="text-end">Rp <?= number_format($d['subtotal'], 0, ",", "."); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada detail barang.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <?php 
                                $totalBelanja = $row['total'] ?? 0;
                                $jumlahDibayar = $row['jumlah_dibayar'] ?? 0;
                                
                                // Hitung selisih
                                $selisih = $jumlahDibayar - $totalBelanja;
                                
                                if ($selisih < 0) {
                                    $sisaPembayaran = abs($selisih); // Kekurangan bayar
                                    $kembalian = 0;
                                } else {
                                    $sisaPembayaran = 0;
                                    $kembalian = $selisih; // Uang kembalian
                                }
                            ?>
                            <tr>
                                <th colspan="4" class="text-end">Total Belanja:</th>
                                <th class="text-end" style="color: #2b5748;">Rp
                                    <?= number_format($totalBelanja, 0, ",", "."); ?></th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-end">Jumlah Dibayar:</th>
                                <th class="text-end text-success">Rp <?= number_format($jumlahDibayar, 0, ",", "."); ?>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-end">Sisa Pembayaran (Kekurangan):</th>
                                <th class="text-end <?= $sisaPembayaran > 0 ? 'text-danger' : 'text-muted'; ?>">
                                    Rp <?= number_format($sisaPembayaran, 0, ",", "."); ?>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-end">Kembalian:</th>
                                <th class="text-end <?= $kembalian > 0 ? 'text-primary' : 'text-muted'; ?>">
                                    Rp <?= number_format($kembalian, 0, ",", "."); ?>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <?php if (!empty($row['catatan'])): ?>
                <div class="mt-3">
                    <strong style="color: #2b5748;">Catatan:</strong>
                    <p class="mb-0 text-muted border p-2 rounded bg-light">
                        <?= nl2br(htmlspecialchars($row['catatan'])); ?></p>
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>