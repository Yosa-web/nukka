<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Jenis Inovasi | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">Jenis Inovasi</h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Inovasi</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Jenis Inovasi
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <!-- start table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div
                            class="card-header d-flex justify-content-end">
                            <a href="/superadmin/jenis_inovasi/create" class="btn btn-primary waves-effect btn-label waves-light"
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
                                            <th>Nama Jenis</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($jenis_inovasi as $jenis): ?>
                                            <tr>
                                                <td
                                                    data-field="id"
                                                    style="width: 80px"><?= $jenis['id_jenis_inovasi'] ?></td>
                                                <td
                                                    data-field="nama-jenis"><?= $jenis['nama_jenis'] ?></td>
                                                <td
                                                    style="
																width: 300px;
															">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-outline-warning btn-sm edit"
                                                        title="Edit"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        data-id="<?= $jenis['id_jenis_inovasi'] ?>"
                                                        data-nama="<?= $jenis['nama_jenis'] ?>">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a href="/jenis_inovasi/delete/<?= $jenis['id_jenis_inovasi'] ?>"
                                                        class="btn btn-outline-danger btn-sm delete ms-2"
                                                        title="Delete">
                                                        <i
                                                            class="fas fa-trash-alt" id="sa-warning"></i>
                                                    </a>
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
                    Tambah Jenis Inovasi
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="/jenis_inovasi/store" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label
                            for="nama_jenis"
                            class="col-form-label">Nama
                            Jenis</label>
                        <input
                            type="text"
                            class="form-control"
                            name="nama_jenis"
                            id="nama_jenis"
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
                    Edit Jenis Inovasi
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="/jenis_inovasi/update/<?= $jenis['id_jenis_inovasi'] ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_jenis" class="col-form-label">Nama Jenis</label>
                        <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" value="<?= $jenis['nama_jenis'] ?>" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning" data-bs-dismiss="modal">Perbarui</button>
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
                const namaJenis = button.getAttribute('data-nama');

                // Isi input modal dengan data yang sesuai
                document.getElementById('nama_jenis').value = namaJenis;

                // Update form action untuk mengirim ID yang sesuai
                const form = document.querySelector('#editModal form');
                form.action = `/jenis_inovasi/update/${id}`;
            });
        });

        // Bersihkan nilai modal saat ditutup
        document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('nama_jenis').value = '';
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