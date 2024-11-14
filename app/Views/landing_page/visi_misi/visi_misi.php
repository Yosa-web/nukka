<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Visi & Misi | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="beranda.html">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Visi & Misi</li>
    </ol>
</div>
<div class="container-fluid mb-5">
    <!-- start page title -->
    <div class="row content-row">
        <div class="col-7">
            <h1 class="pb-4 pt-3 fw-semibold">Visi & Misi</h1>
            <div class="mb-5">
                <h2 class="pb-3 pt-3" style="color: #0077c2">
                    Visi :
                </h2>
                <p class="visi-content">
                    “Mewujudkan masyarakat Kabupaten Pesawaran yang
                    Religius, Cerdas, Sehat dan Sejahtera”
                </p>
            </div>
            <div class="mb-5">
                <h2 class="pb-3 pt-3" style="color: #0077c2">
                    Misi :
                </h2>
                <div class="misi-content">
                    <div class="misi-item">
                        <p>
                            Meningkatkan penerapan nilai-nilai
                            keagamaan dalam kehidupan bermasyarakat
                            menuju masyarakat yang religius.
                        </p>
                    </div>
                    <div class="misi-item pt-3">
                        <p>
                            Meningkatkan akses mutu dan pemerataan
                            pelayanan pendidikan dan kesehatan untuk
                            mewujudkan masyarakat yang cerdas dan
                            sehat.
                        </p>
                    </div>
                    <div class="misi-item pt-3">
                        <p>
                            Mengembangkan ekonomi daerah yang
                            kompetitif dan berbasis kerakyatan.
                        </p>
                    </div>
                    <div class="misi-item pt-3">
                        <p>
                            Meningkatkan kualitas tata kelola
                            pemerintahan yang professional,
                            transparan dan akuntabel.
                        </p>
                    </div>
                    <div class="misi-item pt-3">
                        <p>
                            Meningkatkan pemerataan pembangunan
                            infrastruktur yang berkelanjutan dan
                            pengelolaan lingkungan hidup berdasarkan
                            Rencana Tata Ruang Wilayah.
                        </p>
                    </div>
                    <div class="misi-item pt-3">
                        <p>
                            Mengembangkan inovasi daerah dalam
                            rangka meningkatkan kualitas daya saing
                            daerah, masyarakat dan pelaku
                            pembangunan lainnya.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5 ps-5">
            <div class="visimisi-image">
                <img
                    src="assets/images/small/img-3.jpg"
                    alt="Image" />
                <img
                    src="assets/images/small/img-3.jpg"
                    alt="Image" />
                <img
                    src="assets/images/small/img-3.jpg"
                    alt="Image" />
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>