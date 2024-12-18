<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Galeri Video | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url('beranda') ?>">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Video</li>
    </ol>
</div>
<div class="container-fluid mb-5">
    <h1 class="pb-4 pt-4 fw-semibold">Galeri Video</h1>
    <div class="row" id="video-container">
        <?php foreach ($galeri as $item): ?>
            <?php if ($item['tipe'] === 'video'): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card">
                        <div class="ratio ratio-16x9">
                        <iframe class="youtube-video" src="<?= $item['url'] ?>" width="560" height="315" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h4 class="text-body" onclick="goToDetail('<?= $item['url'] ?>')" style="cursor: pointer;"><?= $item['judul'] ?></h4>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <!-- pagination -->
    <div id="video-pagination" class="d-flex justify-content-center mt-4 mb-4"></div>
</div>

<script>
    // Fungsi untuk membersihkan URL YouTube
    function cleanYouTubeUrl(url) {
        var videoId;

        // Cek apakah URL mengandung query parameter
        if (url.includes('?')) {
            var urlParts = url.split('?');
            videoId = urlParts[0].replace('https://youtu.be/', '');
        } else {
            videoId = url.replace('https://youtu.be/', '');
        }

        return 'https://www.youtube.com/embed/' + videoId;
    }

    // Contoh penggunaan pada elemen iframe
    var iframes = document.querySelectorAll('iframe.youtube-video');

    iframes.forEach(function(iframe) {
        var url = iframe.getAttribute('src');
        var cleanedUrl = cleanYouTubeUrl(url);
        iframe.setAttribute('src', cleanedUrl);
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const itemsPerPage = 9; // Jumlah item per halaman
        const contentContainer = document.getElementById("video-container");
        const paginationContainer = document.getElementById("video-pagination");
        const allItems = Array.from(contentContainer.children);
        const totalItems = allItems.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        // Fungsi untuk menampilkan item sesuai halaman
        function displayPage(page) {
            // Reset konten
            contentContainer.innerHTML = "";

            // Hitung indeks awal dan akhir
            const start = (page - 1) * itemsPerPage;
            const end = Math.min(start + itemsPerPage, totalItems);

            // Tampilkan item sesuai indeks
            for (let i = start; i < end; i++) {
                contentContainer.appendChild(allItems[i]);
            }

            updatePagination(page);
        }

        // Fungsi untuk memperbarui navigasi pagination
        function updatePagination(currentPage) {
            paginationContainer.innerHTML = ""; // Bersihkan kontainer pagination

            const ul = document.createElement("ul");
            ul.className = "pagination mb-sm-0";

            // Tombol Prev
            const prevLi = document.createElement("li");
            prevLi.className = `page-item ${currentPage === 1 ? "disabled" : ""}`;
            const prevLink = document.createElement("a");
            prevLink.className = "page-link";
            prevLink.innerHTML = '<i class="mdi mdi-chevron-left"></i>';
            prevLink.href = "#";
            prevLink.addEventListener("click", (e) => {
                e.preventDefault();
                if (currentPage > 1) displayPage(currentPage - 1);
            });
            prevLi.appendChild(prevLink);
            ul.appendChild(prevLi);

            // Tombol halaman
            for (let i = 1; i <= totalPages; i++) {
                const pageLi = document.createElement("li");
                pageLi.className = `page-item ${i === currentPage ? "active" : ""}`;
                const pageLink = document.createElement("a");
                pageLink.className = "page-link";
                pageLink.textContent = i;
                pageLink.href = "#";
                pageLink.addEventListener("click", (e) => {
                    e.preventDefault();
                    displayPage(i);
                });
                pageLi.appendChild(pageLink);
                ul.appendChild(pageLi);
            }

            // Tombol Next
            const nextLi = document.createElement("li");
            nextLi.className = `page-item ${currentPage === totalPages ? "disabled" : ""}`;
            const nextLink = document.createElement("a");
            nextLink.className = "page-link";
            nextLink.innerHTML = '<i class="mdi mdi-chevron-right"></i>';
            nextLink.href = "#";
            nextLink.addEventListener("click", (e) => {
                e.preventDefault();
                if (currentPage < totalPages) displayPage(currentPage + 1);
            });
            nextLi.appendChild(nextLink);
            ul.appendChild(nextLi);

            // Tambahkan elemen pagination ke kontainer
            paginationContainer.appendChild(ul);
        }

        // Tampilkan halaman pertama saat halaman dimuat
        displayPage(1);
    });
</script>
<?= $this->endSection(); ?>