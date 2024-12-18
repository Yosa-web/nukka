<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Visi & Misi | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>

<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= site_url('beranda') ?>">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Visi & Misi</li>
    </ol>
</div>

<div class="container-fluid mb-5">
    <div class="row content-row">
        <div class="col-7">
            <h1 class="pb-4 pt-3 fw-semibold">Visi & Misi</h1>

            <!-- Visi -->
            <div class="mb-5">
                <h2 class="pb-3 pt-3" style="color: #0077c2">Visi:</h2>
                <div class="visi-content">
                    <?= $visi ?> <!-- Menampilkan HTML langsung -->
                </div>
            </div>

            <!-- Misi -->
            <div class="mb-5">
                <h2 class="pb-3 pt-3" style="color: #0077c2">Misi:</h2>
                <div class="misi-content">
                    <?= $misi ?> <!-- Menampilkan HTML langsung -->
                </div>
            </div>
        </div>

        <?php
        $pathImage = 'assets/uploads/images/optionweb/';

        // Fungsi untuk mencari file banner dengan ekstensi dinamis
        function getBannerFile($baseName, $path)
        {
            $extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp']; // Ekstensi yang mungkin digunakan
            foreach ($extensions as $ext) {
                $file = $path . $baseName . '.' . $ext;
                if (file_exists($file)) {
                    return base_url($file);
                }
            }
            return base_url('assets/images/default.jpg'); // Jika file tidak ditemukan, gunakan default
        }

        $banner1 = getBannerFile('banner1', $pathImage);
        $banner2 = getBannerFile('banner2', $pathImage);
        $banner3 = getBannerFile('banner3', $pathImage);
        ?>

        <!-- Kolom Gambar -->
        <div class="col-5 ps-5">
            <div class="visimisi-image">
                <img src="<?= $banner1 ?>" alt="Banner 1" class="img-fluid mb-3" />
                <img src="<?= $banner2 ?>" alt="Banner 2" class="img-fluid mb-3" />
                <img src="<?= $banner3 ?>" alt="Banner 3" class="img-fluid mb-3" />
            </div>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>