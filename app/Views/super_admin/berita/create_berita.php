<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Tambah Berita | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">Tambah Berita Baru</h3>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kelola Konten</a></li>
                                <li class="breadcrumb-item"><a href="/superadmin/berita/list-berita">Kelola Berita</a></li>
                                <li class="breadcrumb-item active">Tambah Berita</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="form-berita" action="<?= base_url('/superadmin/berita/store') ?>" method="post" enctype="multipart/form-data">
                                <!-- Judul -->
                                <div class="form-group mb-3">
                                    <label for="judul" class="form-label">Judul Berita</label>
                                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul Berita">
                                    <div id="judul_error" class="text-danger"></div>
                                </div>
                                <!-- CK Editor -->
                                <div class="form-group mb-3">
                                    <label for="isi" class="form-label">Isi Berita</label>
                                    <textarea id="isi" name="isi" class="form-control" placeholder="Masukkan Isi Berita" rows="5"></textarea>
                                    <div id="isi_error" class="text-danger"></div>
                                </div>
                                <!-- Gambar -->
                                <div class="form-group mb-3">
                                    <label for="gambar" class="col-sm-2 col-form-label">Unggah Gambar</label>
                                    <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*">
                                    <div id="gambar_error" class="text-danger"></div>
                                </div>
                                <!-- Status -->
                                <div class="form-group mb-5">
                                    <label for="status-input" class="col-sm-2 col-form-label">Status</label>
                                    <select class="form-select" id="status-input" name="status">
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                        <option value="archive">Archive</option>
                                    </select>
                                    <div id="status_error" class="text-danger"></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='/superadmin/berita/list-berita'">Batal</button>
                                            <button type="submit" class="btn btn-primary w-md ms-4">Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Validasi JavaScript -->
<script>
    $(document).ready(function() {
        const judulInput = $('#judul');
        const judulErrorDiv = $('#judul_error');

        judulInput.on('blur', function() {
            const judul = judulInput.val().trim();

            // Validasi judul kosong atau hanya spasi
            if (judul === '') {
                judulErrorDiv.text('Judul tidak boleh kosong atau hanya spasi.');
                judulInput.addClass('is-invalid');
                return;
            } else {
                judulErrorDiv.text('');
                judulInput.removeClass('is-invalid');
            }

            // Lakukan permintaan AJAX untuk memeriksa apakah judul unik
            $.ajax({
                url: '<?= base_url('/superadmin/berita/check-title') ?>',
                method: 'POST',
                data: {
                    judul: judul,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                success: function(response) {
                    if (response.exists) {
                        judulErrorDiv.text('Judul sudah digunakan, harap gunakan judul lain.');
                        judulInput.addClass('is-invalid');
                    } else {
                        judulErrorDiv.text('');
                        judulInput.removeClass('is-invalid');
                    }
                },
                error: function(xhr) {
                    judulErrorDiv.text('Terjadi kesalahan saat memeriksa judul.');
                }
            });
        });

        // Cegah submit jika ada error
        $('#form-berita').on('submit', function(e) {
            if ($('.is-invalid').length > 0) {
                e.preventDefault();
                alert('Periksa kembali form yang diisi.');
            }
        });
    });
</script>
<?= $this->endSection(); ?>