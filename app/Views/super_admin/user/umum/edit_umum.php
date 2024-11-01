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
                            Edit Pengguna Umum
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Data Pengguna</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="data-pengguna-umum.html">Umum</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit Pengguna Umum
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
                        <div class="card-body">
                            <form action="data-pengguna-umum.html">
                                <div class="row mb-3">
                                    <label for="nama-umum-input" class="col-sm-3 col-form-label">Nama Pengguna</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama-umum-input" placeholder="Masukkan nama pengguna" value="Abdi Firdaus">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="nik-input" class="col-sm-3 col-form-label">NIK</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nik-input" placeholder="Masukkan NIK pengguna" value="1871xxxxxxxxxxxx">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="telp-umum-input" class="col-sm-3 col-form-label">No. Telepon</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="telp-umum-input" placeholder="Masukkan no. telp" value="0812xxxxxxxx">
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <label for="email-umum-input" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email-umum-input" placeholder="Masukkan email pengguna" value="abdi@gmail.com">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='data-pengguna-umum.html'">Batal</button>
                                            <button type="submit" class="btn btn-warning w-md ms-4">Perbarui</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>