<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Kelola Berita | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">
                            Kelola Berita
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Kelola Konten</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Kelola Berita
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .img-fluid {
                    aspect-ratio: 3 / 2;
                    width: 100%;
                }

                .img-fluid img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
            </style>

            <div class="row align-items-center">
                <div class="col-md-6">
                </div>

                <div class="col-md-6">
                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                        <div>
                            <a href="/superadmin/berita/create" class="btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-plus label-icon"></i>Tambah Berita</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php foreach ($berita as $item): ?>
                    <div class="col-xl-4 col-sm-6">
                        <div class="card">
                            <div class="">
                            <?php if ($item['gambar']): ?>
                                <img src="<?= base_url($item['gambar']) ?>" alt="Gambar Berita" class="img-fluid">
                            <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <p class="text-muted mb-2"><?= date('d M Y', strtotime($item['tanggal_post'])) ?>
                                        </p>
                                    </div>
                                    <div class="col-3 d-flex justify-content-end">
                                        <div>
                                            <span class="badge rounded-pill <?= $item['status'] === 'published' ? 'bg-success' : ($item['status'] === 'archive' ? 'bg-secondary' : 'bg-warning') ?>"><?= ucfirst($item['status']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <h5 class=""><a href="#" class="text-body"><?= substr($item['judul'], 0, 75) . '...' ?></a></h5>
                                <p class="mb-0 font-size-15"><?= substr($item['isi'], 0, 150) . '...' ?></p>
                                <div class="row mt-3">
                                    <div class="col-8">
                                        <a href="#" class="align-middle font-size-15">Lihat Detail <i class="mdi mdi-chevron-right"></i></a>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <a href="<?= base_url('superadmin/berita/' . $item['id_berita'] . '/edit') ?>" class="btn btn-outline-warning btn-sm edit" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form id="delete-form-<?= $item['id_berita'] ?>" action="<?= base_url('superadmin/berita/' . $item['id_berita']) ?>" method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <?= csrf_field() ?>
                                            <button type="button" class="btn btn-outline-danger btn-sm delete ms-2" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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

<!-- Sweet alert init js-->
<script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll(".delete").forEach(function(button) {
        button.addEventListener("click", function(event) {
            event.preventDefault();

            const form = this.closest("form");
            const formData = new FormData(form);

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
                    // Mengirim form menggunakan AJAX
                    fetch(form.action, {
                            method: form.method,
                            body: formData
                        })
                        .then(response => {
                            Swal.fire(
                                "Terhapus!",
                                "Data telah dihapus.",
                                "success"
                            ).then(() => {
                                // Refresh atau perbarui halaman jika diperlukan
                                location.reload();
                            });
                        })
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>