<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data to CSV</title>
</head>
<body>
    <h1>Export Data to CSV</h1>
    <form action="<?= site_url('export/csv') ?>" method="get">
        <label for="kategori">Kategori:</label>
        <select name="kategori" id="kategori">
            <option value="">-- Pilih Kategori --</option>
            <?php foreach ($kategoriOptions as $kategori): ?>
                <option value="<?= $kategori['id_jenis_inovasi'] ?>"><?= $kategori['nama_jenis'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="bentuk">Bentuk:</label>
        <select name="bentuk" id="bentuk">
            <option value="">-- Pilih Bentuk --</option>
            <?php foreach ($bentukOptions as $bentuk): ?>
                <option value="<?= $bentuk['id_bentuk'] ?>"><?= $bentuk['nama_bentuk'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="tahapan">Tahapan:</label>
        <select name="tahapan" id="tahapan">
            <option value="">-- Pilih Tahapan --</option>
            <?php foreach ($tahapanOptions as $tahapan): ?>
                <option value="<?= $tahapan['id_tahapan'] ?>"><?= $tahapan['nama_tahapan'] ?></option>
            <?php endforeach; ?>
        </select>

        <select class="form-select" name="status" required>
    <option value="" <?= !isset($_GET['status']) || $_GET['status'] == '' ? 'selected' : '' ?>>Semua</option>
    <option value="tertunda" <?= isset($_GET['status']) && $_GET['status'] == 'tertunda' ? 'selected' : '' ?>>Tertunda</option>
    <option value="draf" <?= isset($_GET['status']) && $_GET['status'] == 'draf' ? 'selected' : '' ?>>Draf</option>
    <option value="terbit" <?= isset($_GET['status']) && $_GET['status'] == 'terbit' ? 'selected' : '' ?>>Terbit</option>
    <option value="arsip" <?= isset($_GET['status']) && $_GET['status'] == 'arsip' ? 'selected' : '' ?>>Arsip</option>
    <option value="tertolak" <?= isset($_GET['status']) && $_GET['status'] == 'tertolak' ? 'selected' : '' ?>>Tertolak</option>
    <option value="revisi" <?= isset($_GET['status']) && $_GET['status'] == 'revisi' ? 'selected' : '' ?>>Revisi</option>
</select>

        <label for="tahun">Tahun:</label>
        <input type="number" name="tahun" id="tahun" placeholder="Masukkan Tahun">

        <button type="submit">Export</button>
    </form>
</body>
</html>
