<script>
document
    .getElementById("searchKategori")
    .addEventListener("keyup", function() {

        let value = this.value.toLowerCase();

        document.querySelectorAll("tbody tr").forEach(function(row) {

            row.style.display =
                row.innerText.toLowerCase().includes(value) ?
                "" :
                "none";

        });

    });
</script>