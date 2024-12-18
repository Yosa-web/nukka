<!DOCTYPE html>
<html>

<head>
    <title><?= esc($title) ?> | <?= esc($namaWebsite) ?></title>
</head>

<body>
    <h1>Selamat Datang di <?= esc($namaWebsite) ?></h1>

    <p>Berikut adalah daftar jenis inovasi:</p>
    <ul>
        <?php foreach ($jenis_inovasi as $jenis): ?>
            <li><?= esc($jenis['nama_jenis']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>

</html>