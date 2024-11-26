<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Kelola Galeri | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">
                            Kelola Galeri
                        </h3>

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
            <!-- Style added here -->
            <style>
                .card-img-overlay {
                    opacity: 0;
                    transition: opacity 0.3s ease-in-out;
                    background-color: rgba(0, 0, 0, 0.5);
                }

                .card-img:hover {
                    filter: brightness(75%);
                }

                .card-img-overlay:hover {
                    opacity: 1;
                }

                .card-img {
                    aspect-ratio: 3 / 2;
                    width: 100%;
                }

                .card-img img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
            </style>
            <!-- End of style -->
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
                                                <div class="col-lg-4">
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
                                                                        <button type="submit" class="btn btn-danger btn-rounded btn-sm delete ms-2" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus?')"><i class="fas fa-trash-alt"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <p class="card-text">
                                                                    <small class="text-white">Terakhir diperbarui oleh (User)</small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="row justify-content-center mt-2">
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
                                <div class="tab-pane" id="video" role="tabpanel">
                                    <div class="row mt-3">
                                        <?php foreach ($galeri as $item): ?>
                                            <?php if ($item['tipe'] === 'video'): ?>
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card">
                                                        <div class="ratio ratio-16x9">
                                                            <?php
                                                            $youtubeUrl = htmlspecialchars($item['url']);

                                                            // Ekstrak ID video dari URL
                                                            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=))([a-zA-Z0-9_-]{11})/', $youtubeUrl, $matches);
                                                            $videoId = isset($matches[1]) ? $matches[1] : null;

                                                            // Buat URL embed
                                                            if ($videoId) {
                                                                $embedUrl = "https://www.youtube.com/embed/" . $videoId;
                                                                echo $embedUrl; // Menampilkan URL embed
                                                            } else {
                                                                echo "Invalid YouTube URL.";
                                                            }
                                                            ?>
                                                            <iframe src="<?= $embedUrl ?>" title="YouTube video" allowfullscreen></iframe>
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="text-muted mb-2">Terakhir diperbarui oleh (User)</p>
                                                            <h4 class="text-body"><?= $item['judul'] ?></h4>
                                                            <div class="row mt-3">
                                                                <div class="col-12 d-flex justify-content-end">
                                                                    <a href="/superadmin/galeri/edit/<?= $item['id_galeri'] ?>" class="btn btn-outline-warning btn-sm edit" title="Edit">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                    <form action="<?= base_url('superadmin/galeri/' . $item['id_galeri']) ?>" method="post">
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <?= csrf_field() ?>
                                                                        <button type="submit" class="btn btn-outline-danger btn-sm delete ms-2" title="Edit" onclick="return confirm('Apakah Anda yakin ingin menghapus?')"><i class="fas fa-trash-alt"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="row justify-content-center mt-2">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sweet Alerts js -->
<script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<!-- Sweet alert init js-->
<script>
    document
        .getElementById("sa-warning")
        .addEventListener("click", function() {
            Swal.fire({
                title: "Konfirmasi hapus data?",
                text: "",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#2ab57d",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
            }).then(function(e) {
                e.value &&
                    Swal.fire(
                        "Terhapus!",
                        "Data telah dihapus",
                        "success",
                    );
            });
        });
</script>
<?= $this->endSection(); ?>