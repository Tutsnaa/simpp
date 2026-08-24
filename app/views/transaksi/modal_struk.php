<!-- MODAL DIALOG STRUK DENGAN PREVIEW -->
<div class="modal fade" id="modalStruk" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">

            <!-- HEADER MODAL -->
            <div class="modal-header border-0 pb-0 text-center d-block bg-light rounded-top py-3">
                <h6 class="modal-title fw-bold text-success mb-1">
                    <i class="fas fa-check-circle me-1"></i> Transaksi Berhasil!
                </h6>
                <small class="text-muted d-block" style="font-size: 11px;">Preview Struk Pembayaran</small>
            </div>

            <!-- BODY MODAL: PREVIEW STRUK -->
            <div class="modal-body p-3 bg-secondary bg-opacity-10">

                <!-- KERTAS STRUK THERMAL -->
                <div id="printArea" class="p-3 bg-white shadow-sm mx-auto rounded-1"
                    style="max-width: 280px; font-family: 'Courier New', Courier, monospace; font-size: 11px; color: #000; line-height: 1.3;">

                    <!-- HEADER STRUK -->
                    <div class="text-center mb-2">
                        <div class="fw-bold" style="font-size: 13px;">MINIMARKET SAYA</div>
                        <div>Jl. Jend. Sudirman No. 88</div>
                        <div>Telp: 0812-3456-7890</div>
                    </div>

                    <div class="struk-divider"></div>

                    <!-- META TRANSAKSI -->
                    <div class="my-1">
                        <div class="struk-row">
                            <span>Tgl:</span>
                            <span id="p_tgl" class="fw-bold">01/01/2026 10:00</span>
                        </div>
                        <div class="struk-row">
                            <span>Kasir:</span>
                            <span>Kasir 1</span>
                        </div>
                        <div class="struk-row">
                            <span>Pelanggan:</span>
                            <span id="p_pelanggan">Pelanggan Umum</span>
                        </div>
                        <div class="struk-row">
                            <span>Jenis:</span>
                            <span id="p_jenis">Penjualan</span>
                        </div>
                    </div>

                    <div class="struk-divider"></div>

                    <!-- DAFTAR ITEM BELANJA -->
                    <table style="width: 100%; border-collapse: collapse; font-size: 11px;" id="p_items">
                        <!-- Diisi otomatis oleh JavaScript -->
                    </table>

                    <div class="struk-divider"></div>

                    <!-- RINCIAN PEMBAYARAN -->
                    <div class="my-1">
                        <div class="struk-row fw-bold">
                            <span>TOTAL:</span>
                            <span id="p_total">Rp 0</span>
                        </div>
                        <div class="struk-row">
                            <span>BAYAR:</span>
                            <span><span id="p_bayar">Rp 0</span></span>
                        </div>
                        <div class="struk-row" id="p_box_kembalian">
                            <span>KEMBALI:</span>
                            <span id="p_kembalian">Rp 0</span>
                        </div>
                        <div class="struk-row" id="p_box_sisa" style="display: none;">
                            <span>SISA BAYAR:</span>
                            <span id="p_sisa">Rp 0</span>
                        </div>
                    </div>

                    <div class="struk-divider"></div>

                    <!-- FOOTER STRUK -->
                    <div class="text-center mt-2">
                        <div>-- TERIMA KASIH --</div>
                        <div style="font-size: 9px;" class="mt-1">Barang yang sudah dibeli<br>tidak dapat
                            ditukar/dikembalikan</div>
                    </div>
                </div>

            </div>

            <!-- FOOTER MODAL -->
            <div class="modal-footer border-0 justify-content-center gap-2 bg-light rounded-bottom py-2">
                <!-- Menggunakan kelas .btn-selesai -->
                <button type="button" class="btn-selesai btn-sm px-3" id="btn_selesai_tanpa_cetak">
                    Selesai
                </button>

                <!-- Menggunakan kelas .btn-tambah -->
                <button type="button" class="btn-tambah btn-sm px-3 fw-bold" id="btn_cetak_struk" style="height: 38px;">
                    <i class="fas fa-print me-1"></i> Cetak Struk
                </button>
            </div>

        </div>
    </div>
</div>

<!-- CSS KHUSUS STRUK -->
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
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    body * {
        visibility: hidden !important;
    }

    #printArea,
    #printArea * {
        visibility: visible !important;
    }

    #printArea {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 58mm !important;
        max-width: 58mm !important;
        padding: 1mm 2mm !important;
        margin: 0 !important;
        box-shadow: none !important;
        background: #ffffff !important;
        color: #000000 !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .struk-divider {
        border-top: 1px dashed #000 !important;
        margin: 3px 0 !important;
    }
}
</style>