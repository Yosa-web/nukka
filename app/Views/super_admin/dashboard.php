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
                            <h5 class="mb-0">Persebaran Jenis Inovasi</h5>
                        </div>
                        <div class="card-body">
                            <div id="pie-chart" data-colors='["#fd625e", "#2ab57d","#5156be"]' class="e-charts"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Grafik Kunjungan Website</h5>
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
                            <h5 class="mb-0">Ekspor Data CSV</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= site_url('export/csv') ?>" method="get">
                                <div class="row">
                                    <div
                                        class="col-md-4">
                                        <div
                                            class="mb-3">
                                            <label
                                                class="form-label"
                                                for="kategori">Kategori</label>
                                            <select
                                                class="form-select" name="kategori" id="kategori">
                                                <option value="" disabled selected>
                                                    --- Pilih Kategori ---
                                                </option>
                                                <?php foreach ($kategoriOptions as $kategori): ?>
                                                    <option value="<?= $kategori['id_jenis_inovasi'] ?>"><?= $kategori['nama_jenis'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-4">
                                        <div
                                            class="mb-3">
                                            <label
                                                class="form-label"
                                                for="bentuk">Bentuk</label>
                                            <select
                                                class="form-select" name="bentuk" id="bentuk">
                                                <option value="" disabled selected>
                                                    --- Pilih Bentuk ---
                                                </option>
                                                <?php foreach ($bentukOptions as $bentuk): ?>
                                                    <option value="<?= $bentuk['id_bentuk'] ?>"><?= $bentuk['nama_bentuk'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-4">
                                        <div
                                            class="mb-3">
                                            <label
                                                class="form-label"
                                                for="tahapan">Tahapan</label>
                                            <select
                                                class="form-select" name="tahapan" id="tahapan">
                                                <option value="" disabled selected>
                                                    --- Pilih Tahapan ---
                                                </option>
                                                <?php foreach ($tahapanOptions as $tahapan): ?>
                                                    <option value="<?= $tahapan['id_tahapan'] ?>"><?= $tahapan['nama_tahapan'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div
                                        class="col-md-4">
                                        <div
                                            class="mb-3">
                                            <label
                                                class="form-label"
                                                for="status">Status</label>
                                            <select
                                                class="form-select" name="status" required>
                                                <option value="" <?= !isset($_GET['status']) || $_GET['status'] == '' ? 'selected' : '' ?>>Semua</option>
                                                <option value="tertunda" <?= isset($_GET['status']) && $_GET['status'] == 'tertunda' ? 'selected' : '' ?>>Tertunda</option>
                                                <option value="draf" <?= isset($_GET['status']) && $_GET['status'] == 'draf' ? 'selected' : '' ?>>Draf</option>
                                                <option value="terbit" <?= isset($_GET['status']) && $_GET['status'] == 'terbit' ? 'selected' : '' ?>>Terbit</option>
                                                <option value="arsip" <?= isset($_GET['status']) && $_GET['status'] == 'arsip' ? 'selected' : '' ?>>Arsip</option>
                                                <option value="tertolak" <?= isset($_GET['status']) && $_GET['status'] == 'tertolak' ? 'selected' : '' ?>>Tertolak</option>
                                                <option value="revisi" <?= isset($_GET['status']) && $_GET['status'] == 'revisi' ? 'selected' : '' ?>>Revisi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-4">
                                        <div
                                            class="mb-3">
                                            <label
                                                class="form-label"
                                                for="tahun">Tahun</label>
                                            <input
                                                type="number"
                                                class="form-control"
                                                name="tahun" id="tahun" placeholder="Masukkan Tahun" />
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-4">
                                        <div class="mt-4">
                                        <button type="submit" class="btn btn-primary btn-rounded waves-effect waves-light">Export</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Log Aktivitas</h5>
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