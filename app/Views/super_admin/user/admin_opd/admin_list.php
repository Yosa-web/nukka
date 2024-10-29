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
                            Data Admin
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
                                    <a href="data-admin.html">Admin</a>
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
                            <button type="button" class="btn btn-light btn-label position-relative me-3" onclick="window.location.href='verifikasi-admin.html'"><i class="bx bx-check-double label-icon"></i>
                                Verifikasi Admin <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-1"><span class="visually-hidden">unread messages</span></span>
                            </button>
                            <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="window.location.href='tambah-admin.html'"><i class="bx bx-plus label-icon"></i>Tambah Data</button>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($penggunaOPD)): ?>
                                <table id="datatable" class="table table-bordered dt-responsive w-100 table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 100px">Nama Admin</th>
                                            <th class="text-center" style="width: 200px">OPD</th>
                                            <th class="text-center" style="width: 90px">NIP</th>
                                            <th class="text-center" style="width: 80px">No. Telepon</th>
                                            <th class="text-center" style="width: 100px">Email</th>
                                            <th class="text-center" style="width: 70px">Status</th>
                                            <th class="text-center" style="width: 70px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($penggunaOPD as $user): ?>
                                            <tr>
                                                <td class="text-center"><?= esc($user['name']); ?></td>
                                                <td><?= esc($user['id_opd']); ?></td>
                                                <td class="text-center"><?= esc($user['NIP']); ?></td>
                                                <td class="text-center"><?= esc($user['no_telepon']); ?></td>
                                                <td class="text-center"><?= esc($user['email']); ?></td>
                                                <td class="text-center"><span class="badge bg-success rounded-pill">Aktif</span></td>
                                                <td class="text-center">
                                                    <a href="<?= site_url('superadmin/user/edit/' . $user['id']); ?>" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete" id="sa-warning">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                    <form action="<?= site_url('superadmin/user/' . $user['id']); ?>" method="post">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete" id="sa-warning" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>Tidak ada Pengguna OPD.</p>
                            <?php endif; ?>
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