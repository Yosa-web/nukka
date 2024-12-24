<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Dashboard | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">

        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">Dashboard</h3>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Start Row for Persebaran Jenis Inovasi and Grafik Kunjungan -->
            <div class="row">
                <!-- Persebaran Jenis Inovasi (Lebih Kecil) -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Persebaran Jenis Inovasi</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="pie-chart" class="e-charts"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Grafik Kunjungan Website (Lebih Besar) -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Grafik Kunjungan Website</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="kunjungan-chart" class="e-charts" style="width: 100%; height: 350px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row for Persebaran Jenis Inovasi and Grafik Kunjungan -->

            <!-- Form Export CSV (remains unchanged) -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Ekspor Data CSV</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= site_url('export/csv') ?>" method="get">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="kategori">Kategori</label>
                                            <select class="form-select" name="kategori" id="kategori">
                                                <option value="" disabled selected>--- Pilih Kategori ---</option>
                                                <?php foreach ($kategoriOptions as $kategori): ?>
                                                    <option value="<?= $kategori['id_jenis_inovasi'] ?>"><?= $kategori['nama_jenis'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="bentuk">Bentuk</label>
                                            <select class="form-select" name="bentuk" id="bentuk">
                                                <option value="" disabled selected>--- Pilih Bentuk ---</option>
                                                <?php foreach ($bentukOptions as $bentuk): ?>
                                                    <option value="<?= $bentuk['id_bentuk'] ?>"><?= $bentuk['nama_bentuk'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="tahapan">Tahapan</label>
                                            <select class="form-select" name="tahapan" id="tahapan">
                                                <option value="" disabled selected>--- Pilih Tahapan ---</option>
                                                <?php foreach ($tahapanOptions as $tahapan): ?>
                                                    <option value="<?= $tahapan['id_tahapan'] ?>"><?= $tahapan['nama_tahapan'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian Status, Tahun dan Tombol Export menjadi satu baris -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="status">Status</label>
                                            <select class="form-select" name="status" required>
                                                <option value="semua" <?= !isset($_GET['status']) || $_GET['status'] == 'semua' ? 'selected' : '' ?>>Semua</option>
                                                <option value="tertunda" <?= isset($_GET['status']) && $_GET['status'] == 'tertunda' ? 'selected' : '' ?>>Tertunda</option>
                                                <option value="draf" <?= isset($_GET['status']) && $_GET['status'] == 'draf' ? 'selected' : '' ?>>Draf</option>
                                                <option value="terbit" <?= isset($_GET['status']) && $_GET['status'] == 'terbit' ? 'selected' : '' ?>>Terbit</option>
                                                <option value="arsip" <?= isset($_GET['status']) && $_GET['status'] == 'arsip' ? 'selected' : '' ?>>Arsip</option>
                                                <option value="tertolak" <?= isset($_GET['status']) && $_GET['status'] == 'tertolak' ? 'selected' : '' ?>>Tertolak</option>
                                                <option value="revisi" <?= isset($_GET['status']) && $_GET['status'] == 'revisi' ? 'selected' : '' ?>>Revisi</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="tahun">Tahun</label>
                                            <input type="number" class="form-control" name="tahun" id="tahun" placeholder="Masukkan Tahun" />
                                        </div>
                                    </div>

                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary btn-rounded waves-effect waves-light">Export</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Log Aktivitas (remains unchanged) -->
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ambil data kategori inovasi dari controller
    const kategoriData = <?= $kategoriCountsJson; ?>;
    console.log(kategoriData); // Debugging data

    // Persiapkan data untuk chart
    const labels = kategoriData.map(item => item.nama_jenis); // Nama jenis inovasi
    const dataCounts = kategoriData.map(item => item.count); // Jumlah inovasi per jenis

    // Mengambil elemen canvas
    const pieChartCanvas = document.getElementById("pie-chart");

    // Mengatur ukuran canvas secara langsung sebelum inisialisasi chart
    pieChartCanvas.width = 500; // Lebar 500px
    pieChartCanvas.height = 500; // Tinggi 500px

    // Inisialisasi Chart.js setelah mengubah ukuran canvas
    const pieChartCtx = pieChartCanvas.getContext("2d");

    new Chart(pieChartCtx, {
        type: 'pie',
        data: {
            labels: labels, // Kategori
            datasets: [{
                label: 'Jumlah Inovasi',
                data: dataCounts, // Jumlah inovasi per kategori
                backgroundColor: ['#fd625e', '#2ab57d', '#5156be', '#f4b400', '#ff9800', '#9c27b0'],
                borderColor: '#fff',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true, // Chart tetap responsif terhadap ukuran container
            maintainAspectRatio: false, // Nonaktifkan rasio aspek untuk mengontrol ukuran dengan lebih bebas
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' Inovasi';
                        }
                    }
                }
            }
        }
    });


    // Grafik kunjungan per bulan (Line Chart)
    const kunjunganData = <?= $kunjunganCountsJson; ?>; // Ambil data yang dikirimkan dari controller
    const kunjunganLabels = kunjunganData.labels; // Mengambil label bulan-tahun
    const kunjunganCounts = kunjunganData.data; // Mengambil jumlah kunjungan per bulan

    const kunjunganCtx = document.getElementById('kunjungan-chart').getContext('2d');
    new Chart(kunjunganCtx, {
        type: 'line', // Jenis grafik: Line chart
        data: {
            labels: kunjunganLabels, // Menggunakan bulan-tahun sebagai label pada sumbu X
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: kunjunganCounts, // Jumlah kunjungan per bulan
                borderColor: '#2ab57d', // Warna garis grafik
                backgroundColor: 'rgba(42, 181, 125, 0.1)', // Warna latar belakang area grafik
                borderWidth: 2, // Lebar garis
                fill: true, // Mengisi area di bawah garis
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top', // Posisi legenda grafik
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Bulan-Tahun', // Menampilkan label bulan-tahun pada sumbu X
                    },
                    ticks: {
                        maxRotation: 45, // Mengatur rotasi label agar mudah dibaca
                        minRotation: 45, // Mengatur rotasi label agar mudah dibaca
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Jumlah Kunjungan', // Label sumbu Y
                    },
                    beginAtZero: true, // Memulai sumbu Y dari 0
                }
            }
        }
    });
</script>

<?= $this->endSection(); ?>