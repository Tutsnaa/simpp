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

document.querySelectorAll(".toggle-password").forEach(function(button) {

    button.addEventListener("click", function() {

        let target = document.getElementById(this.dataset.target);

        let icon = this.querySelector("i");

        if (target.type === "password") {

            target.type = "text";

            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");

        } else {

            target.type = "password";

            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");

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