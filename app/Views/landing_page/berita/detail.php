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
        // Ambil slug dari berita yang sedang dibuka
        $currentSlug = $berita['slug'];

        // Filter array untuk menghapus berita yang sedang dibuka
        $filteredBerita = array_filter($randberita, function ($beritaItem) use ($currentSlug) {
            return $beritaItem['slug'] !== $currentSlug;
        });

        // Acak array yang sudah difilter
        shuffle($filteredBerita);

        // Ambil maksimal 3 elemen pertama
        $beritaLainnya = array_slice($filteredBerita, 0, 3);
        ?>
        <?php if (!empty($beritaLainnya)): ?>
            <?php foreach ($beritaLainnya as $beritaItem): ?>
                <div class="news-all pb-3" style="border-bottom: 2px solid #ddd;">
                    <p><?= date('d M Y', strtotime($beritaItem['tanggal_post'])) ?></p>
                    <h4><a href="<?= base_url('berita/detail/' . $beritaItem['slug']) ?>"><?= substr($beritaItem['judul'], 0, 120) . '...' ?></a></h4>
                    <p><?= substr($beritaItem['isi'], 0, 300) . '...' ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Belum ada berita lain yang dipublikasikan.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Belum ada berita yang dipublikasikan.</p>
    <?php endif; ?>
</div>
        

<?= $this->endSection(); ?>