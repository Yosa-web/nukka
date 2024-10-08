<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Galeri</title>
</head>

<body>
    <h1>Daftar Galeri</h1>
    <a href="/superadmin/galeri/create">Tambah Galeri</a>
    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>URL</th>
                <th>Tipe</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($galeris as $galeri): ?>
                <tr>
                    <td><?= $galeri['judul']; ?></td>
                    <td><?= $galeri['url']; ?></td>
                    <td><?= $galeri['tipe']; ?></td>
                    <td>
                        <a href="/superadmin/galeri/<?= $galeri['id_galeri']; ?>/edit">Edit</a>
                        <form action="/superadmin/galeri/<?= $galeri['id_galeri']; ?>" method="post" style="display:inline;">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>