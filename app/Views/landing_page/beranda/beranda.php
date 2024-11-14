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
                    src="assets/images/bupati.png"
                    alt="Ketua"
                    class="img-fluid" />
            </div>
            <div class="col-6 col-md-4 p-2">
                <img
                    src="assets/images/wakil-bupati.png"
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
        <div class="news-item">
            <div class="news-image">
                <img
                    src="assets/images/users/avatar-10.jpg"
                    alt="News Image" />
            </div>
            <div class="news-content">
                <div class="news-meta">
                    01 Oct 2024 | Diunggah oleh
                    <span>Superadmin</span>
                </div>
                <div class="news-title">
                    Bupati Dendi Ramadhona Hadiri Peletakan Batu
                    Pertama Pembangunan Masjid Ash Shihhah RSUD
                    Pesawaran
                </div>
                <div class="news-description">
                    Pesawaran, 31 Oktober 2024 - Bupati Pesawaran
                    Dendi Ramadhona menghadiri dan memimpin secara
                    langsung peletakan batu pertama pembangunan
                    Masjid Ash-Shihah RSUD Kabupaten Pesawaran pada
                    Kamis, (31/10/2024). Turut hadir mendampingi
                    Kepala Dinas Kesehatan Media Apriliana, Kepala
                    Kantor Kementerian Agama, Kadis Kominfotiksan
                    yang diwakili Sekretaris Dinas Apriya, Direktur
                    RSUD Dian Adhitama, serta para tamu undangan
                    lainnya....
                </div>
                <div class="mt-2">
                    <a href="#" class="align-middle">Selengkapnya
                        <i class="mdi mdi-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="news-item">
            <div class="news-image">
                <img
                    src="assets/images/users/avatar-2.jpg"
                    alt="News Image" />
            </div>
            <div class="news-content">
                <div class="news-meta">
                    01 Oct 2024 | Diunggah oleh
                    <span>Superadmin</span>
                </div>
                <div class="news-title">
                    Bupati Dendi Ramadhona Hadiri Peletakan Batu
                    Pertama Pembangunan Masjid Ash Shihhah RSUD
                    Pesawaran
                </div>
                <div class="news-description">
                    Pesawaran, 31 Oktober 2024 - Bupati Pesawaran
                    Dendi Ramadhona menghadiri dan memimpin secara
                    langsung peletakan batu pertama pembangunan
                    Masjid Ash-Shihah RSUD Kabupaten Pesawaran pada
                    Kamis, (31/10/2024). Turut hadir mendampingi
                    Kepala Dinas Kesehatan Media Apriliana, Kepala
                    Kantor Kementerian Agama, Kadis Kominfotiksan
                    yang diwakili Sekretaris Dinas Apriya, Direktur
                    RSUD Dian Adhitama, serta para tamu undangan
                    lainnya...
                </div>
                <div class="mt-2">
                    <a href="#" class="align-middle">Selengkapnya
                        <i class="mdi mdi-chevron-right"></i></a>
                </div>
            </div>
        </div>
        <div class="news-item">
            <div class="news-image">
                <img
                    src="assets/images/small/img-3.jpg"
                    alt="News Image" />
            </div>
            <div class="news-content">
                <div class="news-meta">
                    01 Oct 2024 | Diunggah oleh
                    <span>Superadmin</span>
                </div>
                <div class="news-title">
                    Bupati Dendi Ramadhona Hadiri Peletakan Batu
                    Pertama Pembangunan Masjid Ash Shihhah RSUD
                    Pesawaran
                </div>
                <div class="news-description">
                    Pesawaran, 31 Oktober 2024 - Bupati Pesawaran
                    Dendi Ramadhona menghadiri dan memimpin secara
                    langsung peletakan batu pertama pembangunan
                    Masjid Ash-Shihah RSUD Kabupaten Pesawaran pada
                    Kamis, (31/10/2024). Turut hadir mendampingi
                    Kepala Dinas Kesehatan Media Apriliana, Kepala
                    Kantor Kementerian Agama, Kadis Kominfotiksan
                    yang diwakili Sekretaris Dinas Apriya, Direktur
                    RSUD Dian Adhitama, serta para tamu undangan
                    lainnya...
                </div>
                <div class="mt-2">
                    <a href="#" class="align-middle">Selengkapnya
                        <i class="mdi mdi-chevron-right"></i></a>
                </div>
            </div>
        </div>
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
                            <div class="weekly-single">
                                <div class="weekly-img">
                                    <img
                                        src="assets/images/small/img-5.jpg"
                                        alt=""
                                        class="myImg" />
                                </div>
                                <div class="weekly-caption">
                                    <h4>
                                        <a class="captionClick">Bupati Dendi Ramadhona
                                            Hadiri Peletakan Batu
                                            Pertama Pembangunan
                                            Masjid Ash Shihh...</a>
                                    </h4>
                                </div>
                            </div>
                            <div class="weekly-single">
                                <div class="weekly-img">
                                    <img
                                        src="assets/images/small/img-4.jpg"
                                        alt=""
                                        class="myImg" />
                                </div>
                                <div class="weekly-caption">
                                    <h4>
                                        <a class="captionClick">Lorem ipsum dolor sit
                                            amet consectetur
                                            adipisicing elit. A
                                            accusamus dolore in
                                            animi amet...</a>
                                    </h4>
                                </div>
                            </div>
                            <div class="weekly-single">
                                <div class="weekly-img">
                                    <img
                                        src="assets/images/small/img-3.jpg"
                                        alt=""
                                        class="myImg" />
                                </div>
                                <div class="weekly-caption">
                                    <h4>
                                        <a class="captionClick">Bawaslu Merekomendasi
                                            Camat di Pesawaran
                                            Lampung Dapat Sanksi
                                            BKN...</a>
                                    </h4>
                                </div>
                            </div>
                            <div class="weekly-single">
                                <div class="weekly-img">
                                    <img
                                        src="assets/images/small/img-7.jpg"
                                        alt=""
                                        class="myImg" />
                                </div>
                                <div class="weekly-caption">
                                    <h4>
                                        <a class="captionClick">Swasembada Pangan
                                            Budidaya Peternakan Ikan
                                            Air Tawar Di
                                            Pesawaran...</a>
                                    </h4>
                                </div>
                            </div>
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
            <!-- Card 1 -->
            <div
                class="video-card"
                onclick="goToDetail('https://youtu.be/xTBDsVl9fQQ?si=ucZu_CdzhOwAHFsD')">
                <i class="fab fa-youtube play-icon"></i>
                <img alt="Video Thumbnail" />
                <div class="video-info">
                    <div class="title">
                        Perayaan HUT RI Ke-79 Tingkat Kabupaten
                        Tangerang: Upacara Detik-Detik Proklamasi
                        (Parade)
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div
                class="video-card"
                onclick="goToDetail('https://youtu.be/-IZMJ18x1rM?si=5bJJTHpwcvKq1J3e')">
                <i class="fab fa-youtube play-icon"></i>
                <img alt="Video Thumbnail" />
                <div class="video-info">
                    <div class="title">
                        Pj Bupati Tangerang Terima Tim Penilai Lomba
                        Desa Tingkat Provinsi Banten
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div
                class="video-card"
                onclick="goToDetail('https://youtu.be/EfWSAzXlvtc?si=vQ8B-jeo88uvJo0G')">
                <i class="fab fa-youtube play-icon"></i>
                <img alt="Video Thumbnail" />
                <div class="video-info">
                    <div class="title">
                        1.137 Pelajar Antusias Ikut Invitasi
                        Olahraga Tradisional
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div
                class="video-card"
                onclick="goToDetail('https://youtu.be/GPAYzaE-trs?si=Y5J17y70rancexSq')">
                <i class="fab fa-youtube play-icon"></i>
                <img alt="Video Thumbnail" />
                <div class="video-info">
                    <div class="title">
                        DPKPP Gelar Gerakan Pangan Murah untuk Tekan
                        Inflasi
                    </div>
                </div>
            </div>
            <!-- Card 5 -->
            <div
                class="video-card"
                onclick="goToDetail('https://youtu.be/ThM0EdT1ByU?si=ayLNwlLjlGJW_N4kv')">
                <i class="fab fa-youtube play-icon"></i>
                <img alt="Video Thumbnail" />
                <div class="video-info">
                    <div class="title">
                        Pemkab Tangerang Luncurkan Gebrak Tegas
                        untuk Atasi Kemiskinan Ekstrem dan Stunting
                    </div>
                </div>
            </div>
            <!-- Card 6 -->
            <div
                class="video-card"
                onclick="goToDetail('https://youtu.be/v-OIspcC-E8?si=ZLVh-UtkaLm3oCoY')">
                <i class="fab fa-youtube play-icon"></i>
                <img alt="Video Thumbnail" />
                <div class="video-info">
                    <div class="title">
                        Pemkab Tangerang Luncurkan Gebrak Tegas
                        untuk Atasi Kemiskinan Ekstrem dan Stunting
                    </div>
                </div>
            </div>
            <!-- Card 7 -->
            <div
                class="video-card"
                onclick="goToDetail('https://youtu.be/8Ebqe2Dbzls?si=zszMygtSBz16iyhG')">
                <i class="fab fa-youtube play-icon"></i>
                <img alt="Video Thumbnail" />
                <div class="video-info">
                    <div class="title">
                        Pemkab Tangerang Luncurkan Gebrak Tegas
                        untuk Atasi Kemiskinan Ekstrem dan Stunting
                    </div>
                </div>
            </div>
            <!-- Card 8 -->
            <div
                class="video-card"
                onclick="goToDetail('https://youtu.be/Nt3YH68npW4?si=RO-uPpPIBEzin7pr')">
                <i class="fab fa-youtube play-icon"></i>
                <img alt="Video Thumbnail" />
                <div class="video-info">
                    <div class="title">
                        Pemkab Tangerang Luncurkan Gebrak Tegas
                        untuk Atasi Kemiskinan Ekstrem dan Stunting
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>