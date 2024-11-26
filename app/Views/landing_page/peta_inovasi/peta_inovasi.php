<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Peta Inovasi | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="beranda.html">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Peta Inovasi</li>
    </ol>
</div>
<div class="container-fluid mb-5">
    <div class="peta-content">
        <h1 class="pb-4 pt-5 fw-semibold">Peta Inovasi</h1>
        <div id="map" style="height: 500px;"></div>
    </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Inisialisasi peta
    const map = L.map('map').setView([-5.4298, 105.17899], 10); // Koordinat Pesawaran

    // Tambahkan tile layer (peta dasar)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    function loadMapData() {
        Promise.all([
                fetch('/api/jumlah-inovasi').then(res => res.json()),
                fetch('/assets/libs/kecamatan_pesawaran.geojson').then(res => res.json())
            ])
            .then(([inovasiData, geojsonData]) => {
                // Gabungkan data jumlah inovasi ke GeoJSON
                geojsonData.features.forEach(feature => {
                    const kecamatan = feature.properties.NAMOBJ; // Nama kecamatan di GeoJSON
                    const inovasi = inovasiData.find(item => item.kecamatan === kecamatan);

                    // Tambahkan jumlah inovasi ke properties GeoJSON
                    feature.properties.jumlahInovasi = inovasi ? inovasi.jumlahInovasi : 0;
                });

                // Tampilkan peta dengan styling warna
                displayMap(geojsonData);
            })
            .catch(error => console.error('Error loading data:', error));
    }

    // Fungsi untuk menampilkan peta
    function displayMap(geojsonData) {
        L.geoJSON(geojsonData, {
            style: feature => {
                // Mendefinisikan warna berdasarkan kecamatan di Pesawaran
                const colors = {
                    "GEDONG TATAAN": "#FF0000", // Merah
                    "NEGERI KATON": "#0077c2", // Biru
                    "TEGINENENG": "#00FF00", // Hijau
                    "WAY LIMA": "#FFFF00", // Kuning
                    "WAY KHILAU": "#FF00FF", // Ungu
                    "PUNDUH PIDADA": "#00FFFF", // Cyan
                    "PADANG CERMIN": "#FFA500", // Oranye
                    "TELUK PANDAN": "#800080", // Violet
                    "MARGA PUNDUH": "#8B0000", // Merah Gelap
                    "KEDONDONG": "#000080", // Biru Tua
                };

                // Default jika NAMOBJ tidak terdaftar
                const defaultColor = "#888888";

                return {
                    color: '#000000', // Warna garis tepi (hitam)
                    weight: 1.5, // Ketebalan garis tepi
                    fillColor: colors[feature.properties.NAMOBJ] || defaultColor, // Warna isi
                    fillOpacity: 0.7 // Transparansi warna isi
                };
            },
            onEachFeature: (feature, layer) => {
                if (feature.properties && feature.properties.NAMOBJ) {
                    layer.on('mouseover', () => {
                        layer.bindPopup(`
                        <b>Nama Kecamatan :</b> ${feature.properties.NAMOBJ}<br>
                        <b>Jumlah Inovasi :</b> ${feature.properties.jumlahInovasi}
                    `).openPopup();
                    });

                    layer.on('mouseout', () => {
                        layer.closePopup();
                    });
                }
            }
        }).addTo(map);
    }

    // Panggil fungsi untuk memuat data dan menampilkan peta
    loadMapData();
</script>
<?= $this->endSection(); ?>