<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Data Berita</title>
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
            display: inline-block;
            margin-bottom: 20px;
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
        <h1>Daftar Berita</h1>
        <a href="/superadmin/berita/create">Tambah Berita</a>
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Tanggal Posting</th>
                    <th>Status</th>
                    <th>uploaded by</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($berita as $item): ?>
                <tr>
                    <td><?= $item['judul'] ?></td>
                    <td><?= substr($item['isi'], 0, 50) . '...' ?></td> <!-- Menampilkan ringkasan isi -->
                    <td><?= date('d-m-Y H:i', strtotime($item['tanggal_post'])) ?></td> <!-- Format tanggal -->
                    <td><?= ucfirst($item['status']) ?></td>
                    <td><?= $item['uploaded_by_username'] ?></td> <!-- Menampilkan username pengguna yang mengunggah -->
                    <td>
                        <a class="edit-btn" href="<?= base_url('superadmin/berita/' . $item['id_berita'] . '/edit') ?>">Edit</a>
                        <form action="<?= base_url('superadmin/berita/' . $item['id_berita']) ?>" method="post" style="display: inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <?= csrf_field() ?>
                            <button type="submit" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
                </table>
    </div>
</body>

</html>
