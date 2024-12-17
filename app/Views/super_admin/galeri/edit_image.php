<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Edit Gambar | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <h3 class="mb-0">Edit Gambar Galeri</h3>

            <!-- Flash Messages (Alert) -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('superadmin/galeri/update-image/' . $galeri['id_galeri']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group mb-3">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul', $galeri['judul']) ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label for="image">Ganti Gambar</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
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

<?= $this->endSection(); ?>