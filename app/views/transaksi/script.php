<!-- BOOTSTRAP 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ==========================================
    // 1. FILTER DATA TRANSAKSI (HALAMAN INDEX)
    // ==========================================
    const searchInput = document.getElementById('searchTransaksi');
    const filterJenis = document.getElementById('filterJenis');
    const filterPembayaran = document.getElementById('filterPembayaran');
    const filterStatus = document.getElementById('filterStatus');
    const filterTglAwal = document.getElementById('filterTglAwal');
    const filterTglAkhir = document.getElementById('filterTglAkhir');
    const tableRows = document.querySelectorAll('tbody tr');

    function applyFilter() {
        const querySearch = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedJenis = filterJenis ? filterJenis.value.toLowerCase().trim() : '';
        const selectedPembayaran = filterPembayaran ? filterPembayaran.value.toLowerCase().trim() : '';
        const selectedStatus = filterStatus ? filterStatus.value.toLowerCase().trim() : '';

        // Ambil nilai tanggal (Format HTML input date default: YYYY-MM-DD)
        const valAwal = filterTglAwal ? filterTglAwal.value : '';
        const valAkhir = filterTglAkhir ? filterTglAkhir.value : '';

        tableRows.forEach(row => {
            // Abaikan baris kosong / header / no data
            if (row.children.length <= 1) return;

            // Pastikan INDEX (children[x]) SESUAI dengan urutan kolom TANGGAL di HTML <table> Anda!
            // Contoh: Jika tanggal berada di kolom ke-5 (indeks 4)
            const rawDateText = row.children[4]?.textContent.trim() || '';

            const idTransaksi = row.children[1]?.textContent.toLowerCase().trim() || '';
            const pelangganInfo = row.children[2]?.textContent.toLowerCase().trim() || '';
            const jenisTransaksiText = row.children[3]?.textContent.toLowerCase().trim() || '';
            const statusPembayaranText = row.children[5]?.textContent.toLowerCase().trim() || '';
            const statusTransaksiText = row.children[6]?.textContent.toLowerCase().trim() || '';

            // Extract tanggal dari teks tabel menjadi format YYYY-MM-DD
            let formattedRowDate = '';
            if (rawDateText) {
                const d = new Date(rawDateText);
                if (!isNaN(d.getTime())) {
                    const yyyy = d.getFullYear();
                    const mm = String(d.getMonth() + 1).padStart(2, '0');
                    const dd = String(d.getDate()).padStart(2, '0');
                    formattedRowDate = `${yyyy}-${mm}-${dd}`;
                }
            }

            const matchSearch = idTransaksi.includes(querySearch) || pelangganInfo.includes(
                querySearch);
            const matchJenis = selectedJenis === '' || jenisTransaksiText.includes(selectedJenis);
            const matchPembayaran = selectedPembayaran === '' || statusPembayaranText.includes(
                selectedPembayaran);
            const matchStatus = selectedStatus === '' || statusTransaksiText.includes(selectedStatus);

            // LOGIKA PERBANDINGAN RENTANG TANGGAL
            let matchTanggal = true;
            if (valAwal && valAkhir) {
                matchTanggal = formattedRowDate >= valAwal && formattedRowDate <= valAkhir;
            } else if (valAwal) {
                matchTanggal = formattedRowDate >= valAwal;
            } else if (valAkhir) {
                matchTanggal = formattedRowDate <= valAkhir;
            }

            if (matchSearch && matchJenis && matchPembayaran && matchStatus && matchTanggal) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) searchInput.addEventListener('input', applyFilter);
    if (filterJenis) filterJenis.addEventListener('change', applyFilter);
    if (filterPembayaran) filterPembayaran.addEventListener('change', applyFilter);
    if (filterStatus) filterStatus.addEventListener('change', applyFilter);
    if (filterTglAwal) filterTglAwal.addEventListener('change', applyFilter);
    if (filterTglAkhir) filterTglAkhir.addEventListener('change', applyFilter);

    // ==========================================
    // 2. DEKLARASI ELEMEN POS & MODAL
    // ==========================================
    let itemIndex = 0;
    let cartItems = {};

    const inputTampil = document.getElementById("jumlah_bayar_tampil");
    const inputHidden = document.getElementById("jumlah_bayar");
    const jenisTransaksi = document.getElementById("jenis_transaksi");
    const formTransaksi = document.getElementById("form_transaksi");

    const modalPembayaranEl = document.getElementById('modalPembayaran');
    const modalStrukEl = document.getElementById('modalStruk');

    const modalPembayaran = modalPembayaranEl ? new bootstrap.Modal(modalPembayaranEl) : null;
    const modalStruk = modalStrukEl ? new bootstrap.Modal(modalStrukEl) : null;

    // Helper Format Rupiah
    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Hitung Kembalian & Sisa Bayar
    function hitungPembayaran() {
        const inputTotal = document.getElementById("input_total");
        if (!inputTotal || !inputHidden) return;

        const total = parseFloat(inputTotal.value) || 0;
        const bayar = parseFloat(inputHidden.value) || 0;

        let kembalian = 0;
        let sisa = 0;

        if (bayar >= total) {
            kembalian = bayar - total;
            sisa = 0;
            if (jenisTransaksi && jenisTransaksi.value === "Pemesanan") {
                const elStatusBayar = document.getElementById("status_pembayaran");
                if (elStatusBayar) elStatusBayar.value = "Lunas";
            }
        } else {
            kembalian = 0;
            sisa = total - bayar;
            if (jenisTransaksi && jenisTransaksi.value === "Pemesanan") {
                const elStatusBayar = document.getElementById("status_pembayaran");
                if (elStatusBayar) elStatusBayar.value = (bayar > 0) ? "DP" : "Belum Bayar";
            }
        }

        const elKembalian = document.getElementById("kembalian");
        const elSisaBayar = document.getElementById("sisa_bayar");
        const elInputSisa = document.getElementById("input_sisa_bayar");

        if (elKembalian) elKembalian.value = "Rp " + formatRupiah(kembalian);
        if (elSisaBayar) elSisaBayar.value = "Rp " + formatRupiah(sisa);
        if (elInputSisa) elInputSisa.value = sisa;
    }


    // ==========================================
    // 3. FITUR KERANJANG BELANJA (POS)
    // ==========================================
    // Live Search Produk
    const searchProduk = document.getElementById("search_produk");
    if (searchProduk) {
        searchProduk.addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            document.querySelectorAll(".item-produk").forEach(function(item) {
                let nama = item.getAttribute("data-nama");
                item.style.display = nama.includes(filter) ? "" : "none";
            });
        });
    }

    // Tambah Barang Ke Keranjang
    // Tambah Barang Ke Keranjang
    document.querySelectorAll(".btn-add-cart").forEach(function(element) {
        element.addEventListener("click", function() {
            let id = this.dataset.id;
            let nama = this.dataset.nama;
            let harga = parseInt(this.dataset.harga) || 0; // Pastikan konversi angka aman
            let stok = parseInt(this.dataset.stok) || 0;

            if (stok <= 0) {
                alert("Stok barang ini telah habis!");
                return;
            }

            if (cartItems[id]) {
                let row = document.getElementById("row_cart_" + id);
                let inputQty = row.querySelector(".qty-input");
                let currentQty = parseInt(inputQty.value) || 0;

                if (currentQty + 1 > stok) {
                    alert("Jumlah melebihi stok yang tersedia! Stok tersisa: " + stok);
                    return;
                }

                inputQty.value = currentQty + 1;
                updateRow(inputQty);
            } else {
                cartItems[id] = true;
                let html = `
                    <tr id="row_cart_${id}">
                        <td>
                            <div class="fw-bold text-truncate" style="max-width: 100px;">${nama}</div>
                            <small class="text-muted">Rp ${harga.toLocaleString('id-ID')}</small>
                            <input type="hidden" name="barang[${itemIndex}][id_barang]" value="${id}">
                            <input type="hidden" name="barang[${itemIndex}][nama_barang]" value="${nama}">
                            <input type="hidden" name="barang[${itemIndex}][harga]" value="${harga}">
                            <input type="hidden" name="barang[${itemIndex}][subtotal]" class="input-subtotal" value="${harga}">
                        </td>
                        <td>
                            <div class="qty-control">
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-minus p-0 px-1"><i class="fas fa-minus small"></i></button>
                                <input type="number" name="barang[${itemIndex}][jumlah]" class="qty-input" value="1" min="1" max="${stok}" data-stok="${stok}">
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-plus p-0 px-1"><i class="fas fa-plus small"></i></button>
                            </div>
                        </td>
                        <td class="subtotal fw-bold text-end">Rp ${harga.toLocaleString('id-ID')}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-link text-danger btn-hapus p-0" data-id="${id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;

                const cartBody = document.getElementById("cart_body");
                if (cartBody) cartBody.insertAdjacentHTML("beforeend", html);
                itemIndex++;

                // Hitung ulang total langsung setelah menambah baris baru
                hitungTotal();
            }
        });
    });

    // Fungsi Hitung Subtotal Baris & Total Belanja
    function updateRow(input) {
        let row = input.closest("tr");
        let hargaInput = row.querySelector("input[name*='[harga]']");
        let harga = parseInt(hargaInput ? hargaInput.value : 0) || 0;
        let qty = parseInt(input.value) || 1;
        let subtotal = harga * qty;

        row.querySelector(".subtotal").innerText = "Rp " + subtotal.toLocaleString('id-ID');
        row.querySelector(".input-subtotal").value = subtotal;
        hitungTotal();
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll(".input-subtotal").forEach(function(item) {
            total += parseInt(item.value) || 0;
        });

        const labelTotal = document.getElementById("label_total");
        const inputTotal = document.getElementById("input_total");

        if (labelTotal) labelTotal.innerText = "Rp " + total.toLocaleString('id-ID');
        if (inputTotal) inputTotal.value = total;

        hitungPembayaran();
    }
    // Delegasi Event Plus, Minus, Hapus & Manual Input Qty
    document.addEventListener("click", function(e) {
        if (e.target.closest(".btn-plus")) {
            let input = e.target.closest("tr").querySelector(".qty-input");
            let stok = parseInt(input.dataset.stok);
            let currentVal = parseInt(input.value) || 0;

            // Validasi Tombol Plus
            if (currentVal + 1 > stok) {
                alert("Jumlah melebihi stok yang tersedia! Stok tersisa: " + stok);
                input.value = stok;
            } else {
                input.value = currentVal + 1;
            }
            updateRow(input);
        }

        if (e.target.closest(".btn-minus")) {
            let input = e.target.closest("tr").querySelector(".qty-input");
            let currentVal = parseInt(input.value) || 0;

            if (currentVal > 1) {
                input.value = currentVal - 1;
                updateRow(input);
            }
        }

        if (e.target.closest(".btn-hapus")) {
            let btn = e.target.closest(".btn-hapus");
            delete cartItems[btn.dataset.id];
            btn.closest("tr").remove();
            hitungTotal();
        }
    });

    // Validasi saat user mengetik jumlah produk secara manual di input field
    document.addEventListener("change", function(e) {
        if (e.target.classList.contains("qty-input")) {
            let input = e.target;
            let stok = parseInt(input.dataset.stok);
            let currentVal = parseInt(input.value) || 1;

            if (currentVal > stok) {
                alert("Jumlah melebihi stok yang tersedia! Stok tersisa: " + stok);
                input.value = stok;
            } else if (currentVal < 1) {
                input.value = 1;
            }
            updateRow(input);
        }
    });

    function updateRow(input) {
        let row = input.closest("tr");
        let harga = parseInt(row.querySelector("input[name*='[harga]']").value);
        let qty = parseInt(input.value) || 1;
        let subtotal = harga * qty;

        row.querySelector(".subtotal").innerText = "Rp " + subtotal.toLocaleString('id-ID');
        row.querySelector(".input-subtotal").value = subtotal;
        hitungTotal();
    }


    // ==========================================
    // 4. ATUR MODE: PENJUALAN vs PEMESANAN
    // ==========================================
    function aturJenisTransaksi() {
        if (!jenisTransaksi) return;

        let isPenjualan = (jenisTransaksi.value === "Penjualan");

        const boxKiri = document.getElementById("box_pemesanan_kiri");
        const boxStatus = document.getElementById("box_status_pemesanan");
        const boxKembalian = document.getElementById("box_kembalian");
        const boxSisa = document.getElementById("box_sisa");
        const modalTitle = document.getElementById("modal_title_text");
        const labelBayar = document.getElementById("label_jumlah_bayar");
        const inputNama = document.getElementById("nama_pelanggan");
        const statusPembayaran = document.getElementById("status_pembayaran");
        const statusTransaksi = document.getElementById("status_transaksi");

        if (boxKiri) boxKiri.style.display = isPenjualan ? "none" : "block";
        if (boxStatus) boxStatus.style.display = isPenjualan ? "none" : "flex";
        if (boxKembalian) boxKembalian.style.display = "block";
        if (boxSisa) boxSisa.style.display = isPenjualan ? "none" : "block";

        if (modalTitle) modalTitle.innerText = isPenjualan ? "Pembayaran Direct POS" : "Pembayaran Pemesanan";
        if (labelBayar) labelBayar.innerText = isPenjualan ? "Jumlah Dibayar" :
            "Uang Diterima / Cash (DP/Pelunasan)";

        if (isPenjualan) {
            if (inputNama && inputNama.value.trim() === "") inputNama.value = "Pelanggan Umum";
            if (statusPembayaran) statusPembayaran.value = "Lunas";
            if (statusTransaksi) statusTransaksi.value = "Selesai";
        } else {
            if (inputNama && inputNama.value === "Pelanggan Umum") inputNama.value = "";
            if (statusPembayaran) statusPembayaran.value = "DP";
            if (statusTransaksi) statusTransaksi.value = "Diproses";
        }

        hitungPembayaran();
    }

    if (jenisTransaksi) {
        jenisTransaksi.addEventListener("change", aturJenisTransaksi);
        aturJenisTransaksi();
    }


    // ==========================================
    // 5. EVENT INPUT RUPIAH & VALIDASI MODAL
    // ==========================================
    const btnLanjut = document.getElementById("btn_lanjut_bayar");
    if (btnLanjut) {
        btnLanjut.addEventListener("click", function() {
            let rows = document.querySelectorAll("#cart_body tr");
            let inputPelanggan = document.getElementById("nama_pelanggan");
            let namaPelanggan = inputPelanggan ? inputPelanggan.value.trim() : "";

            if (rows.length === 0) {
                alert("Keranjang belanjaan masih kosong!");
                return;
            }

            if (jenisTransaksi && jenisTransaksi.value === "Penjualan" && namaPelanggan === "") {
                if (inputPelanggan) inputPelanggan.value = "Pelanggan Umum";
                namaPelanggan = "Pelanggan Umum";
            }

            if (namaPelanggan === "") {
                alert("Harap isi Nama Pelanggan terlebih dahulu!");
                if (inputPelanggan) inputPelanggan.focus();
                return;
            }

            if (modalPembayaran) modalPembayaran.show();
        });
    }

    if (inputTampil) {
        inputTampil.addEventListener("focus", function() {
            if (this.value === "0") this.value = "";
        });

        inputTampil.addEventListener("blur", function() {
            if (this.value.trim() === "") {
                this.value = "0";
                if (inputHidden) inputHidden.value = 0;
                hitungPembayaran();
            }
        });

        inputTampil.addEventListener("input", function() {
            let nominalMurni = this.value.replace(/[^0-9]/g, "");

            if (nominalMurni.length > 1 && nominalMurni.startsWith("0")) {
                nominalMurni = parseInt(nominalMurni, 10).toString();
            }

            if (nominalMurni !== "") {
                if (inputHidden) inputHidden.value = nominalMurni;
                this.value = formatRupiah(nominalMurni);
            } else {
                if (inputHidden) inputHidden.value = 0;
                this.value = "";
            }

            hitungPembayaran();
        });
    }


    // ==========================================
    // 6. ISI TEMPLATE STRUK PRINT
    // ==========================================
    function isiTemplatePrintArea() {
        const pTgl = document.getElementById("p_tgl");
        const pPelanggan = document.getElementById("p_pelanggan");
        const pJenis = document.getElementById("p_jenis");
        const pItems = document.getElementById("p_items");
        const pTotal = document.getElementById("p_total");
        const pBayar = document.getElementById("p_bayar");
        const pKembalian = document.getElementById("p_kembalian");
        const pSisa = document.getElementById("p_sisa");
        const pBoxKembalian = document.getElementById("p_box_kembalian");
        const pBoxSisa = document.getElementById("p_box_sisa");

        const today = new Date();
        const tglFormatted = today.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        if (pTgl) pTgl.innerText = tglFormatted;
        if (pPelanggan) pPelanggan.innerText = document.getElementById("nama_pelanggan")?.value || "-";
        if (pJenis) pJenis.innerText = jenisTransaksi?.value || "Penjualan";

        // Generate Item Tabel Struk
        if (pItems) {
            pItems.innerHTML = "";
            document.querySelectorAll("#cart_body tr").forEach(row => {
                const nama = row.querySelector("input[name*='[nama_barang]']")?.value || "";
                const qty = row.querySelector(".qty-input")?.value || "1";
                const harga = parseFloat(row.querySelector("input[name*='[harga]']")?.value || 0);
                const subtotal = parseFloat(row.querySelector(".input-subtotal")?.value || 0);

                let tr = `
                    <tr>
                        <td colspan="2" class="fw-bold">${nama}</td>
                    </tr>
                    <tr>
                        <td>${qty} x Rp ${formatRupiah(harga)}</td>
                        <td class="text-end">Rp ${formatRupiah(subtotal)}</td>
                    </tr>`;
                pItems.insertAdjacentHTML("beforeend", tr);
            });
        }

        const totalVal = parseFloat(document.getElementById("input_total")?.value || 0);
        const bayarVal = parseFloat(inputHidden?.value || 0);
        const sisaVal = parseFloat(document.getElementById("input_sisa_bayar")?.value || 0);
        const kembalianVal = bayarVal > totalVal ? bayarVal - totalVal : 0;

        if (pTotal) pTotal.innerText = "Rp " + formatRupiah(totalVal);
        if (pBayar) pBayar.innerText = "Rp " + formatRupiah(bayarVal);
        if (pKembalian) pKembalian.innerText = "Rp " + formatRupiah(kembalianVal);
        if (pSisa) pSisa.innerText = "Rp " + formatRupiah(sisaVal);

        if (jenisTransaksi && jenisTransaksi.value === "Pemesanan") {
            if (pBoxSisa) pBoxSisa.style.display = "flex";
        } else {
            if (pBoxSisa) pBoxSisa.style.display = "none";
        }
    }


    // ==========================================
    // 7. PROSES SIMPAN AJAX & VALIDASI PEMBAYARAN
    // ==========================================
    if (formTransaksi) {
        formTransaksi.addEventListener("submit", function(e) {
            e.preventDefault();

            const total = parseFloat(document.getElementById("input_total")?.value) || 0;
            const bayar = parseFloat(inputHidden?.value) || 0;
            const jenis = jenisTransaksi ? jenisTransaksi.value : "Penjualan";

            // Validasi Bayar Kosong / 0
            if (bayar <= 0) {
                alert("Gagal menyimpan! Harap masukkan jumlah uang pembayaran terlebih dahulu.");
                if (inputTampil) {
                    inputTampil.focus();
                    inputTampil.select();
                }
                return false;
            }

            // Validasi Penjualan Kurang Bayar
            if (jenis === "Penjualan" && bayar < total) {
                alert(
                    "Gagal menyimpan! Untuk transaksi Penjualan, jumlah bayar tidak boleh kurang dari total."
                );
                if (inputTampil) {
                    inputTampil.focus();
                    inputTampil.select();
                }
                return false;
            }

            // Isi data ke template preview/print area
            isiTemplatePrintArea();

            const formData = new FormData(formTransaksi);

            fetch("index.php?controller=transaksi&action=create", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    if (modalPembayaran) modalPembayaran.hide();
                    if (modalStruk) modalStruk.show();
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan saat menyimpan transaksi.");
                });
        });
    }


    // ==========================================
    // 8. PROSES SIMPAN AJAX & VALIDASI PELUNASAN
    // ==========================================
    document.querySelectorAll('.form-pelunasan').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const idTrx = this.querySelector('input[name="id_transaksi"]').value;
            const total = parseFloat(this.querySelector('input[name="total_transaksi"]')
                .value) || 0;
            const dp = parseFloat(this.querySelector('input[name="dp_awal"]').value) || 0;
            const sisaAwal = parseFloat(this.querySelector('input[name="sisa_awal"]').value) ||
                0;
            const pelanggan = this.querySelector('input[name="nama_pelanggan"]').value;
            const bayar = parseFloat(this.querySelector('input[name="bayar_pelunasan"]')
                .value) || 0;

            if (bayar < sisaAwal) {
                alert("Jumlah bayar kurang dari sisa tagihan pelunasan!");
                return;
            }

            const kembali = bayar - sisaAwal;
            const today = new Date().toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const fmt = (num) => "Rp " + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Fill Struk Preview Data
            document.getElementById("pln_id_trx").innerText = "#TR" + String(idTrx).padStart(5,
                '0');
            document.getElementById("pln_tgl").innerText = today;
            document.getElementById("pln_pelanggan").innerText = pelanggan;
            document.getElementById("pln_total").innerText = fmt(total);
            document.getElementById("pln_dp").innerText = fmt(dp);
            document.getElementById("pln_sisa_tagihan").innerText = fmt(sisaAwal);
            document.getElementById("pln_bayar").innerText = fmt(bayar);
            document.getElementById("pln_kembali").innerText = fmt(kembali);

            // Send Request via Fetch
            fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Sembunyikan Modal Input Pelunasan
                    const modalInputEl = this.closest('.modal');
                    const modalInputObj = bootstrap.Modal.getInstance(modalInputEl);
                    if (modalInputObj) modalInputObj.hide();

                    // Tampilkan Modal Struk Pelunasan
                    const modalStrukEl = document.getElementById('modalStrukPelunasan');
                    const modalStrukObj = new bootstrap.Modal(modalStrukEl);
                    modalStrukObj.show();
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan saat menyimpan pelunasan.");
                });
        });
    });

    // Event Handler Tombol Cetak & Selesai pada Modal Struk Pelunasan
    document.addEventListener("click", function(e) {
        if (e.target.closest("#btn_cetak_pelunasan")) {
            window.print();
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        }

        if (e.target.closest("#btn_selesai_pelunasan")) {
            window.location.reload();
        }
    });


    // ==========================================
    // 9. AKSI TOMBOL MODAL STRUK (FIX TOMBOL MACET)
    // ==========================================
    // Gunakan Delegasi Event agar tombol selalu merespons kapan pun dipanggil
    document.addEventListener("click", function(e) {

        // A. Tombol Cetak Struk
        if (e.target.closest("#btn_cetak_struk")) {
            // Jalankan perintah print browser
            window.print();

            // Beri jeda sebentar agar proses print dikirim ke sistem sebelum reload halaman
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        }

        // B. Tombol Selesai (Tanpa Cetak)
        if (e.target.closest("#btn_selesai_tanpa_cetak")) {
            window.location.reload();
        }
    });

    // ==========================================
    // 8. NAVIGASI ENTER GLOBAL 3 TAHAP
    // ==========================================
    document.addEventListener("keydown", function(e) {
        if (e.key === "Enter" || e.keyCode === 13) {

            if (document.activeElement.tagName === "TEXTAREA") return;

            e.preventDefault();

            const isModalPembayaranOpen = modalPembayaranEl && modalPembayaranEl.classList.contains(
                "show");
            const isModalStrukOpen = modalStrukEl && modalStrukEl.classList.contains("show");

            if (!isModalPembayaranOpen && !isModalStrukOpen) {
                // ENTER 1: Buka Modal Pembayaran
                if (btnLanjut) btnLanjut.click();

                setTimeout(function() {
                    if (inputTampil) {
                        inputTampil.focus();
                        inputTampil.select();
                    }
                }, 300);

            } else if (isModalPembayaranOpen) {
                // ENTER 2: Submit Form via AJAX
                if (formTransaksi) formTransaksi.requestSubmit();

            } else if (isModalStrukOpen) {
                // ENTER 3: Trigger Cetak Struk
                if (btnCetak) btnCetak.click();
            }
        }
    });

});
</script>