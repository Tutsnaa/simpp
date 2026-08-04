<div class="card shadow-sm border-0 mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <?php require_once "modal_tambah.php"; ?>
        <?php require_once "modal_ubah.php"; ?>
        <div>
            <h4 class="fw-bold mb-1">
                Data Kategori
            </h4>
            <small class="text-muted">
                Kelola kategori produk toko
            </small>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle"></i>
            Tambah Kategori
        </button>
    </div>
</div>

<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <input type="text" id="searchKategori" class="form-control" placeholder="Cari kategori...">
            </div>
            <div class="col-md-6 text-end">
                <span class="badge bg-success">
                    Total :
                    <?= count($kategori) ?>
                    Data
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <!-- PENTING: Penambahan style max-height dan overflow-y di sini -->
    <div class="table-responsive" style="max-height: 470px; overflow-y: auto;">
        <table class="table table-hover align-middle mb-0">
            <!-- PENTING: Penambahan class sticky-top & z-index agar header tetap melayang di atas -->
            <thead class="sticky-top table-success">
                <tr>
                    <th width="70">No</th>
                    <th>Nama Kategori</th>
                    <th>Keterangan</th>
                    <th width="170">Tanggal Dibuat</th>
                    <th width="120" class="text-center">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; ?>
                <?php foreach($kategori as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <div class="fw-semibold">
                            <?= htmlspecialchars($row['nama_kategori']) ?>
                        </div>
                    </td>
                    <td>
                        <?= $row['keterangan'] ?: "-" ?>
                    </td>
                    <td>
                        <?= date("d M Y",strtotime($row['tanggal_dibuat'])) ?>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#edit<?= $row['id_kategori']?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <a href="index.php?controller=kategori&action=delete&id=<?= $row['id_kategori']?>"
                            class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori ini?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once "script.php"; ?>