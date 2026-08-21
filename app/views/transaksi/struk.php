<!-- MODAL STRUK PEMBAYARAN -->
<div class="modal fade" id="modalStruk" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-center w-100">Struk Pembayaran</h6>
            </div>
            <div class="modal-body text-center pt-2">
                <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                <h6 class="fw-bold mb-1">Transaksi Berhasil!</h6>
                <p class="text-muted small mb-3">Apakah Anda ingin mencetak struk transaksi ini?</p>

                <!-- Preview Ringkasan Singkat Struk -->
                <div class="bg-light p-3 rounded-3 text-start small mb-3 border">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total:</span>
                        <span class="fw-bold" id="struk_total">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Bayar:</span>
                        <span id="struk_bayar">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Kembali/Sisa:</span>
                        <span class="fw-bold" id="struk_kembali">Rp 0</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center gap-2 pt-0">
                <button type="button" class="btn btn-light btn-sm px-3" id="btn_tidak_cetak">
                    Selesai (Tidak)
                </button>
                <button type="button" class="btn btn-primary-custom btn-sm px-3 fw-bold" id="btn_cetak_struk">
                    <i class="fas fa-print me-1"></i> Cetak Struk
                </button>
            </div>
        </div>
    </div>
</div>