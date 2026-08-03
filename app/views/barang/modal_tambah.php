<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <form action="index.php?controller=barang&action=create" method="POST" enctype="multipart/form-data">

                <!-- Header -->
                <div class="modal-header text-white" style="background:#2b5748;">

                    <h5 class="modal-title">

                        <i class="bi bi-box-seam me-2"></i>

                        Tambah Barang

                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- Body -->
                <div class="modal-body">

                    <div class="row">

                        <!-- ========================= -->
                        <!-- KOLOM KIRI -->
                        <!-- ========================= -->

                        <div class="col-lg-6">

                            <!-- Foto -->

                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Foto Barang

                                </label>

                                <div class="text-center mb-3">

                                    <img src="assets/img/no-image.png" id="previewFoto" class="img-thumbnail rounded-3"
                                        style="width:220px;height:220px;object-fit:cover;">

                                </div>

                                <input type="file" class="form-control" name="foto" id="foto" accept="image/*">

                                <small class="text-muted">

                                    Format JPG, PNG atau WEBP

                                </small>

                            </div>

                            <!-- Nama -->

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Nama Barang

                                </label>

                                <input type="text" class="form-control" name="nama_barang"
                                    placeholder="Masukkan nama barang" required>

                            </div>

                            <!-- Kategori -->

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Kategori

                                </label>

                                <select class="form-select" name="id_kategori" required>

                                    <option value="">

                                        -- Pilih Kategori --

                                    </option>

                                    <?php foreach($kategori as $k): ?>

                                    <option value="<?= $k['id_kategori']; ?>">

                                        <?= $k['nama_kategori']; ?>

                                    </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>

                        <!-- ========================= -->
                        <!-- KOLOM KANAN -->
                        <!-- ========================= -->

                        <div class="col-lg-6">

                            <!-- Jumlah -->

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Jumlah Stok

                                </label>

                                <input type="number" class="form-control" name="jumlah" min="0" value="0" required>

                            </div>

                            <!-- Harga Beli -->

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Harga Beli

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        Rp

                                    </span>

                                    <input type="number" class="form-control" name="harga_beli" min="0" placeholder="0"
                                        required>

                                </div>

                            </div>

                            <!-- Harga Jual -->

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Harga Jual

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        Rp

                                    </span>

                                    <input type="number" class="form-control" name="harga_jual" min="0" placeholder="0"
                                        required>

                                </div>

                            </div>

                            <!-- Status -->

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Status Barang

                                </label>

                                <select class="form-select" name="status" required>

                                    <option value="Tersedia">

                                        Tersedia

                                    </option>

                                    <option value="Habis">

                                        Habis

                                    </option>

                                </select>

                            </div>

                            <!-- Card Ringkasan -->

                            <div class="card border-0 bg-light mt-4">

                                <div class="card-body">

                                    <h6 class="fw-bold">

                                        Informasi

                                    </h6>

                                    <ul class="small mb-0">

                                        <li>
                                            Pastikan nama barang tidak duplikat.
                                        </li>

                                        <li>
                                            Upload foto agar produk mudah dikenali.
                                        </li>

                                        <li>
                                            Gunakan harga tanpa titik atau koma.
                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Footer -->

                <div class="modal-footer">

                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="reset" class="btn btn-warning">

                        Reset

                    </button>

                    <button type="submit" class="btn text-white" style="background:#2b5748;">

                        <i class="bi bi-check-circle me-1"></i>

                        Simpan Barang

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>