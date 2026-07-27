<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/Beranda.css">
    <title>Beranda - SIMPP</title>
</head>

<body>

    <header>
        <h2>SIMPP</h2>

        <a href="index.php?controller=auth&action=logout">
            Logout
        </a>
    </header>

    <div class="container">

        <div class="card">

            <h2>Selamat Datang</h2>

            <p>
                Halo,
                <strong><?= $_SESSION['nama']; ?></strong>
            </p>

            <br>

            <p>
                Role :
                <strong><?= $_SESSION['role']; ?></strong>
            </p>

            <br>

            <p>
                Selamat datang di Sistem Manajemen Pemesanan dan Penjualan Produk pada Toko.
            </p>

        </div>

    </div>

</body>

</html>