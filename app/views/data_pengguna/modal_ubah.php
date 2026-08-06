<!-- MODAL EDIT / UBAH PENGGUNA -->
<div class="modal fade" id="modalUbah<?= $row['id_pengguna']; ?>" tabindex="-1"
    aria-labelledby="labelModalUbah<?= $row['id_pengguna']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <!-- Header Modal -->
            <div class="modal-header text-white" style="background:#2b5748;">
                <h5 class="modal-title d-flex align-items-center" id="labelModalUbah<?= $row['id_pengguna']; ?>">
                    <span class="material-symbols-outlined me-2">edit_square</span>
                    Ubah Data Pengguna
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Form Ubah Data -->
            <form action="index.php?controller=pengguna&action=update" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <!-- Hidden ID Pengguna -->
                    <input type="hidden" name="id_pengguna" value="<?= $row['id_pengguna']; ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control"
                                value="<?= htmlspecialchars($row['nama']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Pengguna</label>
                            <input type="text" name="nama_pengguna" class="form-control"
                                value="<?= htmlspecialchars($row['nama_pengguna']); ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($row['email']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control"
                                value="<?= htmlspecialchars($row['no_telepon']); ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Hak Akses (Role)</label>
                            <select name="role" class="form-select" required>
                                <option value="SuperAdmin" <?= ($row['role'] == 'SuperAdmin') ? 'selected' : ''; ?>>
                                    SuperAdmin</option>
                                <option value="Admin" <?= ($row['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="Pegawai" <?= ($row['role'] == 'Pegawai') ? 'selected' : ''; ?>>Pegawai
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status Akun</label>
                            <select name="status" class="form-select" required>
                                <option value="Aktif" <?= ($row['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif
                                </option>
                                <option value="Tidak Aktif" <?= ($row['status'] == 'Tidak Aktif') ? 'selected' : ''; ?>>
                                    Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"
                            required><?= htmlspecialchars($row['alamat'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Profil</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted fs-7">*Biarkan kosong jika tidak ingin mengganti foto saat ini.</small>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white px-4" style="background:#2b5748;">Simpan
                        Perubahan</button>
                </div>
            </form>

        </div>
    </div>
</div>