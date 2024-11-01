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
                            Data Pengguna Umum
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
                                    <a href="data-pengguna-umum.html">Umum</a>
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
                            <a href="<?= base_url('superadmin/userumum/create') ?>" class="btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-plus label-icon"></i>Tambah Data</a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($penggunaUmum)): ?>
                                <table id="datatable" class="table table-bordered dt-responsive w-100 table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 100px">Nama Pengguna</th>
                                            <th class="text-center" style="width: 100px">NIK</th>
                                            <th class="text-center" style="width: 100px">No. Telepon</th>
                                            <th class="text-center" style="width: 80px">Email</th>
                                            <th class="text-center" style="width: 70px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($penggunaUmum as $user): ?>
                                            <tr>
                                                <td class="text-center"><?= esc($user['name']); ?></td>
                                                <td class="text-center"><?= esc($user['NIK']); ?></td>
                                                <td class="text-center"><?= esc($user['no_telepon']); ?></td>
                                                <td class="text-center"><?= esc($user['email']); ?></td>
                                                <td class="text-center">
                                                    <a href="<?= site_url('penggunaumum/edit/' . $user['id']); ?>" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete" id="sa-warning">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                    <form action="<?= site_url('penggunaumum/delete/' . $user['id']); ?>" method="post">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete" id="sa-warning" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>Tidak ada Pengguna Umum.</p>
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