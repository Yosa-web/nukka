<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Galeri Foto | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url('beranda') ?>">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Foto</li>
    </ol>
</div>
<div class="container-fluid mb-5">
    <h1 class="pb-4 pt-5 fw-semibold">Galeri Foto</h1>
    <div class="row">
        <?php foreach (array_slice($galeri, 3) as $item): ?>
            <?php if ($item['tipe'] === 'image'): ?>
                <div class="col-sm-4">
                    <div class="galeri-content">
                        <img
                            src="<?= base_url(esc($item['url'])) ?>"
                            alt="Image"
                            class="myImg" />
                        <h4 class="fw-semibold mb-2 captionClick">
                            <?= $item['judul'] ?>
                        </h4>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <!-- pagination -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-3 col-12 mb-5 text-center">
            <div class="d-flex justify-content-center">
                <ul class="pagination mb-sm-0">
                    <li class="page-item disabled">
                        <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                    </li>
                    <li class="page-item active">
                        <a href="#" class="page-link">1</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">2</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">3</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">4</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">5</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>