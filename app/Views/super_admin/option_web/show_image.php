<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menampilkan Gambar</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        img {
            max-width: 100%;
            max-height: 80vh;
            /* Atur tinggi maksimum gambar */
            object-fit: contain;
        }
    </style>
</head>

<body>

    // show_image.php
    <?php if (isset($image_url)): ?>
        <img src="<?= esc($option['value']) ?>" alt="Gambar Opsi" class="img-fluid mb-3">
    <?php else: ?>
        <p>Gambar tidak ditemukan.</p>
    <?php endif; ?>

</body>

</html> -->