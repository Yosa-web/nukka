<?= $this->extend('layout/master_dashboard'); ?>

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
                            Tambah Berita Baru
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Kelola Konten</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="kelola-berita.html">Kelola Berita</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Tambah Berita
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
                            <form action="<?= base_url('/superadmin/berita/store') ?>" method="post" enctype="multipart/form-data">
                                <!-- Judul -->
                                <div class="form-group mb-3">
                                    <label for="judul" class="form-label">Judul Berita</label>
                                    <input type="text" class="form-control <?= isset(session()->getFlashdata('errors')['judul']) ? 'is-invalid' : '' ?>" id="judul" name="judul" value="<?= old('judul') ?>" placeholder="Masukkan Judul Berita">
                                    <div id="judul_error" class="error"><?= isset(session()->getFlashdata('errors')['judul']) ? session()->getFlashdata('errors')['judul'] : '' ?></div>
                                </div>
                                <!-- Isi Berita-->
                                <div class="form-group mb-3">
                                    <label for="isi" class="form-label">Isi Berita</label>
                                    <textarea id="isi" name="isi" class="form-control <?= isset(session()->getFlashdata('errors')['isi']) ? 'is-invalid' : '' ?>" placeholder="Masukkan Isi Berita" rows="5"><?= old('isi') ?></textarea>
                                    <div id="isi_error" class="error"><?= isset(session()->getFlashdata('errors')['isi']) ? session()->getFlashdata('errors')['isi'] : '' ?></div>
                                </div>
                                <!-- Gambar -->
                                <div class="form-group mb-4">
                                    <label for="gambar" class="form-label">Unggah Gambar</label>
                                    <div class="dropzone" id="imageDropzone">
                                        <div class="fallback">
                                            <input id="gambar" name="gambar" type="file" class="<?= isset(session()->getFlashdata('errors')['gambar']) ? 'is-invalid' : '' ?>" accept="image/*" multiple="multiple">
                                        </div>
                                        <div class="dz-message needsclick">
                                            <div class="mb-3">
                                                <i class="display-4 text-muted bx bx-cloud-upload"></i>
                                            </div>
                                            <h5>Drop files here or click to upload.</h5>
                                        </div>
                                        <div id="gambar_error" class="error"><?= isset(session()->getFlashdata('errors')['gambar']) ? session()->getFlashdata('errors')['gambar'] : '' ?></div>
                                    </div>
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
                                            <button type="button" class="btn btn-secondary w-md">Batal</button>
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
    // Disable Dropzone auto-discovering all elements with .dropzone class
    Dropzone.autoDiscover = false;
    // Initialize Dropzone
    var myDropzone = new Dropzone("#imageDropzone", {
        url: "/your-upload-endpoint", // URL untuk mengupload file
        maxFiles: 5,
        maxFilesize: 2, // Maksimal ukuran file dalam MB
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        dictRemoveFile: "Remove",
        thumbnailWidth: 200,
        thumbnailHeight: 200,
        init: function() {
            this.on("success", function(file, response) {
                console.log("File successfully uploaded!");
            });
            this.on("error", function(file, errorMessage) {
                console.log("Error: " + errorMessage);
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Judul Validation
        $('#judul').on('keyup change', function() {
            var judul = $(this).val();
            if (judul.length < 3 || judul.length > 100) {
                $('#judul_error').text('Judul berita harus memiliki 3 hingga 100 karakter.');
                $(this).addClass('is-invalid');
            } else {
                $('#judul_error').text('');
                $(this).removeClass('is-invalid');
            }
        });

        // Isi Validation
        $('#isi').on('keyup change', function() {
            const isi = $(this).val();
            if (isi.length < 50 || isi.length > 2000) {
                $('#isi_error').text('Isi berita harus memiliki 50 hingga 2000 karakter.');
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