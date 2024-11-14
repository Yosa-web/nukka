<?= $this->extend('layout/master_dashboard'); ?>

<?= $this->section('content'); ?>
<?= $this->section('title') ?><title>Tambah OPD | Rumah Inovasi</title><?= $this->endSection() ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">
                            Tambah OPD
                        </h3>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Pengguna</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/superadmin/opd">Data OPD</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Tambah OPD
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
                        <form action="<?= base_url('superadmin/opd/store') ?>" method="post" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <label for="nama_opd" class="col-sm-3 col-form-label">Nama OPD</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control <?= session('errors.nama_opd') ? 'is-invalid' : '' ?>" id="nama_opd" name="nama_opd" value="<?= old('nama_opd') ?>" placeholder="Masukkan Nama OPD">
                                    <?php if (session('errors.nama_opd')) : ?>
                                        <div class="invalid-feedback"><?= session('errors.nama_opd') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control <?= session('errors.alamat') ? 'is-invalid' : '' ?>" id="alamat" name="alamat" rows="4" placeholder="Masukkan Alamat OPD"><?= old('alamat') ?></textarea>
                                    <?php if (session('errors.alamat')) : ?>
                                        <div class="invalid-feedback"><?= session('errors.alamat') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="telepon" class="col-sm-3 col-form-label">No. Telepon</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control <?= session('errors.telepon') ? 'is-invalid' : '' ?>" id="telepon" name="telepon" value="<?= old('telepon') ?>" placeholder="Masukkan Nomor Telepon OPD">
                                    <?php if (session('errors.telepon')) : ?>
                                        <div class="invalid-feedback"><?= session('errors.telepon') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>" placeholder="Masukkan Email OPD">
                                    <?php if (session('errors.email')) : ?>
                                        <div class="invalid-feedback"><?= session('errors.email') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='/superadmin/opd'">Batal</button>
                                        <button type="submit" class="btn btn-primary w-md ms-4">Kirim</button>
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

<script>
    $(document).ready(function() {
        // Nama OPD Validation
        $('#nama_opd').on('keyup change', function() {
            var namaOpd = $(this).val();
            if (namaOpd.length < 1 || namaOpd.length > 100) {
                $('#nama_opd_error').text('Nama OPD harus memiliki 3 hingga 100 karakter.');
                $(this).addClass('is-invalid');
            } else {
                $('#nama_opd_error').text('');
                $(this).removeClass('is-invalid');
            }
        });

        // Alamat Validation
        $('#alamat').on('keyup change', function() {
            var alamat = $(this).val();
            if (alamat.length < 1 || alamat.length > 255) {
                $('#alamat_error').text('Alamat harus memiliki 10 hingga 255 karakter.');
                $(this).addClass('is-invalid');
            } else {
                $('#alamat_error').text('');
                $(this).removeClass('is-invalid');
            }
        });

        // Telepon Validation
        $('#telepon').on('keyup change', function() {
            var telepon = $(this).val();
            if (telepon.length < 11 || telepon.length > 13 || !$.isNumeric(telepon)) {
                $('#telepon_error').text('Nomor telepon harus berupa angka dan memiliki 10 hingga 15 digit.');
                $(this).addClass('is-invalid');
            } else {
                $('#telepon_error').text('');
                $(this).removeClass('is-invalid');
            }
        });

        // Email Validation
        $('#email').on('keyup change', function() {
            var email = $(this).val();
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email) || email.length > 100) {
                $('#email_error').text('Masukkan format email yang valid dan tidak lebih dari 100 karakter.');
                $(this).addClass('is-invalid');
            } else {
                $('#email_error').text('');
                $(this).removeClass('is-invalid');
            }
        });

        // Prevent form submission if there are errors
        $('#myForm').on('submit', function(e) {
            if ($('.is-invalid').length > 0) {
                e.preventDefault(); // Prevent form from submitting
                alert('Periksa kembali form yang diisi.');
            }
        });
    });
</script>
<?= $this->endSection(); ?>