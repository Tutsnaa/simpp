<div class="modal fade" id="modalUbahPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="index.php?controller=pengguna&action=ubahPassword" method="POST">
                <input type="hidden" name="id_pengguna" value="<?= $pengguna['id_pengguna']; ?>">

                <!-- Header -->
                <div class="modal-header text-white" style="background:#2b5748;">
                    <h5 class="modal-title">
                        <i class="fas fa-key me-2"></i>Ubah Kata Sandi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-shield-alt me-2"></i>Demi keamanan akun, masukkan kata sandi lama terlebih
                        dahulu sebelum membuat kata sandi baru.
                    </div>

                    <!-- Password Lama -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kata Sandi Lama</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="passwordLama" name="password_lama" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                data-target="passwordLama">
                                <span class="material-symbols-outlined icon-eye">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kata Sandi Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="passwordBaru" name="password_baru"
                                minlength="8" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                data-target="passwordBaru">
                                <span class="material-symbols-outlined icon-eye">visibility</span>
                            </button>
                        </div>
                        <small class="text-muted">Minimal 8 karakter.</small>
                    </div>

                    <!-- Konfirmasi Kata Sandi Baru -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konfirmasi Kata Sandi Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="konfirmasiPassword"
                                name="konfirmasi_password" minlength="8" required>
                            <button
                                class="btn btn-outline-secondary toggle-password d-flex align-items-center justify-content-center"
                                type="button" data-target="konfirmasiPassword">
                                <span class="material-symbols-outlined icon-eye">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Validasi -->
                    <div id="passwordMessage"></div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <!-- <button type="reset" class="btn btn-warning">Reset</button> -->
                    <button type="submit" class="btn text-white" style="background:#2b5748;">Simpan Kata Sandi</button>
                </div>
            </form>
        </div>
    </div>
</div>