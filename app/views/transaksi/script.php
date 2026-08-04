<!-- BOOTSTRAP 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let itemIndex = 0;
let cartItems = {};

// ELEMEN INTERAKSI PEMBAYARAN (DIDEKLARASIKAN DI ATAS AGAR BEBAS ERROR INITIALIZATION)
const inputTampil = document.getElementById("jumlah_bayar_tampil");
const inputHidden = document.getElementById("jumlah_bayar");
const jenisTransaksi = document.getElementById("jenis_transaksi");

// HELPER FORMAT RUPIAH
function formatRupiah(angka) {
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// FUNGSI HITUNG PEMBAYARAN
function hitungPembayaran() {
    const total = parseFloat(document.getElementById("input_total").value) || 0;
    const bayar = parseFloat(inputHidden.value) || 0;

    let kembalian = 0;
    let sisa = 0;

    if (bayar >= total) {
        kembalian = bayar - total;
        sisa = 0;
        if (jenisTransaksi.value === "Pemesanan") {
            document.getElementById("status_pembayaran").value = "Lunas";
        }
    } else {
        kembalian = 0;
        sisa = total - bayar;
        if (jenisTransaksi.value === "Pemesanan") {
            document.getElementById("status_pembayaran").value = (bayar > 0) ? "DP" : "Belum Bayar";
        }
    }

    document.getElementById("kembalian").value = "Rp " + formatRupiah(kembalian);
    document.getElementById("sisa_bayar").value = "Rp " + formatRupiah(sisa);
    document.getElementById("input_sisa_bayar").value = sisa;
}

// 1. CARI PRODUK (LIVE SEARCH)
document.getElementById("search_produk").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let items = document.querySelectorAll(".item-produk");

    items.forEach(function(item) {
        let nama = item.getAttribute("data-nama");
        item.style.display = nama.includes(filter) ? "" : "none";
    });
});

// 2. TAMBAH BARANG KE KERANJANG
document.querySelectorAll(".btn-add-cart").forEach(function(element) {
    element.addEventListener("click", function() {
        let id = this.dataset.id;
        let nama = this.dataset.nama;
        let harga = parseInt(this.dataset.harga);

        if (cartItems[id]) {
            let row = document.getElementById("row_cart_" + id);
            let inputQty = row.querySelector(".qty-input");
            inputQty.value = parseInt(inputQty.value) + 1;
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
                                <input type="number" name="barang[${itemIndex}][jumlah]" class="qty-input" value="1" min="1">
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

            document.getElementById("cart_body").insertAdjacentHTML("beforeend", html);
            itemIndex++;
        }

        hitungTotal();
    });
});

