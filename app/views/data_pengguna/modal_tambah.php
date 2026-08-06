<!-- MODAL TAMBAH PENGGUNA -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <!-- Header Modal -->
            <div class="modal-header text-white bg-main">
                <h5 class="modal-title fw-bold" id="modalTambahLabel">
                    <span class="material-symbols-outlined align-middle me-1">person_add</span> Tambah Data Pengguna
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Form Tambah -->
            <form action="index.php?controller=pengguna&action=create" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">

                    <div class="row">
                        <!-- Nama Lengkap -->
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan nama lengkap" required>
                        </div>

                        <!-- Username -->
                        <div class="col-md-6 mb-3">
                            <label for="nama_pengguna" class="form-label fw-semibold">Username <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna"
                                placeholder="Masukkan username" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Email <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="contoh@domain.com" required>
                        </div>

                        <!-- Kata Sandi -->
                        <div class="col-md-6 mb-3">
                            <label for="kata_sandi" class="form-label fw-semibold">Kata Sandi <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="kata_sandi" name="kata_sandi"
                                placeholder="Masukkan kata sandi" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- No Telepon -->
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon" class="form-label fw-semibold">No. Telepon <span
                                    class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="no_telepon" name="no_telepon"
                                placeholder="081234567890" required>
                        </div>

                        <!-- Role / Hak Akses -->
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label fw-semibold">Role <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="" selected disabled>-- Pilih Role --</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Status Akun -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-semibold">Status <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>

                        <!-- Foto Profil -->
                        <div class="col-md-6 mb-3">
                            <label for="foto" class="form-label fw-semibold">Foto Profil</label>
                            <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
                            <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-semibold">Alamat <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"
                            placeholder="Masukkan alamat lengkap..." required></textarea>
                    </div>

                </div>

                <!-- Footer Modal -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn-batal" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-simpan">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>