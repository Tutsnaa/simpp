<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchPengguna = document.getElementById('searchPengguna');
    const filterStatusPengguna = document.getElementById('filterStatusPengguna');

    // Sesuaikan selector '#tablePengguna' dengan ID atau tag <tbody> di tabel pengguna Anda
    const tableRows = document.querySelectorAll('tbody tr');

    function applyFilterPengguna() {
        const querySearch = searchPengguna.value.toLowerCase().trim();
        const selectedStatus = filterStatusPengguna.value.toLowerCase().trim();

        tableRows.forEach(row => {
            // Abaikan jika baris data kosong
            if (row.children.length <= 1) return;

            // Membaca seluruh teks di baris pengguna dan teks pada kolom status
            const rowText = row.textContent.toLowerCase();
            const statusText = row.children[5]?.textContent.toLowerCase().trim() ||
            ''; // Sesuaikan urutan indeks kolom status Anda

            const matchSearch = querySearch === '' || rowText.includes(querySearch);
            const matchStatus = selectedStatus === '' || statusText.includes(selectedStatus);

            if (matchSearch && matchStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchPengguna) searchPengguna.addEventListener('input', applyFilterPengguna);
    if (filterStatusPengguna) filterStatusPengguna.addEventListener('change', applyFilterPengguna);
});
</script>