// 3. UBAH QTY & HAPUS ITEM
document.addEventListener("click", function(e) {
    if (e.target.closest(".btn-plus")) {
        let input = e.target.closest("tr").querySelector(".qty-input");
        input.value = parseInt(input.value) + 1;
        updateRow(input);
    }

    if (e.target.closest(".btn-minus")) {
        let input = e.target.closest("tr").querySelector(".qty-input");
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
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

function updateRow(input) {
    let row = input.closest("tr");
    let harga = parseInt(row.querySelector("input[name*='[harga]']").value);
    let qty = parseInt(input.value);
    let subtotal = harga * qty;

    row.querySelector(".subtotal").innerText = "Rp " + subtotal.toLocaleString('id-ID');
    row.querySelector(".input-subtotal").value = subtotal;

    hitungTotal();
}

// 4. HITUNG TOTAL BELANJA
function hitungTotal() {
    let total = 0;
    document.querySelectorAll(".input-subtotal").forEach(function(item) {
        total += parseInt(item.value) || 0;
    });

    document.getElementById("label_total").innerText = "Rp " + total.toLocaleString('id-ID');
    document.getElementById("input_total").value = total;

    hitungPembayaran();
}

// 5. ATUR MODE: PENJUALAN vs PEMESANAN
function aturJenisTransaksi() {
    let isPenjualan = (jenisTransaksi.value === "Penjualan");

    // Tampilkan/Sembunyikan Form Pemesanan
    document.getElementById("box_pemesanan_kiri").style.display = isPenjualan ? "none" : "block";
    document.getElementById("box_sisa").style.display = isPenjualan ? "none" : "block";
    document.getElementById("box_status_pemesanan").style.display = isPenjualan ? "none" : "flex";

    // Sembunyikan/Tampilkan Kembalian
    document.getElementById("box_kembalian").style.display = isPenjualan ? "block" : "none";

    // Atur Judul Modal
    document.getElementById("modal_title_text").innerText = isPenjualan ? "Pembayaran Direct POS" :
        "Pembayaran Pemesanan";
    document.getElementById("label_jumlah_bayar").innerText = isPenjualan ? "Jumlah Dibayar" :
        "Jumlah Dibayar (DP / Pelunasan)";
    if (isPenjualan) {
        let inputNama = document.getElementById("nama_pelanggan");
        if (inputNama.value.trim() === "") {
            inputNama.value = "Pelanggan Umum";
        }
        document.getElementById("status_pembayaran").value = "Lunas";
        document.getElementById("status_transaksi").value = "Selesai";
    } else {
        if (document.getElementById("nama_pelanggan").value === "Pelanggan Umum") {
            document.getElementById("nama_pelanggan").value = "";
        }
        document.getElementById("status_pembayaran").value = "DP";
        document.getElementById("status_transaksi").value = "Diproses";
    }

    hitungPembayaran();
}

jenisTransaksi.addEventListener("change", aturJenisTransaksi);
aturJenisTransaksi();

// 6. MODAL PEMBAYARAN & VALIDASI
const modalPembayaran = new bootstrap.Modal(document.getElementById('modalPembayaran'));
document.getElementById("btn_lanjut_bayar").addEventListener("click", function() {
    let rows = document.querySelectorAll("#cart_body tr");
    let inputPelanggan = document.getElementById("nama_pelanggan");
    let namaPelanggan = inputPelanggan.value.trim();

    if (rows.length === 0) {
        alert("Keranjang belanjaan masih kosong!");
        return;
    }

    if (jenisTransaksi.value === "Penjualan" && namaPelanggan === "") {
        inputPelanggan.value = "Pelanggan Umum";
        namaPelanggan = "Pelanggan Umum";
    }

    if (namaPelanggan === "") {
        alert("Harap isi Nama Pelanggan terlebih dahulu!");
        inputPelanggan.focus();
        return;
    }

    modalPembayaran.show();
});

// 7. FORMAT NOMINAL RUPIAH & EVENT INPUT
inputTampil.addEventListener("focus", function() {
    if (this.value === "0") this.value = "";
});

inputTampil.addEventListener("blur", function() {
    if (this.value.trim() === "") {
        this.value = "0";
        inputHidden.value = 0;
        hitungPembayaran();
    }
});

inputTampil.addEventListener("input", function() {
    let nominalMurni = this.value.replace(/[^0-9]/g, "");

    if (nominalMurni.length > 1 && nominalMurni.startsWith("0")) {
        nominalMurni = parseInt(nominalMurni, 10).toString();
    }

    if (nominalMurni !== "") {
        inputHidden.value = nominalMurni;
        this.value = formatRupiah(nominalMurni);
    } else {
        inputHidden.value = 0;
        this.value = "";
    }

    hitungPembayaran();
});

// EVENT ENTER GLOBAL UNTUK BUKA MODAL & SIMPAN TRANSAKSI
document.addEventListener("keydown", function(e) {
    // Cek apakah tombol yang ditekan adalah Enter (Key Code 13)
    if (e.key === "Enter" || e.keyCode === 13) {

        // 1. Jika fokus sedang di textarea catatan, biarkan Enter berfungsi normal (buat baris baru)
        if (document.activeElement.tagName === "TEXTAREA") {
            return;
        }

        // Cegah perilaku default form submit otomatis saat tekan Enter
        e.preventDefault();

        const modalEl = document.getElementById("modalPembayaran");
        const isModalOpen = modalEl.classList.contains("show");

        if (!isModalOpen) {
            // ENTER KE-1: Jika modal belum terbuka, pemicu tombol "Lanjut Pembayaran"
            document.getElementById("btn_lanjut_bayar").click();

            // Fokuskan otomatis kursor ke input jumlah bayar agar user bisa langsung ketik angka
            setTimeout(function() {
                inputTampil.focus();
                inputTampil.select(); // Pilih semua teks '0' agar langsung tertimpa saat diketik
            }, 300); // Tunda sedikit sampai modal selesai animasi muncul

        } else {
            // ENTER KE-2: Jika modal sudah terbuka, pemicu submit / tombol "Simpan Transaksi"
            document.getElementById("form_transaksi").submit();
        }
    }
});
</script>