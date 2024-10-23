<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Option Web</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4">Option Web</h1>

        <!-- Looping opsi -->
        <?php if (!empty($options) && is_array($options)): ?>
            <?php foreach ($options as $option): ?>
                <div class="option-item mb-4">
                    <!-- Tampilkan Tipe Opsi -->
                    <h2><?= esc($option['key']) ?></h2>

                    <!-- Jika tipe adalah image, tampilkan gambar -->
                    <?php if ($option['seting_type'] === 'image'): ?>
                        <img src="<?= base_url($option['value']) ?>" alt="Option Image" class="img-fluid">
                    <?php endif; ?>

                    <!-- Jika tipe adalah text, tampilkan teks -->
                    <?php if ($option['seting_type'] === 'text'): ?>
                        <p><?= esc($option['value']) ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada opsi yang tersedia.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>