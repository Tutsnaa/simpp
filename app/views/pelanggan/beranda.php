<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/beranda.css?v=<?= time(); ?>">

    <title>Beranda Pelanggan - SIMPP</title>
</head>

<body>


    <!-- Navbar Pelanggan -->
    <nav class="navbar navbar-expand-lg">

        <div class="container">

            <a class="navbar-brand fw-bold">
                SIMPP
            </a>


            <div class="user-menu">

                <span>
                    Halo,
                    <strong><?= $_SESSION['nama']; ?></strong>
                </span>


                <a href="index.php?controller=auth&action=logout" class="btn btn-logout">

                    Logout

                </a>

            </div>

        </div>

    </nav>



    <div class="container mt-5">


        <h3 class="welcome">

            Selamat Datang,
            <?= $_SESSION['nama']; ?>

        </h3>



        <!-- Ringkasan Pesanan -->
        <div class="row mt-4">


            <div class="col-md-4">

                <div class="summary-card">

                    <h2>5</h2>

                    <p>
                        Pesanan Saya
                    </p>

                </div>

            </div>



            <div class="col-md-4">

                <div class="summary-card">

                    <h2>2</h2>

                    <p>
                        Sedang Diproses
                    </p>

                </div>

            </div>



            <div class="col-md-4">

                <div class="summary-card">

                    <h2>3</h2>

                    <p>
                        Pesanan Selesai
                    </p>

                </div>

            </div>


        </div>




        <!-- Produk -->
        <h4 class="section-title mt-5">
            Produk Terbaru
        </h4>



        <div class="row mt-3">


            <div class="col-md-3">

                <div class="product-card">


                    <img src="assets/images/no-image.png">


                    <div class="product-body">

                        <h6>
                            Nama Produk
                        </h6>


                        <p class="price">
                            Rp25.000
                        </p>


                        <button class="btn btn-pesan">

                            Pesan

                        </button>


                    </div>


                </div>


            </div>


        </div>


    </div>



</body>

</html>