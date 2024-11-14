<?= $this->extend('layout/master_dashboard'); ?>

<?= $this->section('content'); ?>
<?= $this->section('title') ?><title>Data OPD | Rumah Inovasi</title><?= $this->endSection() ?>
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
                                    Data OPD
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
                                    <?php foreach ($opds as $jenis): ?>
                                        <tr>
                                            <td class="text-center"><?= $jenis->id_opd ?></td>
                                            <td><?= $jenis->nama_opd ?></td>
                                            <td><?= $jenis->alamat ?></td>
                                            <td class="text-center"><?= $jenis->telepon ?></td>
                                            <td class="text-center"><?= $jenis->email ?></td>
                                            <td class="text-center">
                                            <a href="<?= base_url('superadmin/opd/edit/' . $jenis->encrypted_id) ?>" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                                <form id="delete-form-<?= $jenis->id_opd ?>" action="<?= base_url('superadmin/opd') ?>" method="post" style="display: inline;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="id_opd" value="<?= $jenis->id_opd ?>">
                                                    <?= csrf_field() ?>
                                                    <button type="button" class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
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
                        if (response.ok) {
                            // Tampilkan SweetAlert sukses setelah penghapusan berhasil
                            Swal.fire(
                                "Terhapus!",
                                "Data telah dihapus.",
                                "success"
                            ).then(() => {
                                // Refresh atau perbarui halaman jika diperlukan
                                location.reload();
                            });
                        } else {
                            throw new Error('Gagal menghapus data');
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            "Error",
                            "Terjadi kesalahan saat menghapus data.",
                            "error"
                        );
                    });
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>