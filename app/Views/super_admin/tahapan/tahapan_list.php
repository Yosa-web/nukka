<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Tahapan | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">Tahapan</h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Inovasi</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Tahapan
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
                            <a href="/superadmin/tahapan/create" class="btn btn-primary waves-effect btn-label waves-light"
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
                                            <th>Nama Tahapan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($tahapan)): ?>
                                            <?php foreach ($tahapan as $tahap): ?>
                                                <tr>
                                                    <td data-field="id" style="width: 80px"><?= $tahap['id_tahapan'] ?></td>
                                                    <td data-field="nama-tahapan"><?= $tahap['nama_tahapan'] ?></td>
                                                    <td style="width: 300px;">
                                                        <a href="javascript:void(0)" class="btn btn-outline-warning btn-sm edit" title="Edit"
                                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                                            data-id="<?= $tahap['id_tahapan'] ?>"
                                                            data-nama="<?= $tahap['nama_tahapan'] ?>">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="/tahapan/delete/<?= $tahap['id_tahapan'] ?>" class="btn btn-outline-danger btn-sm delete ms-2" title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <em>Tidak ada data Tahapan untuk ditampilkan.</em>
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
                    Tambah Tahapan Inovasi
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="/tahapan/store" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label
                            for="nama_tahapan"
                            class="col-form-label">Nama
                            Tahapan</label>
                        <input
                            type="text"
                            class="form-control"
                            name="nama_tahapan"
                            id="nama_tahapan"
                            required />
                        <div class="invalid-feedback" id="nama_tahapan_error"></div>
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
                    Edit Tahapan Inovasi
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
                        <label for="nama_tahapan" class="col-form-label">Nama Tahapan</label>
                        <input type="text" class="form-control" id="edit_nama_tahapan" name="nama_tahapan" value="" required />
                        <div class="invalid-feedback" id="edit_nama_tahapan_error"></div>
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
                const namaTahap = button.getAttribute('data-nama');

                // Isi input modal dengan data yang sesuai
                document.getElementById('nama_tahapan').value = namaTahap;

                // Update form action untuk mengirim ID yang sesuai
                const form = document.querySelector('#editModal form');
                form.action = `/tahapan/update/${id}`;
            });
        });

        // Bersihkan nilai modal saat ditutup
        document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('nama_tahapan').value = '';
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                const namaTahap = button.getAttribute('data-nama');

                // Isi input modal dengan data yang sesuai
                document.getElementById('edit_nama_tahapan').value = namaTahap;

                // Update form action untuk mengirim ID yang sesuai
                const form = document.getElementById('editForm');
                form.action = `/tahapan/update/${id}`;
            });
        });

        // Bersihkan modal ketika ditutup
        document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('edit_nama_tahapan').value = '';
            document.getElementById('editForm').action = '';
        });
    });
</script>
<!-- Modal js -->
<script src="/assets/js/pages/modal.init.js"></script>
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

<!-- validasi input -->
<script>
    const tahapanInput = document.getElementById('nama_tahapan');
    const editTahapanInput = document.getElementById('edit_nama_tahapan');
    const submitButton = document.querySelector('button[type="submit"]'); // Tombol submit

    function validateTahapan() {
        const tahapanErrorDiv = document.getElementById('nama_tahapan_error');
        const editTahapanErrorDiv = document.getElementById('edit_nama_tahapan_error');
        let isValid = true;

        // Validasi nama_jenis tidak diawali dengan spasi/kosong
        if (tahapanInput.value.startsWith(' ')) {
            tahapanErrorDiv.textContent = 'Nama Tahapan tidak boleh diawali dengan spasi dan atau kosong.';
            tahapanInput.classList.add('is-invalid');
            isValid = false;
        } else {
            tahapanErrorDiv.textContent = '';
            tahapanInput.classList.remove('is-invalid');
        }

        // Validasi edit_nama_jenis tidak diawali dengan spasi/kosong
        if (editTahapanInput.value.startsWith(' ')) {
            editTahapanErrorDiv.textContent = 'Nama Tahapan tidak boleh diawali dengan spasi dan atau kosong.';
            editTahapanInput.classList.add('is-invalid');
            isValid = false;
        } else {
            editTahapanErrorDiv.textContent = '';
            editTahapanInput.classList.remove('is-invalid');
        }

        // Nonaktifkan tombol submit jika ada error
        submitButton.disabled = !isValid;
    }
    tahapanInput.addEventListener('input', validateTahapan);
    editTahapanInput.addEventListener('input', validateTahapan);
</script>
<?= $this->endSection(); ?>