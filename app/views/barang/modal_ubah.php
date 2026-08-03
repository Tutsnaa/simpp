<?php foreach ($barang as $row): ?>

<div class="modal fade" id="edit<?= $row['id_barang']; ?>" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <form action="index.php?controller=barang&action=update" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id_barang" value="<?= $row['id_barang']; ?>">

                <div class="modal-header text-white" style="background:#2b5748;">

                    <h5 class="modal-title">

                        <i class="bi bi-pencil-square me-2"></i>

                        Ubah Barang

                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <!-- ========================= -->
                        <!-- KOLOM KIRI -->
                        <!-- ========================= -->

                        <div class="col-lg-6">

                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Foto Barang

                                </label>

                                <div class="text-center mb-3">

                                    <?php if (!empty($row['foto'])): ?>

                                    <img src="assets/img/barang/<?= $row['foto']; ?>"
                                        id="preview<?= $row['id_barang']; ?>" class="img-thumbnail rounded-3"
                                        style="width:220px;height:220px;object-fit:cover;">

                                    <?php else: ?>

                                    <img src="assets/img/no-image.png" id="preview<?= $row['id_barang']; ?>"
                                        class="img-thumbnail rounded-3"
                                        style="width:220px;height:220px;object-fit:cover;">

                                    <?php endif; ?>

                                </div>

                                <input type="file" class="form-control fotoEdit"
                                    data-preview="preview<?= $row['id_barang']; ?>" name="foto" accept="image/*">

                                <small class="text-muted">

                                    Kosongkan jika tidak ingin mengganti foto.

                                </small>

                            </div>

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Nama Barang

                                </label>

                                <input type="text" class="form-control" name="nama_barang"
                                    value="<?= htmlspecialchars($row['nama_barang']); ?>" required>

                            </div>

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Kategori

                                </label>

                                <select class="form-select" name="id_kategori" required>

                                    <?php foreach ($kategori as $k): ?>

                                    <option value="<?= $k['id_kategori']; ?>"
                                        <?= ($row['id_kategori'] == $k['id_kategori']) ? 'selected' : ''; ?>>

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

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Jumlah Stok

                                </label>

                                <input type="number" class="form-control" name="jumlah" value="<?= $row['jumlah']; ?>"
                                    min="0" required>

                            </div>

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Harga Beli

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        Rp

                                    </span>

                                    <input type="number" class="form-control" name="harga_beli"
                                        value="<?= $row['harga_beli']; ?>" min="0" required>

                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Harga Jual

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        Rp

                                    </span>

                                    <input type="number" class="form-control" name="harga_jual"
                                        value="<?= $row['harga_jual']; ?>" min="0" required>

                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Status Barang

                                </label>

                                <select class="form-select" name="status" required>

                                    <option value="Tersedia" <?= ($row['status'] == "Tersedia") ? "selected" : ""; ?>>

                                        Tersedia

                                    </option>

                                    <option value="Habis" <?= ($row['status'] == "Habis") ? "selected" : ""; ?>>

                                        Habis

                                    </option>

                                </select>

                            </div>

                            <div class="card bg-light border-0 mt-4">

                                <div class="card-body">

                                    <h6 class="fw-bold">

                                        Informasi Barang

                                    </h6>

                                    <table class="table table-borderless table-sm mb-0">

                                        <tr>

                                            <td width="130">

                                                ID Barang

                                            </td>

                                            <td>

                                                : <?= $row['id_barang']; ?>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>

                                                Dibuat

                                            </td>

                                            <td>

                                                : <?= date("d M Y H:i", strtotime($row['tanggal_dibuat'])); ?>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>

                                                Diubah

                                            </td>

                                            <td>

                                                : <?= date("d M Y H:i", strtotime($row['tanggal_diubah'])); ?>

                                            </td>

                                        </tr>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit" class="btn text-white" style="background:#2b5748;">

                        <i class="bi bi-check-circle me-1"></i>

                        Ubah Barang

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php endforeach; ?>