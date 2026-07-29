<nav class="navbar bg-white shadow-sm">

    <div class="container-fluid justify-content-end">

        <div class="d-flex align-items-center">

            <span class="me-3 fw-semibold">
                <?= $_SESSION['nama']; ?>
            </span>

            <img src="<?= !empty($_SESSION['foto']) ? 'assets/img/profil/' . $_SESSION['foto'] : 'assets/img/default.png'; ?>"
                class="profile-img rounded-circle">

        </div>

    </div>

</nav>