<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Daftar Proposal | Rumah Inovasi</title><?= $this->endSection() ?>
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
                            Daftar Proposal
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
                                    Daftar Proposal
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php if (session()->getFlashdata('error') || session()->getFlashdata('success')): ?>
                <div class="alert alert-dismissible fade show <?= session()->getFlashdata('error') ? 'alert-danger' : 'alert-success' ?>">
                    <?= session()->getFlashdata('error') ?: session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-end">
                            <button type="button" class="btn btn-primary waves-effect btn-label waves-light" onclick="window.location.href='/userumum/inovasi/create'"><i class="bx bx-plus label-icon"></i>Tambah Data</button>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive w-100 table-hover">
                                <thead>
                                    <tr class="align-middle">
                                        <th class="text-center" style="width: 220px">Judul Inovasi</th>
                                        <th class="text-center" style="width: 250px">Deskripsi</th>
                                        <th class="text-center" style="width: 100px">Kategori</th>
                                        <th class="text-center" style="width: 120px">Tanggal Pengajuan</th>
                                        <th class="text-center" style="width: 70px">Status</th>
                                        <th class="text-center" style="width: 120px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    use CodeIgniter\I18n\Time;

                                    if (!empty($inovasi)): ?>
                                        <?php foreach ($inovasi as $row): ?>
                                            <tr>
                                                <td><?= esc($row['judul']); ?></td>
                                                <td><?= esc(substr($row['deskripsi'], 0, 100)) . '...'; ?>
                                                </td>
                                                <td class="text-center"><?= esc($row['nama_jenis']); ?></td>
                                                <td class="text-center"><?= date('d M Y', strtotime($row['tanggal_pengajuan'])) ?></td>
                                                <td class="text-center">
                                                    <span class="badge rounded-pill <?= $row['status'] === 'terbit' ? 'bg-success' : ($row['status'] === 'draf' ? 'bg-secondary' : ($row['status'] === 'arsip' ? 'bg-warning' : ($row['status'] === 'revisi' ? 'bg-info' : ($row['status'] === 'tertunda' ? 'bg-secondary' : ($row['status'] === 'tertolak' ? 'bg-danger' : ''))))) ?>"><?= ucfirst($row['status']) ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($row['status'] === 'revisi'): ?>
                                                        <!-- Tombol Edit dan Hapus hanya ditampilkan jika status adalah "revisi" -->
                                                        <a href="/userumum/inovasi/edit/<?= $row['id_inovasi']; ?>" class="btn btn-outline-warning btn-sm edit mb-3" title="Edit">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="/userumum/inovasi/delete/<?= $row['id_inovasi']; ?>" class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <!-- Tombol Detail akan selalu ditampilkan -->
                                                    <a class="btn btn-outline-secondary btn-sm ms-2 mb-3" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['id_inovasi'] ?>" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
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
        </div>
    </div>
</div>

<!-- Modal Detail -->
<?php if (!empty($inovasi)): ?>
    <?php foreach ($inovasi as $row): ?>
        <div class="modal fade" id="detailModal<?= $row['id_inovasi'] ?>" tabindex="-1" role="dialog"
            aria-labelledby="detailModalLabel<?= $row['id_inovasi'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="detailModalLabel<?= $row['id_inovasi'] ?>">Detail Proposal</h4>
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
                                        <th scope="row">Tahun</th>
                                        <td><?= esc($row['tahun']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nama OPD</th>
                                        <td><?= esc(!empty($row['nama_opd']) ? $row['nama_opd'] : '-'); ?></td> <!-- Menampilkan nama OPD, atau "-" jika kosong -->
                                    </tr>
                                    <tr>
                                        <th scope="row">Kategori</th>
                                        <td><?= esc($row['nama_jenis']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Bentuk</th>
                                        <td><?= esc($row['nama_bentuk']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tahapan</th>
                                        <td><?= esc($row['nama_tahapan']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kecamatan</th>
                                        <td><?= esc($row['nama_kecamatan']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Desa</th>
                                        <td><?= esc($row['nama_desa']); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tanggal Pengajuan</th>
                                        <td><?= date('d M Y', strtotime($row['tanggal_pengajuan'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Diajukan oleh</th>
                                        <td><?= esc($row['diajukan_oleh']); ?></td> <!-- Ganti sesuai dengan data pengaju -->
                                    </tr>
                                    <tr>
                                        <th scope="row">Status</th>
                                        <td><?= ucfirst($row['status']); ?></td>
                                    </tr>
                                    <?php if ($row['status'] === 'terbit'): ?>
                                        <tr>
                                            <th scope="row">Tanggal Disetujui</th>
                                            <td><?= date('d M Y', strtotime($row['updated_at'])) ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if (in_array($row['status'], ['revisi', 'tertolak', 'arsip'])): ?>
                                        <tr>
                                            <th scope="row">Pesan</th>
                                            <td>
                                                <?php if (!empty($row['pesan'])): ?>
                                                    <ul>
                                                        <?php
                                                        // Pisahkan pesan berdasarkan baris baru dan tampilkan sebagai list item
                                                        $pesanArray = explode("\n", $row['pesan']);
                                                        foreach ($pesanArray as $pesanItem): ?>
                                                            <li><?= esc($pesanItem); ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else: ?>
                                                    <p>No pesan available.</p>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
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

<!-- Sweet Alerts js -->
<script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Sweet alert init js-->
<script>
    document.querySelectorAll(".delete").forEach(function(button) {
        button.addEventListener("click", function(event) {
            event.preventDefault();

            const href = this.getAttribute("href");

            Swal.fire({
                title: "Konfirmasi hapus?",
                text: "Anda yakin ingin menghapus data ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#2ab57d",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>