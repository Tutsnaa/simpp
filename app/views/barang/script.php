<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchBarang");
    const filterKategori = document.getElementById("filterKategori");
    const filterStatus = document.getElementById("filterStatus");

    function filterTable() {
        const keyword = searchInput ? searchInput.value.toLowerCase().trim() : "";
        const selectedKategori = filterKategori ? filterKategori.value.toLowerCase().trim() : "";
        const selectedStatus = filterStatus ? filterStatus.value.toLowerCase().trim() : "";

        document.querySelectorAll("#tableBarang tbody tr").forEach(function(row) {
            // Mengambil teks kolom
            const namaBarang = row.cells[1] ? row.cells[1].innerText.toLowerCase() : "";
            const kategori = row.cells[2] ? row.cells[2].innerText.toLowerCase() : "";
            const status = row.cells[5] ? row.cells[5].innerText.toLowerCase() : "";

            // Cek Pencarian Keyword (Baris secara umum ATAU nama barang)
            const matchSearch = keyword === "" || row.innerText.toLowerCase().includes(keyword);

            // Cek Filter Kategori
            const matchKategori = selectedKategori === "" ||
                selectedKategori.includes("semua kategori") ||
                kategori.includes(selectedKategori);

            // Cek Filter Status
            const matchStatus = selectedStatus === "" ||
                selectedStatus.includes("semua status") ||
                status.includes(selectedStatus);

            // Tampilkan jika semua kondisi terpenuhi
            if (matchSearch && matchKategori && matchStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    if (searchInput) searchInput.addEventListener("keyup", filterTable);
    if (filterKategori) filterKategori.addEventListener("change", filterTable);
    if (filterStatus) filterStatus.addEventListener("change", filterTable);

    // Preview Foto Modal Tambah
    const foto = document.getElementById("foto");
    if (foto) {
        foto.addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                const previewFoto = document.getElementById("previewFoto");
                if (previewFoto) previewFoto.src = URL.createObjectURL(file);
            }
        });
    }

    // Preview Foto Modal Ubah
    document.querySelectorAll(".fotoEdit").forEach(function(input) {
        input.addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (file) {
                const preview = document.getElementById(this.dataset.preview);
                if (preview) preview.src = URL.createObjectURL(file);
            }
        });
    });
});
</script>