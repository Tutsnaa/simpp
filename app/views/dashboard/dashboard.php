<?php require_once "app/views/layout/header.php"; ?>

<?php require_once "app/views/layout/sidebar.php"; ?>

<div class="content flex-grow-1">

    <?php require_once "app/views/layout/navbar.php"; ?>

    <div class="container-fluid mt-4">

        <?php if ($_SESSION['role'] == 'SuperAdmin') : ?>

        <h3>Dashboard Super Admin</h3>

        <?php elseif ($_SESSION['role'] == 'Admin') : ?>

        <h3>Dashboard Admin</h3>

        <?php elseif ($_SESSION['role'] == 'Pegawai') : ?>

        <h3>Dashboard Pegawai</h3>

        <?php endif; ?>

    </div>

</div>

<?php require_once "app/views/layout/footer.php"; ?>