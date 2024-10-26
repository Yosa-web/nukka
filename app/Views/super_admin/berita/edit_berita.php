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
                                    <div id="ckeditor-classic" name="isi" class="<?= isset(session()->getFlashdata('errors')['isi']) ? 'is-invalid' : '' ?>"><?= old('isi', $berita['isi']) ?></div>
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
                                        <!-- Jika ada gambar lama, tampilkan gambar yang sudah diunggah -->
                                        <?php if ($berita['gambar']): ?>
                                            <p>Gambar Saat Ini: <img src="<?= base_url('/uploads/' . $berita['gambar']) ?>" alt="Gambar Berita" width="100"></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- Tanggal Post -->
                                <div class="row mb-3">
                                    <label
                                        for="tanggal_post"
                                        class="col-sm-2 col-form-label">Tanggal Posting</label>
                                    <div class="col-sm-9">
                                        <input
                                            class="form-control <?= isset(session()->getFlashdata('errors')['tanggal_post']) ? 'is-invalid' : '' ?>"
                                            type="datetime-local"
                                            id="tanggal_post" name="tanggal_post" value="<?= old('tanggal_post', date('Y-m-d\TH:i', strtotime($berita['tanggal_post']))) ?>" required />
                                    </div>
                                    <div id="tanggal_post_error" class="error"><?= isset(session()->getFlashdata('errors')['tanggal_post']) ? session()->getFlashdata('errors')['tanggal_post'] : '' ?></div>
                                </div>
                                <!-- Status -->
                                <div class="row mb-5">
                                    <label for="status-input" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select <?= isset(session()->getFlashdata('errors')['status']) ? 'is-invalid' : '' ?>" id="status-input">
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

<!-- ckeditor -->
<script src="/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
<!-- init js -->
<script src="/assets/js/pages/form-editor.init.js"></script>
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