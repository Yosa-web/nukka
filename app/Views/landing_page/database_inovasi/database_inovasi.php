<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Database Inovasi | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url('beranda') ?>">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Inovasi</li>
    </ol>
</div>
<div class="container-fluid mb-5">
    <h1 class="pb-3 pt-4 fw-semibold">Database Inovasi</h1>
    <div class="row pb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="card-title-desc">
                        Berikut daftar data inovasi.
                    </p>
                    <div class="d-flex">
                        <label for="kategori-filter" class="me-2">Kategori</label>
                        <select id="kategori-filter" class="form-select form-select-sm" style="width: auto;">
                            <option value="all-kategori">Semua Kategori</option>
                            <?php foreach ($jenis_inovasi as $jenis): ?>
                                <option value="<?= esc($jenis['nama_jenis']) ?>"><?= esc($jenis['nama_jenis']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <table
                        id="datatable"
                        class="table table-bordered dt-responsive w-100 table-hover">
                        <thead>
                            <tr class="align-middle">
                                <th
                                    class="text-center"
                                    style="width: 20px">
                                    No.
                                </th>
                                <th
                                    class="text-center"
                                    style="width: 250px">
                                    Judul Proposal
                                </th>
                                <th
                                    class="text-center"
                                    style="width: 250px">
                                    Nama OPD
                                </th>
                                <th class="text-center" style="width: 100px">Kategori</th>
                                <th
                                    class="text-center"
                                    style="width: 120px">
                                    Tahun
                                </th>
                                <th
                                    class="text-center"
                                    style="width: 100px">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            use CodeIgniter\I18n\Time;

                            if (!empty($inovasi)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($inovasi as $row): ?>
                                    <tr data-jenis="<?= esc($row['nama_jenis']) ?>">
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td>
                                            <?= esc($row['judul']); ?>
                                        </td>
                                        <td class="text-center">
                                            <?= esc($row['nama_opd']); ?>
                                        </td>
                                        <td class="text-center"><?= esc($row['nama_jenis']); ?></td>
                                        <td class="text-center"><?= date('Y', strtotime($row['tanggal_pengajuan'])) ?></td>
                                        <td class="text-center">
                                            <a
                                                href="<?= base_url($row['url_file']) ?>"
                                                class="btn btn-outline-primary btn-sm mb-3"
                                                title="Unduh">
                                                <i
                                                    class="fas fa-download"></i>
                                            </a>
                                            <a
                                                class="btn btn-outline-secondary btn-sm ms-2 mb-3"
                                                data-bs-toggle="modal"
                                                data-bs-target="#detailModal<?= $row['id_inovasi'] ?>"
                                                title="Detail"><i class="fas fa-eye"></i></a>
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
                                        <td><?= esc($row['nama_opd']); ?></td> <!-- Menampilkan nama OPD -->
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
                                        <!-- <tr>
                                            <th scope="row">Disetujui oleh</th>
                                            <td><?= esc($row['published_by']); ?></td>
                                        </tr> -->
                                    <?php endif; ?>
                                    <?php if (in_array($row['status'], ['revisi', 'tertolak', 'arsip'])): ?>
                                        <tr>
                                            <th scope="row">Pesan</th>
                                            <td><?= esc($row['pesan']); ?></td>
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


<script>
    document.getElementById('kategori-filter').addEventListener('change', function() {
        const filterValue = this.value.toLowerCase(); // Ambil nilai filter dan ubah menjadi lowercase
        const rows = document.querySelectorAll('#datatable tbody tr'); // Ambil semua baris data

        rows.forEach(row => {
            const kategori = row.getAttribute('data-jenis').toLowerCase(); // Ambil kategori dari atribut data-jenis

            if (filterValue === 'all-kategori') {
                row.style.display = ''; // Tampilkan semua baris jika "Semua Jenis" dipilih
            } else if (kategori.includes(filterValue)) {
                row.style.display = ''; // Tampilkan baris yang sesuai dengan kategori
            } else {
                row.style.display = 'none'; // Sembunyikan baris yang tidak sesuai
            }
        });
    });
</script>
<?= $this->endSection(); ?>