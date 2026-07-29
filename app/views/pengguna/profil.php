<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h4 class="mb-0">
                        Profil Pengguna
                    </h4>

                </div>

                <div class="card-body">

                    <div class="row">

                        <!-- Foto -->
                        <div class="col-md-4 text-center">

                            <img src="<?= $foto; ?>" alt="Foto Profil"
                                class="img-thumbnail rounded-circle profile-photo">

                            <h5 class="mt-3 mb-1">
                                <?= $_SESSION['nama']; ?>
                            </h5>

                            <span class="badge bg-success">
                                <?= $_SESSION['role']; ?>
                            </span>

                        </div>

                        <!-- Data -->
                        <div class="col-md-8">

                            <table class="table table-borderless">

                                <tr>
                                    <th width="35%">Nama</th>
                                    <td><?= $_SESSION['nama']; ?></td>
                                </tr>

                                <tr>
                                    <th>Nama Pengguna</th>
                                    <td><?= $pengguna['nama_pengguna']; ?></td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td><?= $pengguna['email']; ?></td>
                                </tr>

                                <tr>
                                    <th>No. Telepon</th>
                                    <td><?= $pengguna['no_telepon']; ?></td>
                                </tr>

                                <tr>
                                    <th>Alamat</th>
                                    <td><?= $pengguna['alamat']; ?></td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>

                                        <?php if ($pengguna['status'] == 'Aktif') : ?>

                                        <span class="badge bg-success">
                                            Aktif
                                        </span>

                                        <?php else : ?>

                                        <span class="badge bg-danger">
                                            Tidak Aktif
                                        </span>

                                        <?php endif; ?>

                                    </td>
                                </tr>

                            </table>

                            <div class="mt-4">

                                <a href="index.php?controller=pengguna&action=editProfil" class="btn btn-success">

                                    Edit Profil

                                </a>

                                <a href="index.php?controller=pengguna&action=ubahPassword"
                                    class="btn btn-outline-secondary">

                                    Ubah Kata Sandi

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>