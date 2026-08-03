    <!-- Header -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body d-flex justify-content-between align-items-center">

            <div>

                <h3 class="fw-bold mb-1">
                    Data Barang
                </h3>

                <p class="text-muted mb-0">
                    Kelola seluruh data barang toko
                </p>

            </div>

            <button class="btn btn-success rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">

                <i class="bi bi-plus-circle me-2"></i>

                Tambah Barang

            </button>

        </div>

    </div>


    <!-- Filter -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-lg-4">

                    <input type="text" id="searchBarang" class="form-control" placeholder="Cari barang...">

                </div>

                <div class="col-lg-3">

                    <select class="form-select">

                        <option value="">Semua Kategori</option>

                        <?php foreach($kategori as $k): ?>

                        <option value="<?= $k['nama_kategori']; ?>">

                            <?= $k['nama_kategori']; ?>

                        </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="col-lg-3">

                    <select class="form-select">

                        <option>Semua Status</option>
                        <option>Tersedia</option>
                        <option>Habis</option>

                    </select>

                </div>

                <div class="col-lg-2 text-end">

                    <span class="badge bg-success">

                        Total <?= count($barang) ?> Barang

                    </span>

                </div>

            </div>

        </div>

    </div>


    <!-- Tabel -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0" id="tableBarang">

                <thead style="background:#2b5748;color:white">

                    <tr>

                        <th>Foto</th>

                        <th>Nama Barang</th>

                        <th>Kategori</th>

                        <th>Stok</th>

                        <th>Harga Beli</th>

                        <th>Harga Jual</th>

                        <th>Status</th>

                        <th class="text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($barang as $row): ?>

                    <tr>

                        <td>

                            <?php if($row['foto']) : ?>

                            <img src="assets/img/barang/<?= $row['foto']; ?>" width="60" height="60"
                                class="rounded border" style="object-fit:cover;">

                            <?php else : ?>

                            <img src="assets/img/no-image.png" width="60" class="rounded border">

                            <?php endif; ?>

                        </td>

                        <td>

                            <strong><?= $row['nama_barang']; ?></strong>

                        </td>

                        <td>

                            <?= $row['nama_kategori']; ?>

                        </td>

                        <td>

                            <?= $row['jumlah']; ?>

                        </td>

                        <td>

                            Rp <?= number_format($row['harga_beli'],0,",","."); ?>

                        </td>

                        <td>

                            Rp <?= number_format($row['harga_jual'],0,",","."); ?>

                        </td>

                        <td>

                            <?php if($row['status']=="Tersedia"): ?>

                            <span class="badge bg-success">

                                Tersedia

                            </span>

                            <?php else: ?>

                            <span class="badge bg-danger">

                                Habis

                            </span>

                            <?php endif; ?>

                        </td>

                        <td class="text-center">

                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#edit<?= $row['id_barang']; ?>">

                                <i class="bi bi-pencil"></i>

                            </button>

                            <a href="index.php?controller=barang&action=delete&id=<?= $row['id_barang']; ?>"
                                class="btn btn-danger btn-sm" onclick="return confirm('Hapus barang?')">

                                <i class="bi bi-trash"></i>

                            </a>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>



    <?php require "modal_tambah.php"; ?>

    <?php require "modal_ubah.php"; ?>

    <?php require "script.php"; ?>