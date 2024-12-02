<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Detail Berita | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url('beranda') ?>">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Berita</li>
    </ol>
</div>
<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-sm-8 head-news">
            <h2 class="pb-4 fw-semibold">
                <?= esc($berita['judul']) ?>
            </h2>
            <?php if ($berita['gambar']): ?>
                <img src="<?= base_url($berita['gambar']) ?>" alt="Gambar Berita" />
            <?php endif; ?>
            <div class="mb-5">
                <div
                    class="news-content"
                    style="text-align: justify">
                    <div class="news-date">
                        <?= date('d M Y', strtotime($berita['tanggal_post'])) ?> | Diunggah oleh
                        <span><?= esc($berita['uploaded_by_username']) ?></span>
                    </div>
                    <div class="news-title"></div>
                    <div class="news-description">
                        <?= $berita['isi'] ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 berita-lainnya">
            <h3 class="pb-4 fw-semibold">Berita Lainnya</h3>
            <?php if (!empty($randberita) && is_array($randberita)): ?>
                <?php
                // Acak array
                shuffle($randberita);
                // Ambil maksimal 3 elemen pertama
                $beritaLainnya = array_slice($randberita, 0, 3);
                ?>
                <?php foreach ($beritaLainnya as $berita): ?>
                    <div class="news-all pb-3" style="border-bottom: 2px solid #ddd;">
                        <p><?= date('d M Y', strtotime($berita['tanggal_post'])) ?></p>
                        <h4><a href="<?= base_url('berita/detail/' . $berita['slug']) ?>"><?= substr($berita['judul'], 0, 120) . '...' ?></a></h4>
                        <p><?= substr($berita['isi'], 0, 300) . '...' ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada berita yang dipublikasikan.</p>
            <?php endif; ?>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>