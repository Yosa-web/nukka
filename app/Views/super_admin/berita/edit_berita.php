<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Edit Berita | Rumah Inovasi</title><?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">
                            Edit Berita
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Kelola Konten</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/superadmin/berita/list-berita">Kelola Berita</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit Berita
                                </li>
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
                            <form action="<?= base_url('/superadmin/berita/update/' . $berita['id_berita']) ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="PUT">
                                <!-- Judul -->
                                <div class="form-group mb-3">
                                    <label for="judul" class="form-label">Judul Berita</label>
                                    <input type="text" class="form-control <?= isset(session()->getFlashdata('errors')['judul']) ? 'is-invalid' : '' ?>" id="judul" name="judul" value="<?= old('judul', $berita['judul']) ?>" placeholder="Masukkan Judul Berita">
                                    <div id="judul_error" class="error"><?= isset(session()->getFlashdata('errors')['judul']) ? session()->getFlashdata('errors')['judul'] : '' ?></div>
                                </div>
                                <!-- Isi Berita-->
                                <div class="form-group mb-3">
                                    <label for="isi" class="form-label">Isi Berita</label>
                                    <textarea id="isi" name="isi" class="form-control <?= isset(session()->getFlashdata('errors')['isi']) ? 'is-invalid' : '' ?>" placeholder="Masukkan Isi Berita" rows="10"><?= old('isi', $berita['isi']) ?></textarea>
                                    <div id="isi_error" class="error"><?= isset(session()->getFlashdata('errors')['isi']) ? session()->getFlashdata('errors')['isi'] : '' ?></div>
                                </div>
                                <!-- Gambar -->
                                <div class="form-group mb-4">
                                    <label for="gambar" class="form-label">Unggah Gambar</label>
                                    <input type="file" id="gambar" name="gambar" class="form-control mb-2 <?= isset(session()->getFlashdata('errors')['gambar']) ? 'is-invalid' : '' ?>" accept="image/*">
                                    <div id="gambar_error" class="error"><?= isset(session()->getFlashdata('errors')['gambar']) ? session()->getFlashdata('errors')['gambar'] : '' ?></div>
                                    <!-- Jika ada gambar lama, tampilkan gambar yang sudah diunggah -->
                                    <?php if ($berita['gambar']): ?>
                                        <p>Gambar Saat Ini: <img src="<?= base_url($berita['gambar']) ?>" alt="Gambar Berita" width="100"></p>
                                        <input type="hidden" name="gambar_lama" value="<?= $berita['gambar'] ?>">
                                    <?php endif; ?>
                                </div>
                                <!-- Status -->
                                <div class="row mb-5">
                                    <label for="status-input" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select <?= isset(session()->getFlashdata('errors')['status']) ? 'is-invalid' : '' ?>" id="status-input" name="status">
                                            <option>
                                                Pilih Status
                                            </option>
                                            <option value="draft" <?= old('status') == 'draft' ? 'selected' : '' ?>>Draft</option>
                                            <option value="published" <?= old('status') == 'published' ? 'selected' : '' ?>>Published</option>
                                            <option value="archive" <?= old('status') == 'archive' ? 'selected' : '' ?>>Archive</option>
                                        </select>
                                    </div>
                                    <div id="status_error" class="error"><?= isset(session()->getFlashdata('errors')['status']) ? session()->getFlashdata('errors')['status'] : '' ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='/superadmin/berita/list-berita'">Batal</button>
                                            <button type="submit" class="btn btn-warning w-md ms-4">Perbarui</button>
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

<!-- init js -->
<script src="/assets/js/pages/form-editor.init.js"></script>
<script>
    document.getElementById('isi').addEventListener('input', function() {
        const minLength = 150;
        const isiField = this;
        const errorDiv = document.getElementById('isi_error');

        if (isiField.value.length < minLength) {
            errorDiv.textContent = 'Isi Berita harus memiliki minimal ' + minLength + ' karakter.';
            isiField.classList.add('is-invalid');
        } else {
            errorDiv.textContent = '';
            isiField.classList.remove('is-invalid');
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Isi Validation
        $('#isi').on('keyup change', function() {
            var isi = $(this).val();
            if (isi.length < 10 || isi.length > 2000) {
                $('#isi_error').text('Isi berita harus memiliki 10 hingga 2000 karakter.');
                $(this).addClass('is-invalid');
            } else {
                $('#isi_error').text('');
                $(this).removeClass('is-invalid');
            }
        });

        // Gambar Validation
        $('#gambar').on('change', function() {
            var gambar = $(this).val().split('.').pop().toLowerCase();
            if (gambar !== 'jpg' && gambar !== 'jpeg' && gambar !== 'png') {
                $('#gambar_error').text('Hanya file gambar dengan format JPG, JPEG, atau PNG yang diizinkan.');
                $(this).addClass('is-invalid');
            } else {
                $('#gambar_error').text('');
                $(this).removeClass('is-invalid');
            }
        });

        // Prevent form submission if there are errors
        $('form').on('submit', function(e) {
            if ($('.is-invalid').length > 0) {
                e.preventDefault(); // Prevent form from submitting
                alert('Periksa kembali form yang diisi.');
            }
        });
    });
</script>
<?= $this->endSection(); ?>