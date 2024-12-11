<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Tentang | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="beranda.html">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Tentang</li>
    </ol>
</div>
<div class="container-fluid mb-5">
    <!-- start page title -->
    <div class="row content-row">
        <div class="col-sm-8">
            <h1 class="tentang-title pb-4 pt-2 fw-semibold">
                Tentang
            </h1>
            <div class="tentang-content mb-5">
                <h2 class="pb-3 pt-4">Sejarah Rumah Inovasi</h2>
                <p><?= $option['value'] ?></p>
            </div>
        </div>
        <div class="col-sm-4 headline-content">
            <h3 class="fw-semibold mb-2">Headline Terbaru</h3>
            <div class="scrollable-headline">
            <?php if (!empty($beritas) && is_array($beritas)): ?>
            <?php foreach ($beritas as $berita): ?>
                <a href="link1.html" class="headline-item">
                    <span><?= $berita['judul'] ?></span>
                    <i class="bx bx-link-external"></i>
                </a>
                <?php endforeach; ?>
        <?php else: ?>
            <p>Belum ada berita yang dipublikasikan.</p>
        <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>