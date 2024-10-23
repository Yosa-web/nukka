<?= $this->extend('layout/master_dashboard'); ?>

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

                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100 table-hover">
                                <thead>
                                    <tr>
                                        <th>ID User</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                        <th>Jenis Data</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="#" data-bs-toggle="tooltip" data-bs-placement="right"
                                                title="Super Admin">234</a></td>
                                        <td>2012/03/29</td>
                                        <td>Edit data</td>
                                        <td>Kelola berita</td>
                                        <td>menambah berita</td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" data-bs-toggle="tooltip" data-bs-placement="right"
                                                title="Admin OPD">102</a></td>
                                        <td>2012/03/29</td>
                                        <td>Login</td>
                                        <td>Kelola galeri</td>
                                        <td>masuk ke sistem</td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" data-bs-toggle="tooltip" data-bs-placement="right"
                                                title="Operator">153</a></td>
                                        <td>2012/03/29</td>
                                        <td>Login</td>
                                        <td>Kelola galeri</td>
                                        <td>masuk ke sistem</td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" data-bs-toggle="tooltip" data-bs-placement="right"
                                                title="Kepala OPD">123</a></td>
                                        <td>2012/03/29</td>
                                        <td>Edit data</td>
                                        <td>Kelola berita</td>
                                        <td>menambah berita</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>