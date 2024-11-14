<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Data Pegawai OPD | Rumah Inovasi</title><?= $this->endSection() ?>
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
                                    <a href="/superadmin/user/list/pegawai">Pegawai</a>
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
                            <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="window.location.href='<?= site_url('/adminopd/pegawai/create'); ?>'"><i class="bx bx-plus label-icon"></i>Tambah Data</button>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($pegawaiOPD)): ?>
                                <table id="datatable" class="table table-bordered dt-responsive w-100 table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 100px">Nama Pegawai</th>
                                            <th class="text-center" style="width: 150px">OPD</th>
                                            <th class="text-center" style="width: 50px">NIP</th>
                                            <th class="text-center" style="width: 50px">Jabatan</th>
                                            <th class="text-center" style="width: 80px">No. Telepon</th>
                                            <th class="text-center" style="width: 80px">Email</th>
                                            <th class="text-center" style="width: 50px">Status</th>
                                            <th class="text-center" style="width: 70px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pegawaiOPD as $user): ?>
                                            <tr>
                                                <td class="text-center"><?= esc($user['name']); ?></td>
                                                <td><?= esc($user['id_opd']); ?></td>
                                                <td class="text-center"><?= esc($user['NIP']); ?></td>
                                                <td class="text-center"><?= esc($user['group']); ?></td>
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
                                                    <?php
                                                        // Mengambil encrypter dari service
                                                        $encrypter = \Config\Services::encrypter();

                                                        // Pastikan id dikonversi ke string sebelum dienkripsi
                                                        $idString = strval($user['id']);
                                                        $encryptedId = bin2hex($encrypter->encrypt($idString));
                                                    ?>
                                                    <a href="<?= site_url('/adminopd/pegawai/edit/' . $encryptedId); ?>" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">Edit</a>

                                                    <form id="delete-form-<?= esc($user['id']); ?>" action="<?= site_url('/adminopd/pegawai/delete'); ?>" method="post" style="display:inline;">
                                                        <!-- Input untuk method DELETE -->
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <!-- Input tersembunyi untuk ID, tidak ditampilkan pada antarmuka -->
                                                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                                        <!-- Tombol untuk submit form -->
                                                        <button type="button" class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete" onclick="confirmDelete(<?= esc($user['id']); ?>)">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>Tidak ada Pengguna OPD (Pegawai).</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sweet alert init js-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: "Konfirmasi hapus data?",
            text: "Data yang dihapus tidak bisa dikembalikan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2ab57d",
            cancelButtonColor: "#fd625e",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user mengkonfirmasi, submit form penghapusan
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>

<?= $this->endSection(); ?>
