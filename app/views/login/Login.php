<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/Login.css">
    <title>Login - SIMPP</title>

</head>

<body>

    <div class="login-box">

        <h2>Login</h2>
        <p>Sistem Manajemen Pemesanan dan Penjualan Produk</p>

        <?php if(isset($_GET['error'])) : ?>
        <div class="error">
            Nama Pengguna atau Kata Sandi salah.
        </div>
        <?php endif; ?>

        <form action="index.php?controller=auth&action=login" method="POST">

            <div class="form-group">
                <label>Nama Pengguna</label>
                <input type="text" name="nama_pengguna" placeholder="Masukkan nama pengguna" required>
            </div>

            <div class="form-group">
                <label>Kata Sandi</label>
                <input type="password" name="kata_sandi" placeholder="Masukkan kata sandi" required>
            </div>

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</body>

</html>