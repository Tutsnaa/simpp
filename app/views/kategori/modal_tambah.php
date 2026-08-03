<div class="modal fade" id="modalTambah">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="POST" action="index.php?controller=kategori&action=create">

                <div class="modal-header">

                    <h5>

                        Tambah Kategori

                    </h5>

                    <button class="btn-close" data-bs-dismiss="modal">

                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label>

                            Nama Kategori

                        </label>

                        <input type="text" name="nama_kategori" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label>

                            Keterangan

                        </label>

                        <textarea name="keterangan" rows="3" class="form-control">

</textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary" data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button class="btn btn-success">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>