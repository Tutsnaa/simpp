<!-- MODAL STRUK / NOTA PEMBAYARAN -->
<div class="modal fade" id="modalStruk" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title fw-bold">Struk Pembayaran</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3" id="area_struk_print"
                style="font-family: 'Courier New', Courier, monospace; font-size: 12px; color: #000;">

                <!-- HEADER STRUK -->
                <div class="text-center mb-2">
                    <h5 class="fw-bold mb-0" style="font-size: 16px;">NAMA TOKO ANDA</h5>
                    <div style="font-size: 10px;">Jl. Alamat Toko No. 123, Kota</div>
                    <div style="font-size: 10px;">Telp: 0812-3456-7890</div>
                    <div class="border-top border-dark my-1"></div>
                </div>

                <!-- INFO TRANSAKSI -->
                <div class="mb-2" style="font-size: 11px;">
                    <div>No. Nota : <span id="struk_no_nota" class="fw-bold">-</span></div>
                    <div>Tgl : <span id="struk_tanggal">-</span></div>
                    <div>Kasir : <span id="struk_kasir">-</span></div>
                    <div>Pelanggan: <span id="struk_pelanggan">-</span></div>
                    <div class="border-top border-bottom border-dark my-1"></div>
                </div>

                <!-- DAFTAR ITEM BELANJA -->
                <table class="w-100 mb-2" style="font-size: 11px;">
                    <tbody id="struk_items_body">
                        <!-- Item diisi via JavaScript -->
                    </tbody>
                </table>

                <div class="border-top border-dark my-1"></div>

                <!-- TOTAL & PEMBAYARAN -->
                <div style="font-size: 11px;">
                    <div class="d-flex justify-content-between">
                        <span>Total:</span>
                        <span id="struk_total" class="fw-bold">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Bayar (<span id="struk_metode">Tunai</span>):</span>
                        <span id="struk_bayar">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between" id="struk_row_kembalian">
                        <span>Kembalian:</span>
                        <span id="struk_kembalian">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between text-danger" id="struk_row_sisa" style="display: none;">
                        <span>Sisa Bayar:</span>
                        <span id="struk_sisa">Rp 0</span>
                    </div>
                </div>

                <div class="border-top border-dark my-2"></div>

                <!-- FOOTER STRUK -->
                <div class="text-center" style="font-size: 10px;">
                    <div>Terima Kasih Atas Kunjungan Anda</div>
                    <div>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</div>
                </div>

            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary btn-sm fw-bold" onclick="cetakStruk()">
                    <i class="fas fa-print me-1"></i> Cetak Struk
                </button>
            </div>
        </div>
    </div>
</div>

<!-- STYLE KHUSUS PRINT STRUK -->
<style>
@media print {
    body * {
        visibility: hidden;
    }

    #area_struk_print,
    #area_struk_print * {
        visibility: visible;
    }

    #area_struk_print {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 0 !important;
        margin: 0 !important;
    }

    .modal-header,
    .modal-footer,
    .btn-close {
        display: none !important;
    }
}
</style>

<script>
function cetakStruk() {
    window.print();
}
</script>