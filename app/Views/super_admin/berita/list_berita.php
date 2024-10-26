<?= $this->extend('layout/master_dashboard'); ?>

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
                                    <a href="#">Kelola Berita</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

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
                                <img src="/assets/images/small/img-3.jpg" alt="" class="img-fluid">
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
                                <h5 class=""><a href="#" class="text-body"><?= $item['judul'] ?></a></h5>
                                <p class="mb-0 font-size-15"><?= substr($item['isi'], 0, 50) . '...' ?></p>
                                <div class="row mt-3">
                                    <div class="col-8">
                                        <a href="#" class="align-middle font-size-15">Lihat Detail <i class="mdi mdi-chevron-right"></i></a>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <a href="<?= base_url('superadmin/berita/' . $item['id_berita'] . '/edit') ?>" class="btn btn-outline-warning btn-sm edit" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="<?= base_url('superadmin/berita/' . $item['id_berita']) ?>" method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-outline-danger btn-sm delete ms-2" title="Delete" id="sa-warning"><i class="fas fa-trash-alt"></i></button>
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

<!-- Sweet Alerts js -->
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
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