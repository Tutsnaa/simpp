<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMPP</title>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        background: #f5f5f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-box {
        width: 380px;
        background: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, .1);
    }

    .login-box h2 {
        text-align: center;
        margin-bottom: 10px;
    }

    .login-box p {
        text-align: center;
        color: #666;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 15px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #ff9644;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background: #e88436;
    }

    .error {
        background: #ffe5e5;
        color: red;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        text-align: center;
    }
    </style>

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