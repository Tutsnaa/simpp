<div class="modal fade" id="modalEditProfil" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <form action="index.php?controller=pengguna&action=updateProfil" method="POST"
                enctype="multipart/form-data">

                <input type="hidden" name="id_pengguna" value="<?= $pengguna['id_pengguna']; ?>">

                <!-- Header -->

                <div class="modal-header text-white" style="background:#2b5748;">

                    <h5 class="modal-title">

                        <i class="fas fa-user-edit me-2"></i>

                        Edit Profil

                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- Body -->

                <div class="modal-body">

                    <div class="row">

                        <!-- ========================= -->
                        <!-- FOTO -->
                        <!-- ========================= -->

                        <div class="col-lg-4">

                            <div class="text-center">

                                <img id="previewFoto" src="<?= $foto; ?>" class="rounded-circle border shadow" style="width:220px;
                                           height:220px;
                                           object-fit:cover;">

                                <div class="mt-4">

                                    <input type="file" class="form-control" id="foto" name="foto"
                                        accept=".jpg,.jpeg,.png,.webp">

                                    <small class="text-muted">

                                        JPG, PNG atau WEBP

                                    </small>

                                </div>

                            </div>

                        </div>

                        <!-- ========================= -->
                        <!-- FORM -->
                        <!-- ========================= -->

                        <div class="col-lg-8">

                            <div class="row">

                                <!-- Nama -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Nama Lengkap

                                    </label>

                                    <input type="text" class="form-control" name="nama"
                                        value="<?= htmlspecialchars($pengguna['nama']); ?>" required>

                                </div>

                                <!-- Username -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Nama Pengguna

                                    </label>

                                    <input type="text" class="form-control" name="nama_pengguna"
                                        value="<?= htmlspecialchars($pengguna['nama_pengguna']); ?>" required>

                                </div>

                                <!-- Email -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Email

                                    </label>

                                    <input type="email" class="form-control" name="email"
                                        value="<?= htmlspecialchars($pengguna['email']); ?>" required>

                                </div>

                                <!-- Telepon -->

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Nomor Telepon

                                    </label>

                                    <input type="text" class="form-control" name="no_telepon"
                                        value="<?= htmlspecialchars($pengguna['no_telepon']); ?>" required>

                                </div>

                                <!-- Alamat -->

                                <div class="col-12 mb-3">

                                    <label class="form-label">

                                        Alamat

                                    </label>

                                    <textarea class="form-control" rows="5" name="alamat"
                                        required><?= htmlspecialchars($pengguna['alamat']); ?></textarea>

                                </div>

                                <!-- Informasi -->

                                <div class="col-12">

                                    <div class="alert alert-light border mb-0">

                                        <i class="fas fa-circle-info text-success me-2"></i>

                                        Role dan Status akun hanya dapat diubah melalui menu
                                        <strong>Data Pengguna</strong>.

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Footer -->

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        <i class="fas fa-times me-2"></i>

                        Batal

                    </button>

                    <button type="reset" class="btn btn-warning">

                        <i class="fas fa-rotate-left me-2"></i>

                        Reset

                    </button>

                    <button type="submit" class="btn text-white" style="background:#2b5748;">

                        <i class="fas fa-save me-2"></i>

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>