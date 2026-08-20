<div class="container-fluid">
    <!-- Header -->
    <div class="card border-0 shadow mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1">Data Barang</h3>
                <span class="badge bg-success">
                    Total <?= count($barang) ?> Barang
                </span>
            </div>
            <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <span class="material-symbols-outlined">add_circle</span>Tambah Barang
            </button>
        </div>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow mb-3">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-4">
                    <input type="text" id="searchBarang" class="form-control" placeholder="Cari barang...">
                </div>
                <div class="col-lg-3">
                    <!-- Filter Kategori -->
                    <select id="filterKategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php foreach($kategori as $k): ?>
                        <option value="<?= htmlspecialchars($k['nama_kategori']); ?>">
                            <?= htmlspecialchars($k['nama_kategori']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <!-- Filter Status -->
                    <select id="filterStatus" class="form-select">
                        <option value="">Semua Status</option> <!-- Pastikan value="" -->
                        <option value="Tersedia">Tersedia</option>
                        <option value="Habis">Habis</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Barang -->
    <div class="card border-0 shadow">
        <div class="card-body p-4">
            <div class="table-responsive" style="max-height: 430px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0" id="tableBarang">
                    <thead class="sticky-top table-success" style="z-index: 1;">
                        <tr class="text-center">
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga Jual</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($barang)): ?>
                        <?php foreach($barang as $row): ?>
                        <tr>
                            <td class="fw-bold text-center"><?= str_pad($row['id_barang'], 5, "0", STR_PAD_LEFT); ?>
                            </td>
                            <td><strong><?= htmlspecialchars($row['nama_barang']); ?></strong></td>
                            <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                            <td class="text-center"><?= $row['jumlah']; ?></td>
                            <td class="text-center">Rp <?= number_format($row['harga_jual'],0,",","."); ?></td>
                            <td class="text-center">
                                <?php if($row['status']=="Tersedia"): ?>
                                <span class="badge bg-success">Tersedia</span>
                                <?php else: ?>
                                <span class="badge bg-danger">Habis</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center text-nowrap">
                                <!-- Tombol Detail -->
                                <button class="btn-aksi-detail" data-bs-toggle="modal"
                                    data-bs-target="#modalDetail<?= $row['id_barang']; ?>" title="Detail Barang">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                                <!-- Tombol Edit -->
                                <button class="btn-aksi-ubah" data-bs-toggle="modal"
                                    data-bs-target="#edit<?= $row['id_barang']; ?>" title="Edit Barang">
                                    <span class="material-symbols-outlined">edit</span>
                                </button>
                                <!-- Tombol Hapus -->
                                <a href="index.php?controller=barang&action=delete&id=<?= $row['id_barang']; ?>"
                                    class="btn-aksi-hapus" onclick="return confirm('Hapus barang ini?')"
                                    title="Hapus Barang">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Data barang tidak ditemukan.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL & SCRIPT -->
<?php require "modal_tambah.php"; ?>
<?php require "modal_ubah.php"; ?>
<?php require "modal_detail.php"; ?>
<?php require "script.php"; ?>