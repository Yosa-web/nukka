<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proposal Inovasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Proposal Inovasi</h1>

        <?php if (session()->get('errors')): ?>
            <div class="error">
                <?= implode('<br>', session()->get('errors')) ?>
            </div>
        <?php endif; ?>

        <form action="/sekertaris/inovasi/update/<?= $inovasi['id_inovasi'] ?>" method="post" enctype="multipart/form-data">
            <label for="judul">Judul:</label>
            <input type="text" name="judul" value="<?= esc($inovasi['judul']); ?>" required>

            <label for="deskripsi">Deskripsi:</label>
            <textarea name="deskripsi" required><?= esc($inovasi['deskripsi']); ?></textarea>

            <label for="kategori">Kategori:</label>
            <select name="kategori" required>
                <?php foreach ($jenis_inovasi as $jenis): ?>
                    <option value="<?= $jenis['id_jenis_inovasi'] ?>" <?= $inovasi['kategori'] == $jenis['id_jenis_inovasi'] ? 'selected' : '' ?>>
                        <?= $jenis['nama_jenis'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="draf" <?= $inovasi['status'] == 'draf' ? 'selected' : '' ?>>Draf</option>
                <option value="terbit" <?= $inovasi['status'] == 'terbit' ? 'selected' : '' ?>>Terbit</option>
                <option value="arsip" <?= $inovasi['status'] == 'arsip' ? 'selected' : '' ?>>Arsip</option>
                <option value="tertunda" <?= $inovasi['status'] == 'tertunda' ? 'selected' : '' ?>>Tertunda</option>
                <option value="tertolak" <?= $inovasi['status'] == 'tertolak' ? 'selected' : '' ?>>Tertolak</option>
                <option value="revisi" <?= $inovasi['status'] == 'revisi' ? 'selected' : '' ?>>Revisi</option>
            </select>

            <div id="pesan-container" style="display: none;">
                <label for="pesan">Pesan:</label>
                <textarea name="pesan" id="pesan"></textarea>
            </div>

            <label for="id_opd">Pilih OPD:</label>
            <select name="id_opd" required>
                <?php foreach ($opd as $row): ?>
                    <option value="<?= $row->id_opd ?>" <?= $inovasi['id_opd'] == $row->id_opd ? 'selected' : '' ?>>
                        <?= $row->nama_opd ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="kecamatan">kecamatan:</label>
            <select name="kecamatan" id="kecamatan" required>
                <option value="Gedong Tataan" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'Gedong Tataan') ? 'selected' : '' ?>>Gedong Tataan</option>
                <option value="'Kedondong" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'Kedondong') ? 'selected' : '' ?>>Kedondong</option>
                <option value="Marga Punduh" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'Marga Punduh') ? 'selected' : '' ?>>Marga Punduh</option>
                <option value="Negeri Katon" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'Negeri Katon') ? 'selected' : '' ?>>Negeri Katon</option>
                <option value="Padang Cermin" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'Padang Cermin') ? 'selected' : '' ?>>Padang Cermin</option>
                <option value="Punduh Pidada" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'Punduh Pidada') ? 'selected' : '' ?>>Punduh Pidada</option>
                <option value="Tegineneng" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'Tegineneng') ? 'selected' : '' ?>>Tegineneng</option>
                <option value="Teluk Pandan" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'Teluk Pandan') ? 'selected' : '' ?>>Teluk Pandan</option>
                <option value="Way Lima" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'Way Lima') ? 'selected' : '' ?>>Way Lima</option>
                <option value="Way Khilau" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'Way Khilau') ? 'selected' : '' ?>>Way Khilau</option>
                <option value="Way Ratai" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'Way Ratai') ? 'selected' : '' ?>>Way Ratai</option>
            </select>

            <label for="url_file">Ganti File:</label>
            <input type="file" name="url_file">

            <?php if (!empty($inovasi['url_file'])): ?>
                <p>File Saat Ini: <a href="<?= base_url($inovasi['url_file']) ?>" target="_blank">Lihat File</a></p>
            <?php endif; ?>

            <button type="submit">Update</button>
        </form>

        <script>
            const statusSelect = document.getElementById('status');
            const pesanContainer = document.getElementById('pesan-container');

            statusSelect.addEventListener('change', function() {
                const selectedStatus = statusSelect.value;
                if (['tertolak', 'revisi', 'arsip'].includes(selectedStatus)) {
                    pesanContainer.style.display = 'block';
                } else {
                    pesanContainer.style.display = 'none';
                    document.getElementById('pesan').value = ''; // Reset pesan jika tidak dibutuhkan
                }
            });

            // Trigger perubahan saat halaman dimuat (jika status sudah terpilih)
            window.addEventListener('DOMContentLoaded', function() {
                statusSelect.dispatchEvent(new Event('change'));
            });
        </script>

    </div>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</body>

</html>