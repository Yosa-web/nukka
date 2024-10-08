<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Galeri</title>
</head>

<body>
    <h1>Tambah Galeri</h1>
    <form action="/superadmin/galeri/store" method="post">
        <?= csrf_field() ?>
        <label for="judul">Judul:</label>
        <input type="text" name="judul" id="judul" required>

        <label for="id_user">ID User:</label>
        <input type="text" name="id_user" id="id_user" required>

        <label for="url">URL:</label>
        <input type="text" name="url" id="url" required>

        <label for="tipe">Tipe:</label>
        <select name="tipe" id="tipe" required>
            <option value="image">Gambar</option>
            <option value="video">Video</option>
        </select>

        <button type="submit">Simpan</button>
    </form>
</body>

</html>