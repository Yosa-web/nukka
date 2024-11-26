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
                <div class="card-header">
                    <p class="card-title-desc">
                        Berikut daftar data inovasi.
                    </p>
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
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td>
                                            <?= esc($row['judul']); ?>
                                        </td>
                                        <td>
                                            <?= esc($row['nama_opd']); ?>
                                        </td>
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
        <div
            class="modal fade"
            id="detailModal<?= $row['id_inovasi'] ?>"
            tabindex="-1"
            role="dialog"
            aria-labelledby="detailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4
                            class="modal-title"
                            id="detailModalLabel">
                            Detail Proposal
                        </h4>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <!-- <thead>
									<tr>
										<th>#</th>
										<th>First Name</th>
									</tr>
								</thead> -->
                                <tbody>
                                    <tr>
                                        <th scope="row" class="modal-detail-row">
                                            Judul
                                        </th>
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
                                        <td><?= esc($row['published_by']); ?></td>
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

<?= $this->endSection(); ?>