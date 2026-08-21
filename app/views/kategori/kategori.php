<div class="container-fluid">
    <!-- Header Utama -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1">Data Kategori</h3>
                <span class="badge bg-success text-nowrap">
                    Total <?= count($kategori) ?>
                </span>
            </div>
            <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <span class="material-symbols-outlined">add_circle</span>Tambah Kategori
            </button>
        </div>
    </div>

    <!-- filter Tabel -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 px-4 py-3">
            <div class="col-md-5 col-12 ms-auto">
                <div class="input-group input-group-sm">
                    <input type="text" id="searchKategori" class="form-control form-control-sm border-start-1 bg-light"
                        placeholder="Cari kategori...">
                </div>

            </div>
        </div>

        <!-- Container Tabel -->
        <div class="card-body shadow-sm pt-0 px-4">
            <div class="table-responsive" style="max-height: 480px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="sticky-top table-success" style="z-index: 1;">
                        <tr class="text-center">
                            <th width="70">No</th>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            <th width="170">Tanggal Dibuat</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kategori)): ?>
                        <?php $no = 1; ?>
                        <?php foreach($kategori as $row): ?>
                        <tr>
                            <td class="text-center fw-bold"><?= $no++ ?></td>
                            <td>
                                <div class="fw-semibold">
                                    <?= htmlspecialchars($row['nama_kategori']) ?>
                                </div>
                            </td>
                            <td>
                                <?= $row['keterangan'] ? htmlspecialchars($row['keterangan']) : "-" ?>
                            </td>
                            <td class="text-center">
                                <?= date("d M Y", strtotime($row['tanggal_dibuat'])) ?>
                            </td>
                            <td class="text-center text-nowrap">
                                <button class="btn-aksi-ubah" data-bs-toggle="modal"
                                    data-bs-target="#edit<?= $row['id_kategori']?>" title="Ubah Kategori">
                                    <span class="material-symbols-outlined">edit</span>
                                </button>
                                <a href="index.php?controller=kategori&action=delete&id=<?= $row['id_kategori']?>"
                                    class="btn-aksi-hapus" onclick="return confirm('Hapus kategori ini?')"
                                    title="Hapus Kategori">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data kategori</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL & SCRIPT -->
<?php require_once "script.php"; ?>
<?php require_once "modal_tambah.php"; ?>
<?php require_once "modal_ubah.php"; ?>