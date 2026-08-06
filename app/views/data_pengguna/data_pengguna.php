<div class="card shadow-sm border-0 mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1">Data Pengguna</h4>
            <small class="text-muted">Kelola data akun dan hak akses pengguna</small>
        </div>
        <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <span class="material-symbols-outlined">add_circle</span>Tambah Pengguna
        </button>
    </div>
</div>

<!-- Tabel Data Pengguna -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Daftar Pengguna</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table  table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="table-success">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th width="10%">Foto</th>
                        <th width="40%">Nama</th>
                        <th>No Telepon</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pengguna)) : ?>
                    <?php $no = 1; foreach ($pengguna as $row) : ?>
                    <?php 
                                $pathFoto = !empty($row['foto']) && file_exists("assets/img/profil/" . $row['foto']) 
                                    ? "assets/img/profil/" . $row['foto'] 
                                    : "assets/img/default.png";
                            ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center">
                            <img src="<?= $pathFoto; ?>" alt="Foto" class="rounded-circle" width="40" height="40"
                                style="object-fit: cover;">
                        </td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td class="text-center"><?= htmlspecialchars($row['no_telepon']); ?></td>
                        <td class="text-center">
                            <span class="badge bg-primary"><?= htmlspecialchars($row['role']); ?></span>
                        </td>
                        <td class="text-center">
                            <?php if ($row['status'] == 'Aktif') : ?>
                            <span class="badge bg-success">Aktif</span>
                            <?php else : ?>
                            <span class="badge bg-danger">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <!-- Tombol Detail (Menggunakan data-bs-toggle dan data-bs-target untuk Bootstrap 5) -->
                            <button type="button" class="btn-aksi-detail" data-bs-toggle="modal"
                                data-bs-target="#modalDetail<?= $row['id_pengguna']; ?>">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>

                            <!-- Tombol Edit -->
                            <button type="button" class="btn-aksi-ubah" data-bs-toggle="modal"
                                data-bs-target="#modalUbah<?= $row['id_pengguna']; ?>">
                                <span class="material-symbols-outlined">edit</span>
                            </button>

                            <!-- Tombol Hapus -->
                            <a href="index.php?controller=pengguna&action=delete&id=<?= $row['id_pengguna']; ?>"
                                class="btn-aksi-hapus"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data pengguna ini?')">
                                <span class="material-symbols-outlined">delete</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data pengguna.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- KUMPULAN MODAL (DITARUH DI LUAR TABEL / PALING BAWAH HALAMAN) -->
<?php if (!empty($pengguna)) : ?>
<?php foreach ($pengguna as $row) : ?>
<?php 
            $pathFoto = !empty($row['foto']) && file_exists("assets/img/profil/" . $row['foto']) 
                ? "assets/img/profil/" . $row['foto'] 
                : "assets/img/default.png";
            
            // Sertakan file modal ubah dan detail menggunakan nama file Anda
            include "modal_ubah.php";
            include "modal_detail.php";
        ?>
<?php endforeach; ?>
<?php endif; ?>

<!-- MODAL TAMBAH -->
<?php require_once "modal_tambah.php"; ?>