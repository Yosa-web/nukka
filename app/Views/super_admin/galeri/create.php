<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Tambah Galeri | Rumah Inovasi</title><?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">Tambah Galeri</h3>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Menampilkan alert error jika judul sudah terpakai -->
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('error') ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <form id="galeriForm" method="post" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="tipe" id="tipe" required onchange="toggleInput()">
                                            <option value="" disabled selected>Pilih Salah Satu</option>
                                            <option value="image">Gambar</option>
                                            <option value="video">Video</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="judul" class="col-sm-3 col-form-label">Judul</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="judul" placeholder="Masukkan judul" value="<?= old('judul') ?>" required>
                                    </div>
                                </div>

                                <!-- Input untuk gambar -->
                                <div class="row mb-5" id="imageInput" style="display: none;">
                                    <label for="image" class="col-sm-3 col-form-label">Upload File Gambar</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div>

                                <!-- Input untuk URL video -->
                                <div class="row mb-5" id="urlInput" style="display: none;">
                                    <label for="url" class="col-sm-3 col-form-label">Tautan Video</label>
                                    <div class="col-sm-9">
                                        <input type="url" class="form-control" name="url" placeholder="Masukkan URL video">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='<?= base_url('superadmin/galeri') ?>'">Batal</button>
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

<script>
    function toggleInput() {
        const tipe = document.getElementById("tipe").value;
        const uploadGambar = document.getElementById("imageInput");
        const tautanVideo = document.getElementById("urlInput");

        if (tipe === "image") {
            uploadGambar.style.display = "flex";
            tautanVideo.style.display = "none";
            document.getElementById('galeriForm').setAttribute('action', '/superadmin/galeri/storeImage');
        } else if (tipe === "video") {
            uploadGambar.style.display = "none";
            tautanVideo.style.display = "flex";
            document.getElementById('galeriForm').setAttribute('action', '/superadmin/galeri/storeVideo');
        } else {
            uploadGambar.style.display = "none";
            tautanVideo.style.display = "none";
        }
    }
</script>

<?= $this->endSection(); ?>