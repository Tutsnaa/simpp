<?php foreach($kategori as $row): ?>

<div class="modal fade" id="edit<?= $row['id_kategori']?>">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="POST" action="index.php?controller=kategori&action=update">

                <input type="hidden" name="id_kategori" value="<?= $row['id_kategori']?>">

                <div class="modal-header">

                    <h5>Ubah Kategori</h5>

                    <button class="btn-close" data-bs-dismiss="modal">

                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label>Nama Kategori</label>

                        <input type="text" name="nama_kategori" value="<?= htmlspecialchars($row['nama_kategori'])?>"
                            class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label>Keterangan</label>

                        <textarea name="keterangan"
                            class="form-control"><?= htmlspecialchars($row['keterangan'])?></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn-batal" data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button class="btn-simpan">

                        Ubah

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php endforeach; ?>