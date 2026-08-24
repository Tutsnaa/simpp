<script>
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

// Modal Ubah Kata Sandi
// ==========================
// Show / Hide Password
// ==========================

document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        const icon = this.querySelector('.material-symbols-outlined');

        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off'; // Mengubah ke ikon mata dicoret
        } else {
            input.type = 'password';
            icon.textContent = 'visibility'; // Mengubah ke ikon mata biasa
        }
    });
});


// ==========================
// Konfirmasi Password
// ==========================

const passwordBaru = document.getElementById("passwordBaru");
const konfirmasi = document.getElementById("konfirmasiPassword");
const message = document.getElementById("passwordMessage");

function cekPassword() {

    if (konfirmasi.value === "") {

        message.innerHTML = "";
        return;

    }

    if (passwordBaru.value === konfirmasi.value) {

        message.innerHTML =
            '<div class="alert alert-success py-2 mb-0">' +
            '<i class="fas fa-check-circle me-2"></i>' +
            'Konfirmasi kata sandi sesuai.' +
            '</div>';

    } else {

        message.innerHTML =
            '<div class="alert alert-danger py-2 mb-0">' +
            '<i class="fas fa-times-circle me-2"></i>' +
            'Konfirmasi kata sandi tidak sama.' +
            '</div>';

    }

}

passwordBaru.addEventListener("keyup", cekPassword);
konfirmasi.addEventListener("keyup", cekPassword);
</script>