<!-- MODAL PEMBAYARAN -->
<div class="modal fade" id="modalPembayaran" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-receipt me-2 text-primary-custom"></i>
                    <span id="modal_title_text">Proses Pembayaran</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- METODE PEMBAYARAN -->
                <div class="mb-3">
                    <label class="form-label fw-bold small">Metode Pembayaran</label>
                    <select class="form-select" name="metode_pembayaran" id="metode_pembayaran">
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer">Transfer Bank</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>

                <!-- INPUT JUMLAH DIBAYAR -->
                <div class="mb-3">
                    <label class="form-label fw-bold small" id="label_jumlah_bayar">Jumlah Dibayar</label>
                    <input type="text" id="jumlah_bayar_tampil"
                        class="form-control form-control-lg fw-bold text-primary-custom" value="0" placeholder="0"
                        required>
                    <input type="hidden" name="jumlah_dibayar" id="jumlah_bayar" value="0">
                </div>

                <!-- HASIL PERHITUNGAN (KEMBALIAN / SISA) -->
                <div class="row g-2 mb-3">
                    <div class="col-12" id="box_kembalian">
                        <label class="form-label small text-muted">Kembalian</label>
                        <input class="form-control fw-bold bg-light" id="kembalian" readonly value="Rp 0">
                    </div>
                    <div class="col-12" id="box_sisa" style="display: none;">
                        <label class="form-label small text-muted fw-bold text-danger">Sisa Kurang Bayar</label>
                        <input type="hidden" name="sisa_pembayaran" id="input_sisa_bayar" value="0">
                        <input class="form-control fw-bold text-danger bg-light" id="sisa_bayar" readonly value="Rp 0">
                    </div>
                </div>

                <!-- STATUS TRANSAKSI & PEMBAYARAN (HANYA TAMPIL DI PEMESANAN) -->
                <div class="row g-2" id="box_status_pemesanan" style="display: none;">
                    <div class="col-6">
                        <label class="form-label small text-muted">Status Pembayaran</label>
                        <select class="form-select form-select-sm" name="status_pembayaran" id="status_pembayaran">
                            <option value="Belum Bayar">Belum Bayar</option>
                            <option value="DP">DP (Uang Muka)</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted">Status Pesanan</label>
                        <select class="form-select form-select-sm" name="status_transaksi" id="status_transaksi">
                            <option value="Diproses">Diproses</option>
                            <option value="Siap Diambil">Siap Diambil</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary-custom fw-bold" id="btn_simpan">
                    <i class="fas fa-save me-1"></i> Simpan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>