<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Proposal</title>
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
        select,
        input[type="file"] {
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Tambah Proposal Inovasi</h1>
        <?php if (session()->get('errors')): ?>
            <div style="color: red;">
                <?= implode('<br>', session()->get('errors')) ?>
            </div>
        <?php endif; ?>
        <form action="/sekertaris/inovasi/store" method="post" enctype="multipart/form-data">
            <label for="judul">Judul:</label>
            <input type="text" name="judul" required>

            <label for="deskripsi">Deskripsi:</label>
            <textarea name="deskripsi" required></textarea>

            <label for="kategori">Kategori:</label>
            <select name="kategori" required>
                <option value="">Kategori</option>
                <?php foreach ($jenis_inovasi as $jenis): ?>
                    <option value="<?= $jenis['id_jenis_inovasi'] ?>"><?= $jenis['nama_jenis'] ?></option>
                <?php endforeach; ?>

            </select>

            <label for="id_opd">Pilih OPD:</label>
            <select name="id_opd" required>
                <option value="">Pilih OPD</option>
                <?php foreach ($opd as $row): ?>
                    <option value="<?= $row->id_opd ?>"><?= $row->nama_opd ?></option>
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

            <label for="url_file">Upload File:</label>
            <input type="file" name="url_file">

            <button type="submit">Submit</button>
        </form>
    </div>
    <!-- Alert untuk notifikasi sukses atau error -->
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