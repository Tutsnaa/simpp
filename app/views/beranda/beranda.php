<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - SIMPP</title>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        background: #f4f4f4;
    }

    header {
        background: #ff9644;
        color: #fff;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .container {
        width: 90%;
        margin: 30px auto;
    }

    .card {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .1);
    }

    h2 {
        margin-bottom: 10px;
    }

    a {
        text-decoration: none;
        color: #fff;
        background: #d9534f;
        padding: 10px 18px;
        border-radius: 5px;
    }

    a:hover {
        background: #c9302c;
    }
    </style>
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