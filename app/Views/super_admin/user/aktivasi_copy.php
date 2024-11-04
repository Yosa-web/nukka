<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Belum Aktif</title>
</head>
<body>
    <h1>Daftar Akun Belum Aktif</h1>

    <?php if (session()->has('message')) : ?>
        <p style="color: green;"><?= session('message') ?></p>
    <?php endif; ?>

    <?php if (session()->has('error')) : ?>
        <p style="color: red;"><?= session('error') ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>OPD</th>
                <th>NIP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $index => $user): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc($user->name) ?></td>
                    <td><?= esc($user->email) ?></td>
                    <td><?= esc($user->nama_opd) ?></td> <!-- Langsung akses objek entitas -->
                    <td><?= esc($user->NIP) ?></td>
                    <td>
                        <form action="<?= site_url('useractivation/activate/' . $user->id) ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" onclick="return confirm('Aktifkan akun ini?')">Aktifkan</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
