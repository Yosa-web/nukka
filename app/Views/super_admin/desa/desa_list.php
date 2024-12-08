<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Kecamatan <?= esc($kecamatan['nama_kecamatan']) ?> | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">Kecamatan <?= esc($kecamatan['nama_kecamatan']) ?></h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="/superadmin/kecamatan">Kecamatan</a>
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
            <?php if (session()->getFlashdata('errors') || session()->getFlashdata('success')): ?>
                <div class="alert alert-dismissible fade show <?= session()->getFlashdata('errors') ? 'alert-danger' : 'alert-success' ?>">
                    <?php
                    if (session()->getFlashdata('errors')) {
                        // Jika 'errors' berupa array, tampilkan setiap pesan di baris baru
                        if (is_array(session()->getFlashdata('errors'))) {
                            foreach (session()->getFlashdata('errors') as $error) {
                                echo esc($error) . '<br>';
                            }
                        } else {
                            // Jika 'errors' bukan array, cetak langsung
                            echo esc(session()->getFlashdata('errors'));
                        }
                    } else {
                        // Cetak pesan sukses
                        echo esc(session()->getFlashdata('success'));
                    }
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>


            <!-- start table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div
                            class="card-header d-flex justify-content-start">
                            <form action="/superadmin/desa" method="post"
                                class="row gx-3 gy-2 align-items-center">
                                <?= csrf_field() ?>
                                <div class="hstack gap-3">
                                    <input type="hidden" name="id_kecamatan" value="<?= esc($kecamatan['id_kecamatan']) ?>">
                                    <input
                                        class="form-control me-auto"
                                        type="text"
                                        placeholder="tambah desa baru..." name="nama_desa" id="nama_desa" required />
                                    <button
                                        type="submit"
                                        class="btn btn-primary" style="white-space: nowrap;">
                                        Tambah Desa
                                    </button>
                                </div>
                            </form>
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
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($desa) > 0): ?>
                                            <?php foreach ($desa as $item): ?>
                                                <tr>
                                                    <td data-field="id" style="width: 80px"><?= esc($item['id_desa']) ?></td>
                                                    <td data-field="nama-desa"><?= esc($item['nama_desa']) ?></td>
                                                    <td style="width: 300px;">
                                                        <a href="javascript:void(0)" class="btn btn-outline-warning btn-sm edit" title="Edit"
                                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                                            data-id="<?= esc($item['id_desa']) ?>"
                                                            data-nama="<?= esc($item['nama_desa']) ?>"
                                                            data-kecamatan="<?= esc($item['id_kecamatan']) ?>">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="/superadmin/desa/delete/<?= esc($item['id_desa']) ?>" class="btn btn-outline-danger btn-sm delete ms-2" title="Delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <em>Tidak ada desa di kecamatan ini.</em>
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

<!-- Modal Edit Desa -->
<?php if (count($desa) > 0): ?>
    <?php foreach ($desa as $item): ?>
        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Desa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/superadmin/desa/update/<?= esc($item['id_desa']) ?>" method="post">
                        <div class="modal-body">
                            <!-- Hidden input untuk id_kecamatan -->
                            <input type="hidden" name="id_kecamatan" value="<?= esc($item['id_kecamatan']) ?>">

                            <div class="mb-3">
                                <label for="edit_nama_desa" class="col-form-label">Nama Desa</label>
                                <input type="text" class="form-control" id="edit_nama_desa" name="nama_desa" value="<?= esc($item['nama_desa']) ?>" required />
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
    <?php endforeach; ?>
<?php endif; ?>

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
<!-- Sweet Alerts js -->
<script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<!-- Sweet alert hapus -->
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
<script>
    $(document).ready(function() {
        $('#kecamatan').change(function() {
            var id_kecamatan = $(this).val();
            if (id_kecamatan) {
                $.ajax({
                    url: '/superadmin/inovasi/getDesa', // Sesuaikan dengan endpoint yang benar
                    type: 'GET',
                    data: {
                        id_kecamatan: id_kecamatan
                    },
                    success: function(response) {
                        console.log(response); // Cek respons dari server
                        var desaOptions = '<option value="" disabled selected>Pilih Desa</option>';
                        if (response.length > 0) {
                            $.each(response, function(index, desa) {
                                desaOptions += '<option value="' + desa.id_desa + '">' + desa.nama_desa + '</option>';
                            });
                        } else {
                            desaOptions += '<option value="" disabled>Tidak ada desa</option>';
                        }
                        $('#desa').html(desaOptions); // Update dropdown Desa
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat memuat data desa');
                    }
                });
            } else {
                $('#desa').html('<option value="" disabled selected>Pilih Desa</option>');
            }
        });
    });
</script>
<?= $this->endSection(); ?>