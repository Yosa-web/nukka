<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Berita | Rumah Inovasi</title><?= $this->endSection() ?>
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
    <h1 class="pb-4 pt-4 fw-semibold">Berita Terbaru</h1>
    <div class="row row-1">
        <div class="col-sm-8 head-news">
            <?php if ($new_berita['gambar']): ?>
                <img src="<?= base_url($new_berita['gambar']) ?>" alt="News Image">
            <?php endif; ?>
            <div class="mb-5">
                <div class="news-content" style="text-align: justify;">
                    <div class="news-meta">
                        <?= date('d M Y', strtotime($new_berita['tanggal_post'])) ?> | Diunggah oleh
                        <span><?= esc($new_berita['uploaded_by_username']) ?></span>
                    </div>
                    <div class="news-title">
                        <a href="<?= base_url('berita/detail/' . $new_berita['slug']) ?>"><?= substr($new_berita['judul'], 0, 120) . '...' ?></a>
                    </div>
                    <div class="news-description">
                        <?= substr($new_berita['isi'], 0, 530) . '...' ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <?php if (!empty($new_beritas) && is_array($new_beritas)): ?>
                <?php foreach (array_slice($new_beritas, -3) as $berita): ?> <!-- Menampilkan 3 data terakhir -->
                    <div class="news-all">
                        <p><?= date('d M Y', strtotime($berita['tanggal_post'])) ?>
                        </p>
                        <h4 class="fw-semibold">
                            <?= substr($berita['judul'], 0, 120) . '...' ?>
                        </h4>
                        <p>
                            <?= substr($berita['isi'], 0, 200) . '...' ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada berita yang dipublikasikan.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row row-2">
        <div class="col-sm-4 pe-5 mt-5 pt-3">
            <h3 class="fw-semibold mb-4">Headline Terbaru</h3>
            <div class="scrollable-headline">
                <?php if (!empty($new_beritas) && is_array($new_beritas)): ?>
                    <?php foreach ($new_beritas as $berita): ?> <!-- Menampilkan 3 data terakhir -->
                        <a href="<?= base_url('berita/detail/' . $berita['slug']) ?>" class="headline-item">
                            <span> <?= substr($berita['judul'], 0, 120) . '...' ?></span>
                            <i class="bx bx-link-external"></i>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Belum ada berita yang dipublikasikan.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-sm-8 mb-5">
            <?php if (!empty($beritas) && is_array($beritas)): ?>
                <?php foreach ($beritas as $berita): ?> <!-- Menampilkan 3 data terakhir -->
                    <div class="news-other pt-3 hidden">
                        <?php if ($berita['gambar']): ?>
                            <img
                                src="<?= base_url($berita['gambar']) ?>"
                                alt="News Image" />
                        <?php endif; ?>
                        <a href="#" class="other-div">
                            <p>
                                <?= date('d M Y', strtotime($berita['tanggal_post'])) ?>
                            </p>
                            <h4 class="fw-semibold mb-2">
                                <?= substr($berita['judul'], 0, 120) . '...' ?>
                            </h4>
                            <p>
                                <?= substr($berita['isi'], 0, 300) . '...' ?>
                            </p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada berita yang dipublikasikan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>