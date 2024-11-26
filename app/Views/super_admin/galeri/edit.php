<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Edit Galeri | Rumah Inovasi</title><?= $this->endSection() ?>
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
                            Edit Gambar
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Kelola Konten</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('superadmin/galeri') ?>">Kelola Galeri</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit Gambar
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
                            <form action="/superadmin/galeri/update/<?= $galeri['id_galeri'] ?>" method="post" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="tipe" onchange="toggleInput()">
                                            <option value="image" <?= $galeri['tipe'] == 'image' ? 'selected' : '' ?>>Image</option>
                                            <option value="video" <?= $galeri['tipe'] == 'video' ? 'selected' : '' ?>>Video</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="judul" class="col-sm-3 col-form-label">Judul</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="judul" value="<?= $galeri['judul'] ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-5" id="imageInput" style="display: <?= $galeri['tipe'] == 'image' ? 'flex' : 'none' ?>;">
                                    <label for="image" class="col-sm-3 col-form-label">Upload File Gambar</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                </div>
                                <div class="row mb-5" id="urlInput" style="display: <?= $galeri['tipe'] == 'video' ? 'flex' : 'none' ?>;">
                                    <label for="url" class="col-sm-3 col-form-label">Tautan Video</label>
                                    <div class="col-sm-9">
                                        <input type="url" class="form-control" name="url" value="<?= $galeri['url'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='<?= base_url('superadmin/galeri') ?>'">Batal</button>
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
<script>
        function toggleInput() {
            const tipe = document.querySelector('select[name="tipe"]').value;
            const imageInput = document.getElementById('imageInput');
            const urlInput = document.getElementById('urlInput');

            if (tipe === 'image') {
                imageInput.style.display = 'flex';
                urlInput.style.display = 'none';
            } else if (tipe === 'video') {
                imageInput.style.display = 'none';
                urlInput.style.display = 'flex';
            }
        }
        // Run this to set the correct input visibility on page load
        toggleInput();
    </script>
<?= $this->endSection(); ?>