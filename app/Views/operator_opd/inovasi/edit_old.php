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

        <form action="/operator/inovasi/update/<?= esc($inovasi['id_inovasi']) ?>" method="post" enctype="multipart/form-data">
            <label for="judul">Judul:</label>
            <input type="text" name="judul" value="<?= esc($inovasi['judul']) ?>" required>

            <label for="deskripsi">Deskripsi:</label>
            <textarea name="deskripsi" required><?= esc($inovasi['deskripsi']) ?></textarea>

            <label for="kategori">Kategori:</label>
            <select name="kategori" required>
                <?php foreach ($jenis_inovasi as $jenis): ?>
                    <option value="<?= esc($jenis['id_jenis_inovasi']) ?>" <?= $inovasi['kategori'] == $jenis['id_jenis_inovasi'] ? 'selected' : '' ?>>
                        <?= esc($jenis['nama_jenis']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_opd">Pilih OPD:</label>
            <select name="id_opd" required>
                <?php foreach ($opd as $row): ?>
                    <option value="<?= esc($row->id_opd) ?>" <?= $inovasi['id_opd'] == $row->id_opd ? 'selected' : '' ?>>
                        <?= esc($row->nama_opd) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="kecamatan">Kecamatan:</label>
            <select name="kecamatan" required>
                <?php
                $kecamatan_options = [
                    "Gedong Tataan",
                    "Kedondong",
                    "Marga Punduh",
                    "Negeri Katon",
                    "Padang Cermin",
                    "Punduh Pidada",
                    "Tegineneng",
                    "Teluk Pandan",
                    "Way Lima",
                    "Way Khilau",
                    "Way Ratai"
                ];
                foreach ($kecamatan_options as $kecamatan): ?>
                    <option value="<?= $kecamatan ?>" <?= isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == $kecamatan ? 'selected' : '' ?>>
                        <?= $kecamatan ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="url_file">Ganti File:</label>
            <input type="file" name="url_file">
            <?php if (!empty($inovasi['url_file'])): ?>
                <p>File Saat Ini: <a href="<?= base_url($inovasi['url_file']) ?>" target="_blank">Lihat File</a></p>
            <?php endif; ?>

            <button type="submit">Update</button>
        </form>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
    </div>
</body>

</html>