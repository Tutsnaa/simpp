<?php if (!empty($transaksi)): ?>
<?php foreach ($transaksi as $row): ?>
<?php if ($row['status_pembayaran'] == 'DP' || $row['sisa_pembayaran'] > 0): ?>

<!-- 1. MODAL INPUT PELUNASAN -->
<div class="modal fade" id="modalPelunasan<?= $row['id_transaksi']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #2b5748;">
                <h5 class="modal-title">
                    <i class="fas fa-money-bill-wave me-2"></i> Pelunasan Transaksi
                    #TR<?= str_pad($row['id_transaksi'], 5, "0", STR_PAD_LEFT); ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="index.php?controller=transaksi&action=pelunasan" method="POST" class="form-pelunasan">
                <div class="modal-body">
                    <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
                    <input type="hidden" name="total_transaksi" value="<?= $row['total']; ?>">
                    <input type="hidden" name="dp_awal" value="<?= $row['jumlah_dibayar']; ?>">
                    <input type="hidden" name="sisa_awal" value="<?= $row['sisa_pembayaran']; ?>">
                    <input type="hidden" name="nama_pelanggan"
                        value="<?= htmlspecialchars($row['nama_pelanggan'] ?? 'Pelanggan Umum'); ?>">

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

                    <!-- Input Pelunasan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Bayar Pelunasan (Rp)</label>
                        <input type="number" name="bayar_pelunasan"
                            class="form-control form-control-lg fw-bold text-end input-bayar-pelunasan"
                            min="<?= $row['sisa_pembayaran']; ?>" value="<?= $row['sisa_pembayaran']; ?>" required>
                        <div class="form-text">Masukkan nominal pembayaran (minimal sebesar sisa pelunasan).</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer">Transfer Bank</option>
                            <option value="QRIS">QRIS</option>
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


<!-- 2. MODAL PREVIEW & CETAK STRUK PELUNASAN -->
<div class="modal fade" id="modalStrukPelunasan" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">

            <div class="modal-header border-0 pb-0 text-center d-block bg-light rounded-top py-3">
                <h6 class="modal-title fw-bold text-success mb-1">
                    <i class="fas fa-check-circle me-1"></i> Pelunasan Berhasil!
                </h6>
                <small class="text-muted d-block" style="font-size: 11px;">Preview Struk Pelunasan</small>
            </div>

            <div class="modal-body p-3 bg-secondary bg-opacity-10">
                <!-- WADAH STRUK VISUAL (KERTAS 58mm) -->
                <div id="printAreaPelunasan" class="p-3 bg-white shadow-sm mx-auto rounded-1"
                    style="max-width: 280px; font-family: 'Courier New', Courier, monospace; font-size: 11px; color: #000; line-height: 1.3;">

                    <div class="text-center mb-2">
                        <div class="fw-bold" style="font-size: 13px;">MINIMARKET SAYA</div>
                        <div>Jl. Jend. Sudirman No. 88</div>
                        <div>Telp: 0812-3456-7890</div>
                    </div>

                    <div class="struk-divider"></div>

                    <div class="text-center fw-bold">STRUK PELUNASAN</div>

                    <div class="struk-divider"></div>

                    <div class="my-1">
                        <div class="struk-row">
                            <span>No. Trx:</span>
                            <span id="pln_id_trx" class="fw-bold">-</span>
                        </div>
                        <div class="struk-row">
                            <span>Tgl Lunas:</span>
                            <span id="pln_tgl">-</span>
                        </div>
                        <div class="struk-row">
                            <span>Pelanggan:</span>
                            <span id="pln_pelanggan">-</span>
                        </div>
                    </div>

                    <div class="struk-divider"></div>

                    <div class="my-1">
                        <div class="struk-row">
                            <span>Total Transaksi:</span>
                            <span id="pln_total">Rp 0</span>
                        </div>
                        <div class="struk-row">
                            <span>Sudah Bayar (DP):</span>
                            <span id="pln_dp">Rp 0</span>
                        </div>
                        <div class="struk-row fw-bold">
                            <span>Sisa Tagihan:</span>
                            <span id="pln_sisa_tagihan">Rp 0</span>
                        </div>
                    </div>

                    <div class="struk-divider"></div>

                    <div class="my-1">
                        <div class="struk-row fw-bold">
                            <span>Bayar Pelunasan:</span>
                            <span id="pln_bayar">Rp 0</span>
                        </div>
                        <div class="struk-row">
                            <span>Kembali:</span>
                            <span id="pln_kembali">Rp 0</span>
                        </div>
                        <div class="struk-row fw-bold">
                            <span>Status:</span>
                            <span>LUNAS</span>
                        </div>
                    </div>

                    <div class="struk-divider"></div>

                    <div class="text-center mt-2">
                        <div>-- PELUNASAN BERHASIL --</div>
                        <div style="font-size: 9px;" class="mt-1">Terima kasih atas pembayaran Anda</div>
                    </div>

                </div>
            </div>

            <div class="modal-footer border-0 justify-content-center gap-2 bg-light rounded-bottom py-2">
                <button type="button" class="btn btn-outline-secondary btn-sm px-3" id="btn_selesai_pelunasan">
                    Selesai (Tanpa Cetak)
                </button>
                <button type="button" class="btn btn-primary-custom btn-sm px-3 fw-bold" id="btn_cetak_pelunasan">
                    <i class="fas fa-print me-1"></i> Cetak Struk
                </button>
            </div>

        </div>
    </div>
</div>

<style>
.struk-divider {
    border-top: 1px dashed #333;
    margin: 6px 0;
    width: 100%;
}

.struk-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

@media print {
    @page {
        margin: 0 !important;
        size: 58mm auto !important;
    }

    html,
    body {
        width: 58mm !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    body * {
        visibility: hidden !important;
    }

    #printAreaPelunasan,
    #printAreaPelunasan * {
        visibility: visible !important;
    }

    #printAreaPelunasan {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 58mm !important;
        max-width: 58mm !important;
        padding: 2mm !important;
        margin: 0 !important;
        box-shadow: none !important;
        background: #ffffff !important;
        color: #000000 !important;
    }

    .struk-divider {
        border-top: 1px dashed #000 !important;
        margin: 4px 0 !important;
    }
}
</style>