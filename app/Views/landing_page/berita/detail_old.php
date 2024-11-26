<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($berita['judul']) ?> - Detail Berita</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .berita-gambar {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .berita-container {
            margin-top: 40px;
        }

        .berita-tanggal {
            font-size: 0.9em;
            color: #6c757d;
        }

        .berita-author {
            font-size: 1.1em;
            color: #007bff;
            margin-bottom: 10px;
        }

        .berita-content {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container berita-container">
        <h1 class="mb-4"><?= esc($berita['judul']) ?></h1>

        <!-- Gambar Berita -->
        <?php if ($berita['gambar']): ?>
            <img src="<?= base_url($berita['gambar']) ?>" alt="Gambar Berita" class="berita-gambar">
        <?php endif; ?>

        <!-- Tanggal Post -->
        <p class="berita-tanggal">
            Diposting pada: <?= date('d M Y, H:i', strtotime($berita['tanggal_post'])) ?>
        </p>

        <!-- Penulis/Posted by -->
        <p class="berita-author">
            Diposting oleh: <?= esc($berita['uploaded_by_username']) ?>
        </p>

        <!-- Isi Berita -->
        <div class="berita-content">
            <p><?= nl2br(esc($berita['isi'])) ?></p>
        </div>

        <!-- Tombol Kembali -->
        <a href="javascript:history.back()" class="btn btn-secondary mt-4">Kembali</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>