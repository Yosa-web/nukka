<?= $this->extend('layout/master_dashboard'); ?>

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
                            Data Pegawai
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Pengguna</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Data Pengguna</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="data-pegawai.html">Pegawai</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-end">
                            <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="window.location.href='tambah-pegawai.html'"><i class="bx bx-plus label-icon"></i>Tambah Data</button>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive w-100 table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 100px">Nama Pegawai</th>
                                        <th class="text-center" style="width: 180px">OPD</th>
                                        <th class="text-center" style="width: 80px">NIP</th>
                                        <th class="text-center" style="width: 100px">Jabatan</th>
                                        <th class="text-center" style="width: 100px">No. Telepon</th>
                                        <th class="text-center" style="width: 100px">Email</th>
                                        <th class="text-center" style="width: 70px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">Kepala 1</td>
                                        <td>Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Pesawaran</td>
                                        <td class="text-center">1932xxxxxxxxxxxx</td>
                                        <td class="text-center">Kepala OPD</td>
                                        <td class="text-center">0721xxxxxxxx</td>
                                        <td class="text-center">kominfo@pesawarankab.go.id</td>
                                        <td class="text-center">
                                            <a href="edit-pegawai.html" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete" id="sa-warning">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Kepala 2</td>
                                        <td>Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Pesawaran</td>
                                        <td class="text-center">1932xxxxxxxxxxxx</td>
                                        <td class="text-center">Kepala OPD</td>
                                        <td class="text-center">0721xxxxxxxx</td>
                                        <td class="text-center">kominfo@pesawarankab.go.id</td>
                                        <td class="text-center">
                                            <a href="edit-pegawai.html" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete" id="sa-warning">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Kepala 3</td>
                                        <td>Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Pesawaran</td>
                                        <td class="text-center">1932xxxxxxxxxxxx</td>
                                        <td class="text-center">Kepala OPD</td>
                                        <td class="text-center">0721xxxxxxxx</td>
                                        <td class="text-center">kominfo@pesawarankab.go.id</td>
                                        <td class="text-center">
                                            <a href="edit-pegawai.html" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete" id="sa-warning">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Kepala 4</td>
                                        <td>Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Pesawaran</td>
                                        <td class="text-center">1932xxxxxxxxxxxx</td>
                                        <td class="text-center">Kepala OPD</td>
                                        <td class="text-center">0721xxxxxxxx</td>
                                        <td class="text-center">kominfo@pesawarankab.go.id</td>
                                        <td class="text-center">
                                            <a href="edit-pegawai.html" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete" id="sa-warning">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Kepala 5</td>
                                        <td>Dinas Komunikasi Informatika Statistik dan Persandian Kabupaten Pesawaran</td>
                                        <td class="text-center">1932xxxxxxxxxxxx</td>
                                        <td class="text-center">Kepala OPD</td>
                                        <td class="text-center">0721xxxxxxxx</td>
                                        <td class="text-center">kominfo@pesawarankab.go.id</td>
                                        <td class="text-center">
                                            <a href="edit-pegawai.html" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete" id="sa-warning">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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