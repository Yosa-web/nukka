<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita</title>
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
    <h2 class="mb-4">Edit Berita</h2>
    <!-- Sesuaikan form action untuk update -->
    <form action="<?= base_url('/superadmin/berita/update/' . $berita['id_berita']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        
        <!-- Judul -->
        <div class="form-group">
            <label for="judul" class="form-label">Judul Berita</label>
            <input type="text" id="judul" name="judul" class="form-control <?= isset(session()->getFlashdata('errors')['judul']) ? 'is-invalid' : '' ?>" value="<?= old('judul', $berita['judul']) ?>" placeholder="Masukkan Judul Berita">
            <div id="judul_error" class="error"><?= isset(session()->getFlashdata('errors')['judul']) ? session()->getFlashdata('errors')['judul'] : '' ?></div>
        </div>

        <!-- Isi -->
        <div class="form-group">
            <label for="isi" class="form-label">Isi Berita</label>
            <textarea id="isi" name="isi" class="form-control <?= isset(session()->getFlashdata('errors')['isi']) ? 'is-invalid' : '' ?>" placeholder="Masukkan Isi Berita" rows="5"><?= old('isi', $berita['isi']) ?></textarea>
            <div id="isi_error" class="error"><?= isset(session()->getFlashdata('errors')['isi']) ? session()->getFlashdata('errors')['isi'] : '' ?></div>
        </div>

        <!-- Gambar -->
        <div class="form-group">
            <label for="gambar" class="form-label">Unggah Gambar</label>
            <input type="file" id="gambar" name="gambar" class="form-control <?= isset(session()->getFlashdata('errors')['gambar']) ? 'is-invalid' : '' ?>" accept="image/*">
            <div id="gambar_error" class="error"><?= isset(session()->getFlashdata('errors')['gambar']) ? session()->getFlashdata('errors')['gambar'] : '' ?></div>
            <!-- Jika ada gambar lama, tampilkan gambar yang sudah diunggah -->
            <?php if($berita['gambar']): ?>
                <p>Gambar Saat Ini: <img src="<?= base_url('/uploads/' . $berita['gambar']) ?>" alt="Gambar Berita" width="100"></p>
            <?php endif; ?>
        </div>

        <!-- Tanggal Post -->
        <div class="form-group">
            <label for="tanggal_post" class="form-label">Tanggal Posting</label>
            <input type="datetime-local" id="tanggal_post" name="tanggal_post" class="form-control <?= isset(session()->getFlashdata('errors')['tanggal_post']) ? 'is-invalid' : '' ?>" value="<?= old('tanggal_post', date('Y-m-d\TH:i', strtotime($berita['tanggal_post']))) ?>" required>
            <div id="tanggal_post_error" class="error"><?= isset(session()->getFlashdata('errors')['tanggal_post']) ? session()->getFlashdata('errors')['tanggal_post'] : '' ?></div>
        </div>

        <!-- Status -->
        <div class="form-group">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-control <?= isset(session()->getFlashdata('errors')['status']) ? 'is-invalid' : '' ?>">
                <option value="draft" <?= old('status', $berita['status']) == 'draft' ? 'selected' : '' ?>>Draft</option>
                <option value="published" <?= old('status', $berita['status']) == 'published' ? 'selected' : '' ?>>Published</option>
                <option value="archive" <?= old('status', $berita['status']) == 'archive' ? 'selected' : '' ?>>Archive</option>
            </select>
            <div id="status_error" class="error"><?= isset(session()->getFlashdata('errors')['status']) ? session()->getFlashdata('errors')['status'] : '' ?></div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<!-- jQuery dan Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Judul Validation
        $('#judul').on('keyup change', function() {
            var judul = $(this).val();
            if (judul.length < 3 || judul.length > 100) {
                $('#judul_error').text('Judul berita harus memiliki 3 hingga 100 karakter.');
                $(this).addClass('is-invalid');
            } else {
                $('#judul_error').text('');
                $(this).removeClass('is-invalid');
            }
        });

        // Isi Validation
        $('#isi').on('keyup change', function() {
            var isi = $(this).val();
            if (isi.length < 10 || isi.length > 2000) {
                $('#isi_error').text('Isi berita harus memiliki 10 hingga 2000 karakter.');
                $(this).addClass('is-invalid');
            } else {
                $('#isi_error').text('');
                $(this).removeClass('is-invalid');
            }
        });

        // Gambar Validation
        $('#gambar').on('change', function() {
            var gambar = $(this).val().split('.').pop().toLowerCase();
            if (gambar !== 'jpg' && gambar !== 'jpeg' && gambar !== 'png') {
                $('#gambar_error').text('Hanya file gambar dengan format JPG, JPEG, atau PNG yang diizinkan.');
                $(this).addClass('is-invalid');
            } else {
                $('#gambar_error').text('');
                $(this).removeClass('is-invalid');
            }
        });

        // Prevent form submission if there are errors
        $('form').on('submit', function(e) {
            if ($('.is-invalid').length > 0) {
                e.preventDefault(); // Prevent form from submitting
                alert('Periksa kembali form yang diisi.');
            }
        });
    });
</script>

</body>
</html>
