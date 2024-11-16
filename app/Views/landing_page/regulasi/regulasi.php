<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Regulasi | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="beranda.html">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Regulasi</li>
    </ol>
</div>
<div class="container-fluid mb-5">
    <div class="regulasi-content">
        <h1 class="pb-3 pt-5 fw-semibold text-center">Regulasi</h1>
        <div class="isi-regulasi pb-5">
            <p><?= $option['value'] ?></p>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>