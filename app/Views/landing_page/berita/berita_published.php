<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Terbaru</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .berita-item {
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .berita-gambar {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
        }
        .berita-tanggal {
            font-size: 0.9em;
            color: #6c757d;
        }
        .berita-author {
            font-size: 1em;
            color: #007bff;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Berita Terbaru</h1>

    <!-- Looping berita -->
    <?php if (!empty($beritas) && is_array($beritas)): ?>
        <?php foreach ($beritas as $berita): ?>
            <div class="berita-item">
                <!-- Judul Berita -->
                <h2><?= esc($berita['judul']) ?></h2>

                <!-- Gambar Berita -->
                <?php if ($berita['gambar']): ?>
                    <img src="<?= $berita['gambar'] ?>" alt="Gambar Berita" class="berita-gambar mb-3">
                <?php endif; ?>

                <!-- Tanggal Post -->
                <p class="berita-tanggal">
                    Diposting pada: <?= date('d M Y, H:i', strtotime($berita['tanggal_post'])) ?>
                </p>

                <!-- Penulis/Posted by -->
            <!-- Penulis/Posted by -->
            <p class="berita-author">
                 Diposting oleh: <?= esc($berita['uploaded_by_username']) ?>
            </p>

                <!-- Isi Berita -->
                <p><?= nl2br(esc($berita['isi'])) ?></p>

            <!-- Tombol Show More -->
            <a href="<?= base_url('berita/detail/' . $berita['id_berita']) ?>" class="btn btn-primary">Show More</a>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Belum ada berita yang dipublikasikan.</p>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
