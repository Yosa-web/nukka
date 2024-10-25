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
                            Data OPD
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Pengguna</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="data-opd.html">Data OPD</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-end">
                            <a href="/superadmin/opd/create" class="btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-plus label-icon"></i>Tambah Data</a>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive w-100 table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px">ID</th>
                                        <th class="text-center" style="width: 200px">Nama OPD</th>
                                        <th class="text-center" style="width: 200px">Alamat</th>
                                        <th class="text-center" style="width: 120px">No. Telepon</th>
                                        <th class="text-center" style="width: 100px">Email</th>
                                        <th class="text-center" style="width: 70px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($opd as $jenis): ?>
                                        <tr>
                                            <td class="text-center"><?= $jenis['id_opd'] ?></td>
                                            <td><?= $jenis['nama_opd'] ?></td>
                                            <td><?= $jenis['alamat'] ?></td>
                                            <td class="text-center"><?= $jenis['telepon'] ?></td>
                                            <td class="text-center"><?= $jenis['email'] ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('superadmin/opd/' . $jenis['id_opd'] . '/edit') ?>" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form action="<?= base_url('superadmin/opd/' . $jenis['id_opd']) ?>" method="post" style="display: inline;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <?= csrf_field() ?>
                                                    <a class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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
            event.preventDefault();
            const href = this.getAttribute("href");

            Swal.fire({
                title: "Konfirmasi hapus data?",
                text: "",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#2ab57d",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
            }).then(function(result) {
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