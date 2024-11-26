<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Verifikasi Proposal | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">
                            Verifikasi Proposal
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Inovasi</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Data Inovasi</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Verifikasi Proposal
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <p class="card-title-desc">Berikut daftar proposal yang belum disetujui.
                            </p>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive w-100 table-hover">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="text-center" style="width: 220px">Judul Inovasi</th>
                                        <th class="text-center" style="width: 250px">Deskripsi</th>
                                        <th class="text-center" style="width: 90px">Kategori</th>
                                        <th class="text-center" style="width: 100px">Tanggal Pengajuan</th>
                                        <th class="text-center" style="width: 70px">Status</th>
                                        <th class="text-center" style="width: 95px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tertolakData = []; // Array untuk menampung data yang ditolak
                                    if (!empty($inovasi)):
                                        foreach ($inovasi as $row):
                                            if ($row['status'] === 'tertolak'):
                                                $tertolakData[] = $row; // Pindahkan data "tertolak" ke array tersendiri
                                                continue;
                                            endif; ?>
                                            <tr>
                                                <td><?= esc($row['judul']); ?></td>
                                                <td><?= esc(substr($row['deskripsi'], 0, 100)) . '...'; ?></td>
                                                <td><?= esc($row['nama_jenis']); ?></td>
                                                <td class="text-center"><?= date('d M Y', strtotime($row['tanggal_pengajuan'])) ?></td>
                                                <td class="text-center"><span class="badge bg-secondary rounded-pill"><?= esc($row['status']); ?></span></td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="me-2">
                                                            <button onclick="setujuiInovasi(<?= $row['id_inovasi']; ?>)" class="btn btn-outline-success btn-sm mb-2" title="Setujui">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button onclick="tolakInovasi(<?= $row['id_inovasi']; ?>)" class="btn btn-outline-danger btn-sm ms-2 mb-2" title="Tolak">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="me-2">
                                                            <a href="/kepala/inovasi/edit/<?= $row['id_inovasi']; ?>" class="btn btn-outline-warning btn-sm edit mb-2" title="Edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <button class="btn btn-outline-secondary btn-sm ms-2 mb-2" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['id_inovasi'] ?>" title="Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data inovasi.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Proposal Tertolak</h3>
                            <p class="card-title-desc">Berikut daftar proposal yang telah ditolak.
                            </p>
                        </div>
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-bordered dt-responsive w-100 table-hover">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="text-center" style="width: 220px">Judul Inovasi</th>
                                        <th class="text-center" style="width: 250px">Deskripsi</th>
                                        <th class="text-center" style="width: 90px">Kategori</th>
                                        <th class="text-center" style="width: 120px">Tanggal Pengajuan</th>
                                        <th class="text-center" style="width: 80px">Status</th>
                                        <th class="text-center" style="width: 65px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($tertolakData)): ?>
                                        <?php foreach ($tertolakData as $row): ?>
                                            <tr>
                                                <td><?= esc($row['judul']); ?></td>
                                                <td><?= esc(substr($row['deskripsi'], 0, 100)) . '...'; ?></td>
                                                <td><?= esc($row['nama_jenis']); ?></td>
                                                <td class="text-center"><?= date('d M Y', strtotime($row['tanggal_pengajuan'])) ?></td>
                                                <td class="text-center"><span class="badge bg-danger rounded-pill"><?= esc($row['status']); ?></span></td>
                                                <td class="text-center">
                                                    <a class="btn btn-outline-secondary btn-sm ms-2 mb-3" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['id_inovasi'] ?>" title="Detail"><i class="fas fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data inovasi tertolak.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<?php if (!empty($inovasi)): ?>
    <?php foreach ($inovasi as $row): ?>
        <div class="modal fade" id="detailModal<?= $row['id_inovasi'] ?>" tabindex="-1" role="dialog"
            aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="detailModalLabel">Detail Proposal</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row" style="width: 230px">Judul Inovasi</th>
                                        <td><?= esc($row['judul']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Deskripsi</th>
                                        <td><?= esc($row['deskripsi']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kategori</th>
                                        <td><?= esc($row['nama_jenis']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kecamatan</th>
                                        <td><?= esc($row['kecamatan']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tanggal Pengajuan</th>
                                        <td><?= date('d M Y', strtotime($row['tanggal_pengajuan'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Diajukan oleh</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Status</th>
                                        <td><?= ucfirst($row['status']); ?></td>
                                    </tr>
                                    <?php if ($row['status'] === 'terbit'): ?>
                                        <tr>
                                            <th scope="row">Tanggal Disetujui</th>
                                            <td><?= date('d M Y', strtotime($row['published_at'])) ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Disetujui oleh</th>
                                            <td><?= esc($row['published_by']); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if (in_array($row['status'], ['revisi', 'tertolak', 'arsip'])): ?>
                                        <div class="pesan-status">
                                            <p><strong>Pesan:</strong> <?= esc($row['pesan']); ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <tr>
                                        <th scope="row">File Proposal</th>
                                        <td><a href="<?= base_url($row['url_file']) ?>" target="_blank" type="button" class="btn btn-soft-primary waves-effect btn-label"><i class="fas fa-download label-icon"></i>Download File</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


<!-- Modal Tolak -->
<?php if (!empty($inovasi)): ?>
    <?php foreach ($inovasi as $row): ?>
<div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTolak" method="post" action="/kepala/inovasi/tolak">
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
<?php endforeach; ?>
<?php endif; ?>

<!-- Sweet Alerts js -->
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<!-- Sweet alert init js-->
<script>
    document.getElementById("sa-title").addEventListener("click", function() {
            Swal.fire({
                title: "Setujui?",
                text: "Anda yakin akan menyetujui proposal ini?",
                icon: "success",
                confirmButtonColor: "#5156be",
            });
        }),
        document.getElementById("sa-params").addEventListener("click", function() {
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda yakin akan menolak proposal ini?",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "Ya, tolak!",
                cancelButtonText: "Batal",
                confirmButtonClass: "btn btn-primary mt-2",
                cancelButtonClass: "btn btn-secondary ms-2 mt-2",
                buttonsStyling: !1,
            }).then(function(e) {
                e.value &&
                    Swal.fire(
                        "Ditolak!",
                        "Proposal tersebut telah ditolak.",
                        "error",
                    );
            });
        });
</script>
<script>
    function tolakInovasi(id) {
        $('#id_inovasi').val(id);
        $('#modalTolak').modal('show');
    }
</script>
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
<?= $this->endSection(); ?>