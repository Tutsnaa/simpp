<?php
$controller = $_GET['controller'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';
?>
<div class="sidebar">

    <!-- Nama Toko -->
    <div class="title">
        <h1>SIMPP</h1>
    </div>

    <div>
        <img src="<?= !empty($_SESSION['foto']) ? 'assets/img/profil/' . $_SESSION['foto'] : 'assets/img/default.png'; ?>"
            class="profile-img rounded-circle">
        <div class="sidebar-title">
            <span class=" fw-semibold">
                <?= $_SESSION['nama']; ?>
            </span>
        </div>

        <!-- Menu -->
        <ul class="nav flex-column menu">

            <li class="nav-item">
                <a href="index.php?controller=dashboard&action=index"
                    class="nav-link <?= ($controller == 'dashboard') ? 'active' : ''; ?>">
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?controller=kategori&action=index"
                    class="nav-link <?= ($controller == 'kategori' && $action == 'index') ? 'active' : ''; ?>">
                    Kategori
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?controller=barang&action=index"
                    class="nav-link <?= ($controller == 'barang'&& $action == 'index') ? 'active' : ''; ?>">
                    Barang
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?controller=pemesanan&action=index"
                    class="nav-link <?= ($controller == 'pemesanan' && $action == 'index') ? 'active' : ''; ?>">
                    Pemesanan
                </a>
            </li>

            <li class="nav-item">
                <a href="index.php?controller=banner&action=index"
                    class="nav-link <?= ($controller == 'banner' && $action == 'index') ? 'active' : ''; ?>">
                    Banner
                </a>
            </li>

        </ul>

    </div>

    <!-- Menu Bawah -->
    <ul class="nav flex-column sidebar-bottom">

        <li class="nav-item">
            <a href="index.php?controller=pengguna&action=profil"
                class="nav-link <?= ($controller == 'pengguna' && $action == 'profil') ? 'active' : ''; ?>">
                Profil
            </a>
        </li>

        <li class="nav-item">
            <a href="index.php?controller=auth&action=logout" class="nav-link">
                Logout
            </a>
        </li>

    </ul>

</div>