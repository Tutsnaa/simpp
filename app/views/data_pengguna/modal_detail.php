<!-- MODAL DETAIL PENGGUNA -->
<div class="modal fade" id="modalDetail<?= $row['id_pengguna']; ?>" tabindex="-1"
    aria-labelledby="modalDetailLabel<?= $row['id_pengguna']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            <!-- Header Modal -->
            <div class="modal-header bg-main border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-white">account_circle</span>
                        Detail Data Pengguna
                    </h4>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            </div>

            <!-- Body Modal -->
            <div class="modal-body p-0">
                <div class="row g-0">

                    <!-- SIDEBAR PROFIL -->
                    <div
                        class="col-lg-4 bg-light p-4 text-center border-end d-flex flex-column align-items-center justify-content-center">
                        <img src="<?= $pathFoto; ?>" class="rounded-circle shadow-sm mb-3 border border-3 border-white"
                            alt="Foto Profil" style="width: 130px; height: 130px; object-fit: cover;">

                        <h5 class="fw-bold mb-1 text-dark">
                            <?= htmlspecialchars($row['nama']); ?>
                        </h5>

                        <div class="mb-3 d-flex gap-2 justify-content-center">
                            <span class="badge bg-primary px-3 py-2">
                                <?= htmlspecialchars($row['role']); ?>
                            </span>
                            <?php if($row['status'] == "Aktif"): ?>
                            <span class="badge bg-success px-3 py-2">Aktif</span>
                            <?php else: ?>
                            <span class="badge bg-danger px-3 py-2">Tidak Aktif</span>
                            <?php endif; ?>
                        </div>

                        <hr class="w-100 my-3">

                        <div class="w-100 text-start px-2 fs-7">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">ID Pengguna</span>
                                <strong class="text-dark"><?= $row['id_pengguna']; ?></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Dibuat</span>
                                <strong><?= date("d M Y", strtotime($row['tanggal_dibuat'] ?? 'now')); ?></strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Diubah</span>
                                <strong><?= date("d M Y", strtotime($row['tanggal_diubah'] ?? 'now')); ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT DETAIL -->
                    <div class="col-lg-8 p-4 bg-white">
                        <h6 class="fw-bold mb-4 text-success d-flex align-items-center gap-2 border-bottom pb-2">
                            <span class="material-symbols-outlined">info</span> Informasi Detail
                        </h6>

                        <div class="row g-3">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light-subtle">
                                    <small class="text-muted d-block mb-1">Nama Lengkap</small>
                                    <h6 class="mb-0 fw-semibold text-dark"><?= htmlspecialchars($row['nama']); ?></h6>
                                </div>
                            </div>

                            <!-- Nama Pengguna -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light-subtle">
                                    <small class="text-muted d-block mb-1">Nama Pengguna (Username)</small>
                                    <h6 class="mb-0 fw-semibold text-dark">
                                        <?= htmlspecialchars($row['nama_pengguna']); ?></h6>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light-subtle">
                                    <small class="text-muted d-block mb-1">Email</small>
                                    <h6 class="mb-0 fw-semibold text-dark"><?= htmlspecialchars($row['email']); ?></h6>
                                </div>
                            </div>

                            <!-- No Telepon -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light-subtle">
                                    <small class="text-muted d-block mb-1">Nomor Telepon</small>
                                    <h6 class="mb-0 fw-semibold text-dark"><?= htmlspecialchars($row['no_telepon']); ?>
                                    </h6>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light-subtle">
                                    <small class="text-muted d-block mb-1">Role / Hak Akses</small>
                                    <h6 class="mb-0 fw-semibold text-dark"><?= htmlspecialchars($row['role']); ?></h6>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light-subtle">
                                    <small class="text-muted d-block mb-1">Status Akun</small>
                                    <h6 class="mb-0 fw-semibold">
                                        <?php if($row['status'] == "Aktif"): ?>
                                        <span class="text-success">Aktif</span>
                                        <?php else: ?>
                                        <span class="text-danger">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </h6>
                                </div>
                            </div>

                            <!-- Tanggal Dibuat -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light-subtle">
                                    <small class="text-muted d-block mb-1">Tanggal Dibuat</small>
                                    <h6 class="mb-0 fw-semibold text-dark">
                                        <?= isset($row['tanggal_dibuat']) ? date("d F Y H:i", strtotime($row['tanggal_dibuat'])) : '-'; ?>
                                    </h6>
                                </div>
                            </div>

                            <!-- Tanggal Diubah -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light-subtle">
                                    <small class="text-muted d-block mb-1">Terakhir Diubah</small>
                                    <h6 class="mb-0 fw-semibold text-dark">
                                        <?= isset($row['tanggal_diubah']) ? date("d F Y H:i", strtotime($row['tanggal_diubah'])) : '-'; ?>
                                    </h6>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="col-12">
                                <div class="p-3 border rounded-3 bg-light-subtle">
                                    <small class="text-muted d-block mb-1">Alamat</small>
                                    <p class="mb-0 fw-semibold text-dark">
                                        <?= nl2br(htmlspecialchars($row['alamat'] ?? '-')); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer Modal -->
            <div class="modal-footer bg-light border-top px-4 py-3">
                <button type="button" class="btn-batal" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>