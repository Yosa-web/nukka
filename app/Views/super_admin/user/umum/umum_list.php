<!-- pengguna_umum/list.php -->
<h2>Daftar Pengguna - Pengguna Umum</h2>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<h3>Pengguna Umum</h3>
<?php if (!empty($penggunaUmum)): ?>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>No Telepon</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Email</th>
                <th>Group</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($penggunaUmum as $user): ?>
                <tr>
                    <td><?= esc($user['no_telepon']); ?></td>
                    <td><?= esc($user['name']); ?></td>
                    <td><?= esc($user['NIK']); ?></td>
                    <td><?= esc($user['email']); ?></td>
                    <td><?= esc($user['group']); ?></td>
                    <td>
                        <a href="<?= site_url('penggunaumum/edit/' . $user['id']); ?>">Edit</a> |
                        <form action="<?= site_url('penggunaumum/delete/' . $user['id']); ?>" method="post" style="display:inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this user?');">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Tidak ada Pengguna Umum.</p>
<?php endif; ?>
