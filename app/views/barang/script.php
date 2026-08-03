<script>
document.getElementById("searchBarang").addEventListener("keyup", function() {

    let keyword = this.value.toLowerCase();

    document.querySelectorAll("#tableBarang tbody tr").forEach(function(row) {

        row.style.display = row.innerText.toLowerCase().includes(keyword) ?
            "" :
            "none";

    });

});

const foto = document.getElementById("foto");

if (foto) {

    foto.addEventListener("change", function(e) {

        const file = e.target.files[0];

        if (file) {

            document.getElementById("previewFoto").src =
                URL.createObjectURL(file);

        }

    });

}


// Modal ubah
document.querySelectorAll(".fotoEdit").forEach(function(input) {

    input.addEventListener("change", function(e) {

        const file = e.target.files[0];

        if (file) {

            const preview = document.getElementById(
                this.dataset.preview
            );

            preview.src = URL.createObjectURL(file);

        }

    });

});
</script>