<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Beranda | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="container-fluid mb-5">
    <!-- Carousel -->
    <div
        id="demo"
        class="carousel slide mb-2"
        data-bs-ride="carousel">
        <!-- Indicators/dots -->
        <div class="carousel-indicators">
            <button
                type="button"
                data-bs-target="#demo"
                data-bs-slide-to="0"
                class="active"></button>
            <button
                type="button"
                data-bs-target="#demo"
                data-bs-slide-to="1"></button>
            <button
                type="button"
                data-bs-target="#demo"
                data-bs-slide-to="2"></button>
        </div>

        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img
                    src="assets/images/users/avatar-7.jpg"
                    alt="Los Angeles"
                    class="d-block"
                    style="width: 100%" />
            </div>
            <div class="carousel-item">
                <img
                    src="assets/images/small/img-2.jpg"
                    alt="Chicago"
                    class="d-block"
                    style="width: 100%" />
            </div>
            <div class="carousel-item">
                <img
                    src="assets/images/small/img-3.jpg"
                    alt="New York"
                    class="d-block"
                    style="width: 100%" />
            </div>
        </div>

        <!-- Left and right controls/icons -->
        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#demo"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#demo"
            data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Ketua & Wakil Section -->
    <section class="py-5">
        <h1 class="section-title">
            <span style="color: #0077c2">Ketua & Wakil</span>
            Balitbang Kabupaten Pesawaran
        </h1>
        <div class="d-flex flex-wrap justify-content-center">
            <div class="col-6 col-md-4 p-2">
                <img
                    src="/assets/images/bupati.png"
                    alt="Ketua"
                    class="img-fluid" />
            </div>
            <div class="col-6 col-md-4 p-2">
                <img
                    src="/assets/images/wakil-bupati.png"
                    alt="Wakil"
                    class="img-fluid" />
            </div>
        </div>
    </section>

    <!-- Berita Section -->
    <section class="py-4">
        <div class="mb-4 showall-btn d-flex align-items-center">
            <h1 class="section-title mb-0">
                <span style="color: #0077c2">Berita & Inovasi</span>
                Balitbang Kabupaten Pesawaran
            </h1>
            <button
                class="btn btn-rounded waves-effect waves-light ms-auto"
                onclick="window.location.href='berita-all.html'">
                Tampilkan Semua
            </button>
        </div>
        <?php if (!empty($beritas) && is_array($beritas)): ?>
            <?php foreach (array_slice($beritas, -3) as $berita): ?> <!-- Menampilkan 3 data terakhir -->
                <div class="news-item">
                    <div class="news-image">
                        <?php if ($berita['gambar']): ?>
                            <img
                                src="<?= $berita['gambar'] ?>"
                                alt="News Image" />
                        <?php endif; ?>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <?= date('d M Y', strtotime($berita['tanggal_post'])) ?> | Diunggah oleh
                            <span> <?= esc($berita['uploaded_by_username']) ?></span>
                        </div>
                        <div class="news-title">
                            <?= substr($berita['judul'], 0, 120) . '...' ?>
                        </div>
                        <div class="news-description">
                            <?= substr($berita['isi'], 0, 530) . '...' ?>
                        </div>
                        <div class="mt-2">
                            <a href="#" class="align-middle">Selengkapnya
                                <i class="mdi mdi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Belum ada berita yang dipublikasikan.</p>
        <?php endif; ?>
    </section>

    <!-- Foto Section -->
    <section class="py-5">
        <div class="weekly-news-area">
            <div class="weekly-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-4 showall-btn d-flex align-items-center">
                            <h1 class="section-title mb-0">
                                <span style="color: #0077c2">Galeri Foto</span>
                                Balitbang Kabupaten Pesawaran
                            </h1>
                            <button
                                class="btn btn-rounded waves-effect waves-light ms-auto"
                                onclick="window.location.href='foto-all.html'">
                                Tampilkan Semua
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div
                            class="weekly-news-active dot-style d-flex">
                            <?php foreach (array_slice($galeri, 3) as $item): ?>
                                <?php if ($item['tipe'] === 'image'): ?>
                                <div class="weekly-single">
                                    <div class="weekly-img">
                                        <img
                                            src="<?= base_url(esc($item['url'])) ?>"
                                            alt="galeri image"
                                            class="myImg" />
                                    </div>
                                    <div class="weekly-caption">
                                        <h4>
                                            <a class="captionClick"><?= $item['judul'] ?></a>
                                        </h4>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="py-4">
        <div class="mb-4 showall-btn d-flex align-items-center">
            <h1 class="section-title mb-0">
                <span style="color: #0077c2">Galeri Video</span>
                Balitbang Kabupaten Pesawaran
            </h1>
            <button
                class="btn btn-rounded waves-effect waves-light ms-auto"
                onclick="window.location.href='video-all.html'">
                Tampilkan Semua
            </button>
        </div>
        <div class="videos-section">
            <?php foreach ($galeri as $item): ?>
                <?php if ($item['tipe'] === 'video'): ?>
                    <div
                        class="video-card"
                        onclick="goToDetail('<?= $item['url'] ?>')">
                        <i class="fab fa-youtube play-icon"></i>
                        <img alt="Video Thumbnail" />
                        <div class="video-info">
                            <div class="title">
                                <?= $item['judul'] ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>