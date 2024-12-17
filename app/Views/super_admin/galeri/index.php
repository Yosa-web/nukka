<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Kelola Galeri | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">Kelola Galeri</h3>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Kelola Konten</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="#">Kelola Galeri</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash messages -->
            <?php if (session()->getFlashdata('errors') || session()->getFlashdata('success')): ?>
                <div class="alert alert-dismissible fade show <?= session()->getFlashdata('errors') ? 'alert-danger' : 'alert-success' ?>">
                    <?= session()->getFlashdata('errors') ?: session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-end">
                            <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="window.location.href='<?= base_url('superadmin/galeri/create') ?>'"><i class="bx bx-plus label-icon"></i>Tambah Data</button>
                        </div>
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#gambar" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Gambar</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#video" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Video</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="gambar" role="tabpanel">
                                    <div class="row mt-3">
                                        <?php foreach ($galeri as $item): ?>
                                            <?php if ($item['tipe'] === 'image'): ?>
                                                <div class="col-md-4 col-sm-6 mb-4">
                                                    <div class="card">
                                                        <img class="card-img img-fluid" src="<?= base_url(esc($item['url'])) ?>" alt="galeri image">
                                                        <div class="card-img-overlay">
                                                            <div class="row">
                                                                <div class="col-9">
                                                                    <h4 class="card-title text-white"><?= $item['judul'] ?></h4>
                                                                </div>
                                                                <div class="col-3 d-flex justify-content-end align-items-start">
                                                                    <a href="/superadmin/galeri/edit/<?= $item['id_galeri'] ?>" class="btn btn-warning btn-rounded btn-sm edit" title="Edit">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                    <form action="<?= base_url('superadmin/galeri/' . $item['id_galeri']) ?>" method="post">
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <?= csrf_field() ?>
                                                                        <button type="button" class="btn btn-danger btn-rounded btn-sm delete ms-2" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <p class="card-text">
                                                                    <small class="text-white">Diperbarui pada <?= date('d M Y', strtotime($item['uploaded_at'])) ?></small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="video" role="tabpanel">
                                    <div class="row mt-3">
                                        <?php foreach ($galeri as $item): ?>
                                            <?php if ($item['tipe'] === 'video'): ?>
                                                <div class="col-md-4 col-sm-6 mb-4">
                                                    <div class="card">
                                                        <div class="ratio ratio-16x9">
                                                            <?php
                                                            $youtubeUrl = htmlspecialchars($item['url']);
                                                            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=))([a-zA-Z0-9_-]{11})/', $youtubeUrl, $matches);
                                                            $videoId = isset($matches[1]) ? $matches[1] : null;
                                                            if ($videoId) {
                                                                $embedUrl = "https://www.youtube.com/embed/" . $videoId;
                                                                echo "<iframe src=\"$embedUrl\" title=\"YouTube video\" allowfullscreen></iframe>";
                                                            } else {
                                                                echo "Invalid YouTube URL.";
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="card-text">
                                                                Diperbarui pada <?= date('d M Y', strtotime($item['uploaded_at'])) ?>
                                                            </p>
                                                            <h4 class="text-body"><?= $item['judul'] ?></h4>
                                                            <div class="row mt-3">
                                                                <div class="col-12 d-flex justify-content-end">
                                                                    <a href="/superadmin/galeri/edit/<?= $item['id_galeri'] ?>" class="btn btn-outline-warning btn-sm edit" title="Edit">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                    <form action="<?= base_url('superadmin/galeri/' . $item['id_galeri']) ?>" method="post">
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <?= csrf_field() ?>
                                                                        <button type="button" class="btn btn-outline-danger btn-sm delete ms-2" title="Edit"><i class="fas fa-trash-alt"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <!-- pagination -->
                                <div class="row justify-content-center mb-4">
                                    <div class="col-md-3">
                                        <div class="">
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
                                                    <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                                </li>
                                            </ul>
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
</div>
</div>

<!-- CSS Internal -->
<style>
    .card {
        height: 100%;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-img {
        height: 250px;
        /* Tentukan tinggi gambar jika perlu */
        object-fit: cover;
    }

    .card-title,
    .card-text {
        margin-bottom: 10px;
    }

    .card-footer {
        margin-top: auto;
    }
</style>

<script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script>
    document.querySelectorAll(".delete").forEach(function(button) {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            const form = this.closest("form");
            Swal.fire({
                title: "Konfirmasi hapus?",
                text: "Anda yakin ingin menghapus data ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#2ab57d",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>