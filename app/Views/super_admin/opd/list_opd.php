<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Data OPD</title>
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
        <h1>Daftar Jenis Inovasi</h1>
        <a href="/superadmin/opd/create">Tambah Jenis Inovasi</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Jenis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($opd as $jenis): ?>
                    <tr>
                        <td><?= $jenis['nama_opd'] ?></td>
                        <td><?= $jenis['alamat'] ?></td>
                        <td><?= $jenis['telepon'] ?></td>
                        <td><?= $jenis['email'] ?></td>
                        <td>
                        <a class="btn btn-warning" href="<?= base_url('superadmin/opd/' . $jenis['id_opd'] . '/edit') ?>">Edit</a>
                            <form action="<?= base_url('superadmin/opd/' . $jenis['id_opd']) ?>" method="post" style="display: inline;">
    <input type="hidden" name="_method" value="DELETE">
    <?= csrf_field() ?>
    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Delete</button>
</form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>