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
            <h1 class=" pb-4 pt-2 fw-semibold">
                Tentang
            </h1>
            <div class=" mb-5">
                <h2 class="pb-3 pt-4">Nukka</h2>
                <p><?= $option['value'] ?></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>