<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Data Admin OPD | Rumah Inovasi</title><?= $this->endSection() ?>
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
                                    <a href="/superadmin/user/list/admin">Admin</a>
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
                            <button type="button" class="btn btn-light btn-label position-relative me-3" onclick="window.location.href='/useractivation'"><i class="bx bx-check-double label-icon"></i>
                                Verifikasi Admin <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-1"><span class="visually-hidden">unread messages</span></span>
                            </button>
                            <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="window.location.href='<?= site_url('superadmin/adminopd/create'); ?>'"><i class="bx bx-plus label-icon"></i>Tambah Data</button>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($penggunaOPD)): ?>
                                <table id="datatable" class="table table-bordered dt-responsive w-100 table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 150px">Nama Admin</th>
                                            <th class="text-center" style="width: 200px">OPD</th>
                                            <th class="text-center" style="width: 90px">NIP</th>
                                            <th class="text-center" style="width: 80px">No. Telepon</th>
                                            <th class="text-center" style="width: 100px">Email</th>
                                            <th class="text-center" style="width: 50px">Status</th>
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
                                                <td class="text-center">
                                                    <?php if (isset($user['active'])) : ?>
                                                        <span class="badge <?= $user['active'] == 1 ? 'bg-success' : 'bg-secondary'; ?> rounded-pill">
                                                            <?= $user['active'] == 1 ? 'Aktif' : 'Non Aktif'; ?>
                                                        </span>
                                                    <?php else : ?>
                                                        <span class="badge bg-warning rounded-pill">Status Tidak Diketahui</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= site_url('/superadmin/user/edit/admin/' . $user['id']); ?>" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <form id="delete-form-<?= $user['id'] ?>" action="<?= site_url('superadmin/user/' . $user['id']); ?>" method="post" style="display:inline;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <?= csrf_field() ?>
                                                        <button type="button" class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>Tidak ada Admin OPD.</p>
                            <?php endif; ?>
                        </div>
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
