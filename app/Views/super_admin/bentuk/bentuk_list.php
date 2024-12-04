<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Bentuk | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">Bentuk</h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Inovasi</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Bentuk
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php if (session()->getFlashdata('errors') || session()->getFlashdata('success')): ?>
                <div class="alert alert-dismissible fade show <?= session()->getFlashdata('errors') ? 'alert-danger' : 'alert-success' ?>">
                    <?= session()->getFlashdata('errors') ?: session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- start table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div
                            class="card-header d-flex justify-content-end">
                            <a href="/superadmin/bentuk/create" class="btn btn-primary waves-effect btn-label waves-light"
                                data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <i class="bx bx-plus label-icon"></i>Tambah Data
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-nowrap align-middle table-hover"
                                    id="datatable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Bentuk</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($bentuk)): ?>
                                            <?php foreach ($bentuk as $bentuk): ?>
                                                <tr>
                                                    <td data-field="id" style="width: 80px"><?= $bentuk['id_bentuk'] ?></td>
                                                    <td data-field="nama-bentuk"><?= $bentuk['nama_bentuk'] ?></td>
                                                    <td style="width: 300px;">
                                                        <a href="javascript:void(0)" class="btn btn-outline-warning btn-sm edit" title="Edit"
                                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                                            data-id="<?= $bentuk['id_bentuk'] ?>"
                                                            data-nama="<?= $bentuk['nama_bentuk'] ?>">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="/bentuk/delete/<?= $bentuk['id_bentuk'] ?>" class="btn btn-outline-danger btn-sm delete ms-2" title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <em>Tidak ada data Bentuk untuk ditampilkan.</em>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal tambah data -->
<div
    class="modal fade"
    id="staticBackdrop"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    role="dialog"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div
        class="modal-dialog modal-dialog-centered"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="staticBackdropLabel">
                    Tambah Bentuk Inovasi
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="/bentuk/store" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label
                            for="nama_bentuk"
                            class="col-form-label">Nama
                            Bentuk</label>
                        <input
                            type="text"
                            class="form-control"
                            name="nama_bentuk"
                            id="nama_bentuk"
                            required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        data-bs-dismiss="modal"
                        id="">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal edit -->
<div
    class="modal fade"
    id="editModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    role="dialog"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div
        class="modal-dialog modal-dialog-centered"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="staticBackdropLabel">
                    Edit Bentuk Inovasi
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="" method="post" id="editForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_bentuk" class="col-form-label">Nama Bentuk</label>
                        <input type="text" class="form-control" id="edit_nama_bentuk" name="nama_bentuk" value="" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Perbarui</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                const namaBentuk = button.getAttribute('data-nama');

                // Isi input modal dengan data yang sesuai
                document.getElementById('nama_bentuk').value = namaBentuk;

                // Update form action untuk mengirim ID yang sesuai
                const form = document.querySelector('#editModal form');
                form.action = `/bentuk/update/${id}`;
            });
        });

        // Bersihkan nilai modal saat ditutup
        document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('nama_bentuk').value = '';
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                const namaBentuk = button.getAttribute('data-nama');

                // Isi input modal dengan data yang sesuai
                document.getElementById('edit_nama_bentuk').value = namaBentuk;

                // Update form action untuk mengirim ID yang sesuai
                const form = document.getElementById('editForm');
                form.action = `/bentuk/update/${id}`;
            });
        });

        // Bersihkan modal ketika ditutup
        document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('edit_nama_bentuk').value = '';
            document.getElementById('editForm').action = '';
        });
    });
</script>
<!-- Modal js -->
<script src="/assets/js/pages/modal.init.js"></script>
<!-- alertifyjs js -->
<script src="/assets/libs/alertifyjs/build/alertify.min.js"></script>
<script>
    document.getElementById('alert-success').addEventListener('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Berhasil!',
            text: 'Data berhasil diperbarui!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('#editModal form').submit();
            }
        });
    });
</script>
<!-- Sweet Alerts js -->
<script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<!-- Sweet alert init js-->
<script>
    document.querySelectorAll(".delete").forEach(function(button) {
        button.addEventListener("click", function(event) {
            event.preventDefault();

            const href = this.getAttribute("href");

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
                    window.location.href = href;
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>