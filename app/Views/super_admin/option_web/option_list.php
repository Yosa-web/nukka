<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Opsi Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4">Daftar Opsi Web</h1>

        <!-- Looping untuk menampilkan daftar opsi -->
<?php if (!empty($option) && is_array($option)): ?>
    <?php foreach ($option as $option): ?>
        <div class="mb-3 p-3 border rounded">
            <!-- Nama Opsi -->
            <h3><?= esc($option['value']) ?></h3>

            <!-- Nilai Opsi -->
            <p><strong>Nilai:</strong> <?= esc($option['value']) ?></p>

            <!-- Tombol Detail -->
            <a href="<?= base_url('superadmin/optionweb/detail/' . $option['id']) ?>" class="btn btn-primary">Detail</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Belum ada opsi web yang tersedia.</p>
<?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html> -->