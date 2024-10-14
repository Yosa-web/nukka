<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Galeri</title>
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

        a {
            text-decoration: none;
            color: white;
            background-color: #28a745;
            padding: 10px;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
        }

        .edit-btn {
            background-color: #007bff;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .edit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Daftar Galeri</h1>
        <a href="/superadmin/galeri/create">Tambah Galeri</a>
        <table>
            <thead>
                <tr>
                    <th>ID Galeri</th>
                    <th>Judul</th>
                    <th>URL</th>
                    <th>Tipe</th>
                    <th>Uploaded By</th>
                    <th>Uploaded At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($galeri as $item): ?>
                    <tr>
                        <td><?= $item['id_galeri'] ?></td>
                        <td><?= $item['judul'] ?></td>
                        <td><?= $item['url'] ?></td>
                        <td><?= $item['tipe'] ?></td>
                        <td><?= $item['uploaded_by'] ?></td>
                        <td><?= $item['uploaded_at'] ?></td>
                        <td>
                            <a href="/superadmin/galeri/edit/<?= $item['id_galeri'] ?>" class="edit-btn">Edit</a>
                            <a href="/superadmin/galeri/delete/<?= $item['id_galeri'] ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>