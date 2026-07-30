<div class="container-fluid px-0">

    <div class="card shadow-sm border-0 profile-card">

        <div class="card-header bg-white">

            <h4 class="mb-0">
                <i class="fas fa-user-circle me-2"></i>
                Profil Pengguna
            </h4>

        </div>

        <div class="card-body p-0">

            <div class="row g-0 h-100">

                <!-- Sidebar -->

                <div class="col-lg-3 profile-sidebar">

                    <img src="<?= $foto; ?>" alt="Foto Profil" class="profile-photo">

                    <a href="index.php?controller=pengguna&action=editProfil" class="btn btn-success w-100 mb-2">

                        <i class="fas fa-user-edit me-2"></i>
                        Edit Profil

                    </a>

                    <a href="index.php?controller=pengguna&action=ubahPassword" class="btn btn-outline-secondary w-100">

                        <i class="fas fa-key me-2"></i>
                        Ubah Kata Sandi

                    </a>

                </div>

                <!-- Content -->

                <div class="col-lg-9 profile-content">

                    <h5 class="section-title">
                        Informasi Pengguna
                    </h5>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nama
                            </label>

                            <input type="text" class="form-control" value="<?= $_SESSION['nama']; ?>" readonly>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nama Pengguna
                            </label>

                            <input type="text" class="form-control" value="<?= $pengguna['nama_pengguna']; ?>" readonly>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email" class="form-control" value="<?= $pengguna['email']; ?>" readonly>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                No. Telepon
                            </label>

                            <input type="text" class="form-control" value="<?= $pengguna['no_telepon']; ?>" readonly>

                        </div>

                        <div class="col-12 mb-3">

                            <label class="form-label">
                                Alamat
                            </label>

                            <textarea class="form-control" rows="4" readonly><?= $pengguna['alamat']; ?></textarea>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Status
                            </label>

                            <input type="text" class="form-control" value="<?= $pengguna['status']; ?>" readonly>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>