<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Desa | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">Desa</h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Desa</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Desa
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php if ($errors = session()->getFlashdata('errors')): ?>
    <?php if (is_array($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <?= esc($errors) ?>
    <?php endif; ?>
<?php elseif ($success = session()->getFlashdata('success')): ?>
    <?= esc($success) ?>
<?php endif; ?>

            <!-- start table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div
                            class="card-header d-flex justify-content-end">
                            <a href="/superadmin/desa/create" class="btn btn-primary waves-effect btn-label waves-light"
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
                                            <th>Nama Desa</th>
                                            <th>Letak Kecamatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($desa)): ?>
                                            <?php foreach ($desa as $jenis): ?>
                                                <tr>
                                                <td data-field="id" style="width: 80px"><?= esc($jenis['id_desa']) ?></td>
                                                <td data-field="nama-desa"><?= esc($jenis['nama_desa']) ?></td>
                                                <td data-field="nama-kecamatan"><?= esc($jenis['nama_kecamatan']) ?></td> <!-- Menampilkan nama kecamatan -->
                                                <td style="width: 300px;">
                                                    <a href="javascript:void(0)" class="btn btn-outline-warning btn-sm edit" title="Edit"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        data-id="<?= esc($jenis['id_desa']) ?>"
                                                        data-nama="<?= esc($jenis['nama_desa']) ?>"
                                                        data-kecamatan="<?= esc($jenis['id_kecamatan']) ?>"> 
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a href="/superadmin/desa/delete/<?= esc($jenis['id_desa']) ?>" class="btn btn-outline-danger btn-sm delete ms-2" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <em>Tidak ada data desa untuk ditampilkan.</em>
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
                    Tambah Desa
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="/superadmin/desa/store" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label
                            for="nama_desa"
                            class="col-form-label">Nama
                            Desa</label>
                        <input
                            type="text"
                            class="form-control"
                            name="nama_desa"
                            id="nama_desa"
                            required />
                    </div>
                    <div class="mb-3">
                    <label for="id_kecamatan" class="col-form-label">Lokasi Kecamatan</label>
                    <select class="form-control" name="id_kecamatan" id="id_kecamatan" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        <?php if (isset($kecamatan)): ?>
                            <?php foreach ($kecamatan as $row): ?>
                                <option value="<?= esc($row['id_kecamatan']) ?>"><?= esc($row['nama_kecamatan']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
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
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Desa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="editForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_desa" class="col-form-label">Nama Desa</label>
                        <input type="text" class="form-control" id="edit_nama_desa" name="nama_desa" required />
                    </div>
                    <div class="mb-3">
                    <label for="edit_kecamatan" class="col-form-label">Lokasi Kecamatan</label>
                    <select class="form-control" id="edit_kecamatan" name="id_kecamatan" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        <?php foreach ($kecamatan as $row): ?>
                            <option value="<?= esc($row['id_kecamatan']) ?>"><?= esc($row['nama_kecamatan']) ?></option>
                        <?php endforeach; ?>
                    </select>
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
            const namaDesa = button.getAttribute('data-nama');
            const idKecamatan = button.getAttribute('data-kecamatan');

            // Isi input modal dengan data yang sesuai
            document.getElementById('edit_nama_desa').value = namaDesa;
            document.getElementById('edit_kecamatan').value = idKecamatan;

            // Update form action untuk mengirim ID yang sesuai
            const form = document.querySelector('#editForm');
            form.action = `/superadmin/desa/update/${id}`;
        });
    });
});



    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = button.getAttribute('data-id');
                const namaKecamatan = button.getAttribute('data-nama');

                // Isi input modal dengan data yang sesuai
                document.getElementById('edit_nama_kecamatan').value = namaKecamatan;

                // Update form action untuk mengirim ID yang sesuai
                const form = document.getElementById('editForm');
                form.action = `/superadmin/kecamatan/update/${id}`;
            });
        });

        // Bersihkan modal ketika ditutup
        document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('edit_nama_kecamatan').value = '';
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