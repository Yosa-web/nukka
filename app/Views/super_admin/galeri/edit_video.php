<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Edit Video | Rumah Inovasi</title><?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <h3 class="mb-0">Edit Video Galeri</h3>

            <!-- Alert untuk menampilkan error jika judul tidak unik -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('superadmin/galeri/update-video/' . $galeri['id_galeri']) ?>" method="POST">
                <?= csrf_field() ?>
                <div class="form-group mb-3">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul', $galeri['judul']) ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label for="url">Tautan Video</label>
                    <input type="url" class="form-control" id="url" name="url" value="<?= old('url', $galeri['url']) ?>" required>
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