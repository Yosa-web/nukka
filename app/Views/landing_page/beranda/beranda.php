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
        <?php
        $pathImage = 'assets/uploads/images/optionweb/';

        // Fungsi untuk mencari file banner dengan ekstensi dinamis
        function getBannerFile($baseName, $path)
        {
            $extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp']; // Ekstensi yang mungkin digunakan
            foreach ($extensions as $ext) {
                $file = $path . $baseName . '.' . $ext;
                if (file_exists($file)) {
                    return $baseName . '.' . $ext; // Hanya kembalikan nama file
                }
            }
            return null; // Jika file tidak ditemukan
        }

        $banner1 = getBannerFile('banner1', $pathImage);
        $banner2 = getBannerFile('banner2', $pathImage);
        $banner3 = getBannerFile('banner3', $pathImage);
        ?>

        <!-- HTML Carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <?php if ($banner1): ?>
                    <img
                        src="<?= base_url('assets/uploads/images/optionweb/' . esc($banner1)) ?>"
                        alt="Banner 1"
                        class="d-block"
                        style="width: 100%" />
                <?php else: ?>
                    <p>Banner 1 tidak tersedia</p>
                <?php endif; ?>
            </div>
            <div class="carousel-item">
                <?php if ($banner2): ?>
                    <img
                        src="<?= base_url('assets/uploads/images/optionweb/' . esc($banner2)) ?>"
                        alt="Banner 2"
                        class="d-block"
                        style="width: 100%" />
                <?php else: ?>
                    <p>Banner 2 tidak tersedia</p>
                <?php endif; ?>
            </div>
            <div class="carousel-item">
                <?php if ($banner3): ?>
                    <img
                        src="<?= base_url('assets/uploads/images/optionweb/' . esc($banner3)) ?>"
                        alt="Banner 3"
                        class="d-block"
                        style="width: 100%" />
                <?php else: ?>
                    <p>Banner 3 tidak tersedia</p>
                <?php endif; ?>
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

    <!-- Foto Section -->
    <section class="py-5">
        <div class="weekly-news-area">
            <div class="weekly-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-4 showall-btn d-flex align-items-center">
                            <h1 class="section-title mb-0">
                                <span style="color: #0077c2">Galeri Foto</span>
                                Nukka carwash & coffee shop
                            </h1>
                            <button
                                class="btn btn-rounded waves-effect waves-light ms-auto"
                                onclick="window.location.href='<?= base_url('/foto/lainnya') ?>'">
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
                Nukka carwash & coffee shop
            </h1>
            <button
                class="btn btn-rounded waves-effect waves-light ms-auto"
                onclick="window.location.href='<?= base_url('/video/lainnya') ?>'">
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