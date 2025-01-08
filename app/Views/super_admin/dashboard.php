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


                <!-- Grafik Kunjungan Website (Lebih Besar) -->
                <div class="col-xl-12"> <!-- Perubahan dari col-xl-6 ke col-xl-12 untuk membuat grafik lebih besar -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Grafik Kunjungan Website</h5>
                        </div>
                        <div class="card-body">
                            <!-- Canvas sekarang akan memenuhi lebar dan tinggi -->
                            <canvas id="kunjungan-chart" class="e-charts" style="width: 100%; height: 600px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
            maintainAspectRatio: false, // Menonaktifkan rasio aspek untuk responsivitas penuh
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