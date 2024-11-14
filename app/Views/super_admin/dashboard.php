<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Dashboard | Rumah Inovasi</title><?= $this->endSection() ?>
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
                            Dashboard
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Dashboard
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Persebaran Jenis Inovasi</h4>
                        </div>
                        <div class="card-body">
                            <div id="pie-chart" data-colors='["#fd625e", "#2ab57d","#5156be"]' class="e-charts"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Grafik Kunjungan Website</h4>
                        </div>
                        <div class="card-body">
                            <div id="mix-line-bar" data-colors='["#2ab57d", "#5156be", "#fd625e"]' class="e-charts"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="">Log Aktivitas</h4>
                        </div>
                        <div class="card-body">
                            <?php if (empty($log)): ?>
                                <p>Data log aktivitas kosong.</p>
                            <?php else: ?>
                                <table id="datatable" class="table table-bordered dt-responsive w-100 table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px">ID User</th>
                                            <th style="width: 200px">Waktu</th>
                                            <th style="width: 80px">Aksi</th>
                                            <th style="width: 100px">Jenis Data</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($log as $item): ?>
                                            <tr>
                                                <td><a href="#" data-bs-toggle="tooltip" data-bs-placement="right"
                                                        title="<?= $item['name'] ?>"><?= $item['id_user'] ?></a></td>
                                                <td><?= $item['tanggal_aktivitas'] ?></td>
                                                <td><?= $item['aksi'] ?></td>
                                                <td><?= $item['jenis_data'] ?></td>
                                                <td><?= $item['keterangan'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>