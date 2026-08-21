<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="assets/css/login.css?v=<?= time(); ?>">

    <title>Login - SIMPP</title>
</head>

<body class="bg-light">

    <div class="container vh-100 d-flex justify-content-center align-items-center">

        <div class="card shadow-lg border-0" style="max-width:420px; width:100%;">

            <div class="card-body p-5">

                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success-custom">SIMPP</h2>
                    <!-- <p class="text-muted mb-0">
                        Sistem Manajemen Pemesanan dan Penjualan Produk
                    </p> -->
                </div>

                <?php if(isset($_GET['error'])) : ?>
                <div class="alert alert-danger">
                    Nama Pengguna atau Kata Sandi salah.
                </div>
                <?php endif; ?>

                <form action="index.php?controller=auth&action=login" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-control" name="nama_pengguna"
                            placeholder="Masukkan nama pengguna" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control" name="kata_sandi" placeholder="Masukkan kata sandi"
                            required>
                    </div>

                    <button class="btn btn-success-custom w-100">
                        Login
                    </button>

                </form>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>