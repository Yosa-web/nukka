<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Inovasi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Additional styling */
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-4">Daftar Proposal</h1>

        <a href="/sekertaris/inovasi/filter" class="btn btn-primary mb-3">Ke Daftar Proposal</a>

        <!-- Tombol untuk menambah proposal -->
        <!-- <a href="/superadmin/inovasi/create" class="btn btn-success mb-3">Tambah Proposal</a> -->

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
                <?php if (!empty($inovasi)): ?>
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
                                <?php if ($row['status'] === 'tertolak'): ?>
                                    <!-- <a href="/superadmin/inovasi/view/<?= $row['id_inovasi']; ?>" class="btn btn-info btn-sm">Lihat</a> -->
                                    <!-- <a href="/superadmin/inovasi/edit/<?= $row['id_inovasi']; ?>" class="btn btn-warning btn-sm">Edit</a> -->
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal<?= $row['id_inovasi'] ?>">Detail</button>
                                <?php else: ?>
                                    <!-- <button onclick="ubahStatus(<?= $row['id_inovasi']; ?>, 'draf')" class="btn btn-success btn-sm">Setujui</button> -->
                                    <!-- <button onclick="ubahStatus(<?= $row['id_inovasi']; ?>, 'tertolak')" class="btn btn-danger btn-sm">Tolak</button> -->
                                    <button onclick="setujuiInovasi(<?= $row['id_inovasi']; ?>)" class="btn btn-success btn-sm">Setujui</button>
                                    <button onclick="tolakInovasi(<?= $row['id_inovasi']; ?>)" class="btn btn-danger btn-sm">Tolak</button>
                                    <button onclick="revisiInovasi(<?= $row['id_inovasi']; ?>)" class="btn btn-warning btn-sm">Revisi</button>
                                    <!-- <a href="/sekertaris/inovasi/edit/<?= $row['id_inovasi']; ?>" class="btn btn-warning btn-sm">Edit</a> -->
                                    <!--<a href="/superadmin/inovasi/delete/<?= $row['id_inovasi']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a> -->
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal<?= $row['id_inovasi'] ?>">Detail</button>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Modal Tolak -->
                        <div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="formTolak" method="post" action="/sekertaris/inovasi/tolak">
                                        <?= csrf_field() ?>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTolakLabel">Kirim Pesan Penolakan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id_inovasi" id="id_inovasi">
                                            <div class="form-group">
                                                <label for="pesan">Pesan Penolakan</label>
                                                <textarea class="form-control" id="pesan" name="pesan" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Kirim Pesan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script>
                            function tolakInovasi(id) {
                                $('#id_inovasi').val(id);
                                $('#modalTolak').modal('show');
                            }
                        </script>

                        <!-- Modal Revisi -->
                        <div class="modal fade" id="modalRevisi" tabindex="-1" aria-labelledby="modalRevisiLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="formRevisi" method="post" action="/kepala/inovasi/revisi">
                                        <?= csrf_field() ?>
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalRevisiLabel">Kirim Pesan Revisi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id_inovasi" id="id_inovasi_revisi">
                                            <div class="form-group">
                                                <label for="pesan_revisi">Pesan Revisi</label>
                                                <textarea class="form-control" id="pesan_revisi" name="pesan" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning">Kirim Pesan Revisi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script>
                            function revisiInovasi(id) {
                                $('#id_inovasi_revisi').val(id);
                                $('#modalRevisi').modal('show');
                            }
                        </script>


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
                                            <p><strong>Published at:</strong> <?= date('d-m-Y H:i:s', strtotime($row['published_at'])); ?></p>
                                        <?php endif; ?>

                                        <?php if (in_array($row['status'], ['revisi', 'tertolak', 'arsip'])): ?>
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
    <script>
        function ubahStatus(id, status) {
            $.ajax({
                url: '/kepala/inovasi/updateStatus/' + id,
                type: 'POST',
                data: {
                    status: status,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#status-' + id).text(status);
                    alert('Status berhasil diubah menjadi ' + status);
                },
                error: function(xhr, status, error) {
                    alert('Gagal mengubah status. Error: ' + xhr.responseText);
                }
            });
        }
    </script>
    <script>
        function setujuiInovasi(id) {
            if (confirm('Apakah Anda yakin ingin menyetujui inovasi ini?')) {
                $.post('/kepala/inovasi/setujui', {
                        id_inovasi: id,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    })
                    .done(function(response) {
                        alert('Disetujui'); // Tampilkan notifikasi "disetujui"
                        location.reload(); // Reload halaman untuk memperbarui status
                    })
                    .fail(function() {
                        alert('Terjadi kesalahan. Coba lagi.');
                    });
            }
        }
    </script>

</body>

</html>