<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit OPD</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error {
            color: #dc3545; /* Warna merah untuk pesan error */
            font-size: 0.9em;
            margin-top: 5px;
        }
        .form-control.is-invalid {
            border-color: #dc3545; /* Gaya border merah saat ada kesalahan */
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Edit OPD</h2>
    <form action="<?= base_url('/superadmin/opd/update/' . $opd['id_opd']) ?>" method="post">
    <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <!-- Nama OPD -->
        <div class="form-group">
            <label for="nama_opd" class="form-label">Nama OPD</label>
            <input type="text" id="nama_opd" name="nama_opd" class="form-control" placeholder="Masukkan Nama OPD" value="<?= old('nama_opd', $opd['nama_opd']) ?>">
            <div id="nama_opd_error" class="error"></div>
        </div>

        <!-- Alamat -->
        <div class="form-group">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Masukkan Alamat" value="<?= old('alamat', $opd['alamat']) ?>">
            <div id="alamat_error" class="error"></div>
        </div>

        <!-- Telepon -->
        <div class="form-group">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" id="telepon" name="telepon" class="form-control" placeholder="Masukkan Nomor Telepon" value="<?= old('telepon', $opd['telepon']) ?>">
            <div id="telepon_error" class="error"></div>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="text" id="email" name="email" class="form-control" placeholder="Masukkan Email" value="<?= old('email', $opd['email']) ?>">
            <div id="email_error" class="error"></div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<!-- jQuery dan Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Nama OPD Validation
        $('#nama_opd').on('keyup change', function() {
            var namaOpd = $(this).val();
            if (namaOpd.length < 3 || namaOpd.length > 100) {
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
            if (alamat.length < 10 || alamat.length > 255) {
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
            if (telepon.length < 10 || telepon.length > 15 || !$.isNumeric(telepon)) {
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

</body>
</html>
