<?php if (!empty($transaksi)): ?>
<?php foreach ($transaksi as $row): ?>
<!-- Hanya buat modal untuk transaksi yang memiliki status pembayaran DP / Belum Bayar -->
<?php if ($row['status_pembayaran'] == 'DP' || $row['sisa_pembayaran'] > 0): ?>
<div class="modal fade" id="modalPelunasan<?= $row['id_transaksi']; ?>" tabindex="-1"
    aria-labelledby="modalPelunasanLabel<?= $row['id_transaksi']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- HEADER TEMA #2b5748 -->
            <div class="modal-header text-white" style="background-color: #2b5748;">
                <h5 class="modal-title" id="modalPelunasanLabel<?= $row['id_transaksi']; ?>">
                    <i class="fas fa-money-bill-wave me-2"></i> Pelunasan Transaksi
                    #TR<?= str_pad($row['id_transaksi'], 5, "0", STR_PAD_LEFT); ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <form action="index.php?controller=transaksi&action=pelunasan" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">

                    <!-- Information Box -->
                    <div class="p-3 mb-3 border rounded bg-light" style="border-left: 4px solid #2b5748 !important;">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Pelanggan:</span>
                            <strong><?= htmlspecialchars($row['nama_pelanggan'] ?? 'Pelanggan Umum'); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Total Transaksi:</span>
                            <span class="fw-bold">Rp <?= number_format($row['total'], 0, ",", "."); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Sudah Dibayar (DP):</span>
                            <span class="text-success fw-bold">Rp
                                <?= number_format($row['jumlah_dibayar'], 0, ",", "."); ?></span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="color: #2b5748;">Sisa Pembayaran:</span>
                            <span class="fs-5 fw-bold text-danger">Rp
                                <?= number_format($row['sisa_pembayaran'], 0, ",", "."); ?></span>
                        </div>
                    </div>

                    <!-- Form Inputs -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Bayar Pelunasan (Rp)</label>
                        <input type="number" name="bayar_pelunasan"
                            class="form-control form-control-lg fw-bold text-end input-pelunasan"
                            data-sisa="<?= $row['sisa_pembayaran']; ?>" min="<?= $row['sisa_pembayaran']; ?>"
                            value="<?= $row['sisa_pembayaran']; ?>" required>
                        <div class="form-text">Masukkan nominal pembayaran (minimal sebesar sisa pelunasan).</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="Tunai"
                                <?= ($row['metode_pembayaran'] ?? '') == 'Tunai' ? 'selected' : ''; ?>>Tunai</option>
                            <option value="Transfer"
                                <?= ($row['metode_pembayaran'] ?? '') == 'Transfer' ? 'selected' : ''; ?>>Transfer Bank
                            </option>
                            <option value="QRIS" <?= ($row['metode_pembayaran'] ?? '') == 'QRIS' ? 'selected' : ''; ?>>
                                QRIS</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan_pelunasan" class="form-control" rows="2"
                            placeholder="Contoh: Pelunasan via Transfer BCA..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white fw-bold" style="background-color: #2b5748;">
                        <i class="fas fa-check-circle me-1"></i> Simpan Pelunasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>