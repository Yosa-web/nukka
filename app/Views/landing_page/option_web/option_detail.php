<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($option['value']) ?> - Detail Opsi Web</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .option-gambar {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .option-container {
            margin-top: 40px;
        }

        .option-tipe {
            font-size: 0.9em;
            color: #6c757d;
        }

        .option-content {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container option-container">
        <h1 class="mb-4"><?= esc($option['key']) ?></h1>

        <!-- Jika tipe adalah image, tampilkan gambar -->
        <?php if ($option['seting_type'] === 'image'): ?>
            <img src="<?= base_url($option['value']) ?>" alt="Gambar Opsi Web" class="option-gambar">
        <?php endif; ?>

        <!-- Jika tipe adalah text, tampilkan teks -->
        <?php if ($option['seting_type'] === 'text'): ?>
            <div class="option-content">
                <p><?= nl2br(esc($option['value'])) ?></p>
            </div>
        <?php endif; ?>

        <!-- Tombol Kembali -->
        <a href="<?= base_url('option_web') ?>" class="btn btn-secondary mt-4">Kembali</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>