<?php if (!empty($barang)): ?>
<?php foreach ($barang as $row): ?>
<div class="modal fade" id="modalDetail<?= $row['id_barang']; ?>" tabindex="-1"
    aria-labelledby="modalDetailLabel<?= $row['id_barang']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <!-- Header Modal -->
            <div class="modal-header text-white" style="background-color: #2b5748;">
                <h5 class="modal-title fs-6 fw-bold" id="modalDetailLabel<?= $row['id_barang']; ?>">
                    <i class="bi bi-box-seam me-2"></i>Detail Data Barang
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Body Modal -->
            <div class="modal-body p-4">
                <!-- Foto & Informasi Utamanya -->
                <div class="text-center mb-3">
                    <?php if (!empty($row['foto']) && file_exists("assets/img/barang/" . $row['foto'])): ?>
                    <img src="assets/img/barang/<?= $row['foto']; ?>"
                        alt="<?= htmlspecialchars($row['nama_barang']); ?>"
                        class="img-fluid rounded border shadow-sm mb-3" style="max-height: 180px; object-fit: contain;">
                    <?php else: ?>
                    <div class="p-3 bg-light rounded border text-muted mb-3 d-inline-block px-4">
                        <i class="bi bi-image fs-1 d-block mb-1"></i> Tidak Ada Foto
                    </div>
                    <?php endif; ?>

                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($row['nama_barang']); ?></h5>
                    <span class="badge bg-secondary fs-6 py-2 px-3">
                        <?= str_pad($row['id_barang'], 5, "0", STR_PAD_LEFT); ?>
                    </span>
                </div>

                <hr class="my-3">

                <!-- Rincian Data Lengkap -->
                <div class="row g-2">
                    <div class="col-6 text-muted">Kategori:</div>
                    <div class="col-6 text-end fw-bold">
                        <?= htmlspecialchars($row['nama_kategori'] ?? 'Tanpa Kategori'); ?>
                    </div>

                    <div class="col-6 text-muted">Status Barang:</div>
                    <div class="col-6 text-end fw-bold">
                        <?php if ($row['jumlah'] <= 0 || $row['status'] == 'Habis'): ?>
                        <span class="badge bg-danger">Habis</span>
                        <?php else: ?>
                        <span class="badge bg-success">Tersedia</span>
                        <?php endif; ?>
                    </div>

                    <div class="col-6 text-muted">Jumlah Stok:</div>
                    <div class="col-6 text-end fw-bold"><?= $row['jumlah']; ?> Pcs</div>

                    <div class="col-6 text-muted">Harga Beli:</div>
                    <div class="col-6 text-end fw-bold text-danger">
                        Rp <?= number_format($row['harga_beli'], 0, ",", "."); ?>
                    </div>

                    <div class="col-6 text-muted">Harga Jual:</div>
                    <div class="col-6 text-end fw-bold text-success">
                        Rp <?= number_format($row['harga_jual'], 0, ",", "."); ?>
                    </div>

                    <div class="col-6 text-muted">Estimasi Keuntungan/Pcs:</div>
                    <div class="col-6 text-end fw-bold text-primary">
                        Rp <?= number_format($row['harga_jual'] - $row['harga_beli'], 0, ",", "."); ?>
                    </div>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="modal-footer bg-light border-0 py-2">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>