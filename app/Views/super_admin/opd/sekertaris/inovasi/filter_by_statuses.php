<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Berdasarkan Status</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-4">Daftar Proposal (Draf, Revisi, Terbit, Arsip)</h1>

        <a href="/sekertaris/inovasi" class="btn btn-primary mb-3">Ke Daftar Proposal</a>

        <a href="/sekertaris/inovasi/create" class="btn btn-success mb-3">Tambah Proposal</a>

        <!-- Tabel untuk menampilkan daftar inovasi -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php

                use CodeIgniter\I18n\Time;

                if (!empty($inovasi)): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($inovasi as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= esc($row['judul']); ?></td>
                            <td><?= esc($row['deskripsi']); ?></td>
                            <td><?= esc($row['nama_jenis']); ?></td>
                            <td><?= esc($row['status']); ?></td>
                            <td><?= esc($row['tanggal_pengajuan']); ?></td>
                            <td>
                                <!-- <a href="/sekertaris/inovasi/edit/<?= $row['id_inovasi']; ?>" class="btn btn-warning btn-sm">Edit</a> -->
                                <!-- <a href="/sekertaris/inovasi/delete/<?= $row['id_inovasi']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a> -->
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal<?= $row['id_inovasi'] ?>">Detail</button>
                            </td>
                        </tr>

                        <!-- Modal untuk detail -->
                        <div class="modal fade" id="detailModal<?= $row['id_inovasi'] ?>" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel">Detail Proposal Inovasi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Judul:</strong> <?= esc($row['judul']); ?></p>
                                        <p><strong>Deskripsi:</strong> <?= esc($row['deskripsi']); ?></p>
                                        <p><strong>Kategori:</strong> <?= esc($row['nama_jenis']); ?></p>
                                        <p><strong>Kecamatan:</strong> <?= esc($row['kecamatan']); ?></p>
                                        <p><strong>Status:</strong> <?= ucfirst($row['status']); ?></p>

                                        <?php if ($row['status'] === 'terbit'): ?>
                                            <p><strong>Published by:</strong> <?= esc($row['published_by']); ?></p>
                                            <p><strong>Published at:</strong> <?= esc($row['published_at']); ?></p>
                                        <?php endif; ?>

                                        <?php if ($row['status'] === 'revisi'): ?>
                                            <div class="pesan-status">
                                                <p><strong>Pesan Revisi:</strong></p>
                                                <?php
                                                $pesanMessages = explode('---', $row['pesan']);
                                                foreach ($pesanMessages as $message): ?>
                                                    <p class="ml-3">• <?= esc(trim($message)); ?></p>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php elseif (in_array($row['status'], ['tertolak', 'arsip'])): ?>
                                            <div class="pesan-status">
                                                <p><strong>Pesan:</strong> <?= esc($row['pesan']); ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <p><strong>Tanggal Pengajuan:</strong> <?= esc($row['tanggal_pengajuan']); ?></p>
                                        <p><strong>File:</strong> <a href="<?= base_url($row['url_file']) ?>" target="_blank">Download File</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data inovasi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>