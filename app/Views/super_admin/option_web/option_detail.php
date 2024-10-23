<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($option['key']) ?> - Detail Opsi Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Detail Opsi: <?= esc($option['value']) ?></h1>

        <!-- Debugging: tampilkan isi dari $option -->
<pre><?= print_r($option, true) ?></pre> <!-- Hapus atau komen ini setelah debugging -->

<!-- Jika tipe setting adalah 'image' dan key adalah 'logo', tampilkan gambar -->
<?php if ($option['seting_type'] === 'image' && $option['key'] === 'logo'): ?>
    <p><strong>Gambar Opsi:</strong></p>
    <img src="<?= esc($option['value']) ?>" alt="Gambar Opsi" class="img-fluid mb-3">
<?php else: ?>
    <!-- Jika bukan tipe image, tampilkan nilai sebagai teks -->
    <p><strong>Nilai:</strong> <?= esc($option['value']) ?></p>
<?php endif; ?>

<!-- Tombol Kembali -->
<a href="<?= base_url('superadmin/optionweb') ?>" class="btn btn-secondary mt-4">Kembali</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html> -->