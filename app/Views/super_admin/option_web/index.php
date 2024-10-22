<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Option Web Settings</title>
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

        .edit-btn:hover {
            background-color: #0056b3;
        }

        .option-image {
            max-width: 150px;
            max-height: 100px;
            object-fit: cover;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Option Web Settings</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div style="color: green;">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div style="color: red;">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Setting Type</th>
                    <th>Value</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($options)): ?>
                    <?php foreach ($options as $option): ?>
                        <tr>
                            <td><?= esc($option['key']) ?></td>
                            <td><?= esc($option['seting_type']) ?></td>
                            <td>
                                <?php if ($option['seting_type'] === 'Image'): ?>
                                    <!-- Menampilkan gambar -->
                                    <img src="<?= base_url('assets/uploads/images/optionweb/' . esc($option['value'])) ?>" alt="Option Image" class="option-image">
                                <?php else: ?>
                                    <!-- Menampilkan teks jika bukan gambar -->
                                    <?= esc($option['value']) ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('/superadmin/optionweb/edit/' . $option['id_setting']) ?>" class="edit-btn">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No options found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>