<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Galeri</title>
</head>

<body>
    <h1>Edit Galeri</h1>
    <form action="/superadmin/galeri/update/<?= $galeri['id_galeri']; ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <label for="judul">Judul:</label>
        <input type="text" name="judul" id="judul" value="<?= $galeri['judul']; ?>" required>

        <label for="id_user">ID User:</label>
        <input type="text" name="id_user" id="id_user" value="<?= $galeri['id_user']; ?>" required>

        <label for="url">URL:</label>
        <input type="text" name="url" id="url" value="<?= $galeri['url']; ?>" required>

        <label for="tipe">Tipe:</label>
        <select name="tipe" id="tipe" required>
            <option value="image" <?= ($galeri['tipe'] == 'image') ? 'selected' : ''; ?>>Gambar</option>
            <option value="video" <?= ($galeri['tipe'] == 'video') ? 'selected' : ''; ?>>Video</option>
        </select>

        <button type="submit">Update</button>
    </form>
</body>

</html>