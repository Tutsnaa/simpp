<div class="container-fluid px-0">
    <div class="card shadow-sm border-0 profile-card">
        <!-- Header -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold">
                    <i class="fas fa-user-circle me-2"></i>
                    Profil Pengguna
                </h4>
                <small class="text-muted">
                    Informasi akun yang sedang digunakan.
                </small>
            </div>
            <div>
                <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalEditProfil">
                    </i>Ubah Profil</button>
                <button class="btn btn-outline-secondary" data-bs-toggle="modal"
                    data-bs-target="#modalUbahPassword"></i>Ubah Kata Sandi</button>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body p-0">
            <div class="row g-0 h-100">
                <!-- ========================= -->
                <!-- SIDEBAR -->
                <!-- ========================= -->
                <div class="col-lg-4 profile-sidebar">
                    <img src="<?= $foto; ?>" class="profile-photo" alt="Foto Profil">
                    <h4 class="mt-3 fw-bold mb-1">
                        <?= htmlspecialchars($pengguna['nama']); ?>
                    </h4>
                    <p class="text-muted mb-3">
                        @<?= htmlspecialchars($pengguna['nama_pengguna']); ?>
                    </p>
                    <div class="mb-3">
                        <span class="badge bg-primary px-3 py-2 me-2">
                            <?= htmlspecialchars($pengguna['role']); ?>
                        </span>
                        <?php if($pengguna['status']=="Aktif"): ?>
                        <span class="badge bg-success px-3 py-2">
                            Aktif
                        </span>
                        <?php else: ?>
                        <span class="badge bg-danger px-3 py-2">
                            Tidak Aktif
                        </span>
                        <?php endif; ?>
                    </div>
                    <hr class="w-100">
                    <div class="w-100">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">
                                ID Pengguna
                            </span>
                            <strong>
                                <?= $pengguna['id_pengguna']; ?>
                            </strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">
                                Dibuat
                            </span>
                            <strong>
                                <?= date("d M Y", strtotime($pengguna['tanggal_dibuat'])); ?>
                            </strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">
                                Diubah
                            </span>
                            <strong>
                                <?= date("d M Y", strtotime($pengguna['tanggal_diubah'])); ?>
                            </strong>
                        </div>
                    </div>
                </div>

                <!-- ========================= -->
                <!-- CONTENT -->
                <!-- ========================= -->
                <div class="col-lg-8 profile-content">
                    <h5 class="section-title">
                        Informasi Pengguna
                    </h5>
                    <div class="row">
                        <!-- Nama -->
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <small class="text-muted">
                                    Nama Lengkap
                                </small>
                                <h6 class="mb-0 mt-2">
                                    <?= htmlspecialchars($pengguna['nama']); ?>
                                </h6>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <small class="text-muted">
                                    Nama Pengguna
                                </small>
                                <h6 class="mb-0 mt-2">
                                    <?= htmlspecialchars($pengguna['nama_pengguna']); ?>
                                </h6>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <small class="text-muted">
                                    Email
                                </small>
                                <h6 class="mb-0 mt-2">
                                    <?= htmlspecialchars($pengguna['email']); ?>
                                </h6>
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <small class="text-muted">
                                    Nomor Telepon
                                </small>
                                <h6 class="mb-0 mt-2">
                                    <?= htmlspecialchars($pengguna['no_telepon']); ?>
                                </h6>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <small class="text-muted">
                                    Role
                                </small>
                                <h6 class="mb-0 mt-2">
                                    <?= htmlspecialchars($pengguna['role']); ?>
                                </h6>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <small class="text-muted">
                                    Status Akun
                                </small>
                                <h6 class="mb-0 mt-2">
                                    <?php if($pengguna['status']=="Aktif"): ?>
                                    <span class="text-success">
                                        Aktif
                                    </span>
                                    <?php else: ?>
                                    <span class="text-danger">
                                        Tidak Aktif
                                    </span>
                                    <?php endif; ?>
                                </h6>
                            </div>
                        </div>

                        <!-- Dibuat -->
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <small class="text-muted">
                                    Tanggal Dibuat
                                </small>
                                <h6 class="mb-0 mt-2">
                                    <?= date("d F Y H:i", strtotime($pengguna['tanggal_dibuat'])); ?>
                                </h6>
                            </div>
                        </div>

                        <!-- Diubah -->
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <small class="text-muted">
                                    Terakhir Diubah
                                </small>
                                <h6 class="mb-0 mt-2">
                                    <?= date("d F Y H:i", strtotime($pengguna['tanggal_diubah'])); ?>
                                </h6>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="col-12">
                            <div class="info-card">
                                <small class="text-muted">
                                    Alamat
                                </small>
                                <p class="mb-0 mt-2">
                                    <?= nl2br(htmlspecialchars($pengguna['alamat'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "modal_ubah_profil.php"; ?>
<?php require_once "modal_ubah_kata_sandi.php"; ?>
<?php require_once "script.php"; ?>