<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Galeri Video | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url('beranda') ?>">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Video</li>
    </ol>
</div>
<div class="container-fluid mb-5">
    <h1 class="pb-4 pt-5 fw-semibold">Galeri Video</h1>
    <div class="row">
        <?php foreach ($galeri as $item): ?>
            <?php if ($item['tipe'] === 'video'): ?>
                <div class="col-sm-4">
                    <div class="galeri-content">
                        <div class="ratio ratio-16x9 mb-3">
                            <iframe class="youtube-video" src="<?= $item['url'] ?>" width="560" height="315" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <h4 class="fw-semibold mb-2">
                            <?= $item['judul'] ?>
                        </h4>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <!-- pagination -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-3 col-12 mb-5 text-center">
            <div class="d-flex justify-content-center">
                <ul class="pagination mb-sm-0">
                    <li class="page-item disabled">
                        <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                    </li>
                    <li class="page-item active">
                        <a href="#" class="page-link">1</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">2</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">3</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">4</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">5</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk membersihkan URL YouTube
    function cleanYouTubeUrl(url) {
        var videoId;

        // Cek apakah URL mengandung query parameter
        if (url.includes('?')) {
            var urlParts = url.split('?');
            videoId = urlParts[0].replace('https://youtu.be/', '');
        } else {
            videoId = url.replace('https://youtu.be/', '');
        }

        return 'https://www.youtube.com/embed/' + videoId;
    }

    // Contoh penggunaan pada elemen iframe
    var iframes = document.querySelectorAll('iframe.youtube-video');

    iframes.forEach(function(iframe) {
        var url = iframe.getAttribute('src');
        var cleanedUrl = cleanYouTubeUrl(url);
        iframe.setAttribute('src', cleanedUrl);
    });
</script>
<?= $this->endSection(); ?>