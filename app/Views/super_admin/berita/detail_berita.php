<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Detail Berita | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">
                            Detail Berita
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Kelola Konten</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/superadmin/berita/list-berita">Kelola Berita</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Detail Berita
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <div class="text-center mb-3">
                                    <h4><?= esc($berita['judul']) ?></h4>
                                </div>
                                <div class="mb-4">
                                    <?php if ($berita['gambar']): ?>
                                        <img src="<?= $berita['gambar'] ?>" alt="Gambar Berita" class="img-thumbnail mx-auto d-block">
                                    <?php endif; ?>
                                </div>

                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="mt-4 mt-sm-0">
                                                <h6 class="mb-2">Diposting pada</h6>
                                                <p class="text-muted font-size-15"><?= date('d M Y', strtotime($berita['tanggal_post'])) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div
                                                class="mt-4 mt-sm-0">
                                                <h6 class="mb-2">
                                                    Status
                                                </h6>
                                                <span class="badge bg-success rounded-pill">Diterbitkan</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div
                                                class="mt-4 mt-sm-0">
                                                <h6 class="mb-2">
                                                    Diposting oleh
                                                </h6>
                                                <p
                                                    class="text-muted font-size-15">
                                                    <?= esc($berita['uploaded_by_username']) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="mt-4">
                                    <div class="text-muted font-size-14">
                                        <p><?= nl2br(esc($berita['isi'])) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>