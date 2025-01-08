<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Galeri Foto | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url('beranda') ?>">Beranda</a>
        </li>
        <li class="breadcrumb-item active">Foto</li>
    </ol>
</div>
<style>
    .card-img-overlay {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .card-img:hover {
        filter: brightness(75%);
    }

    .card-img-overlay:hover {
        opacity: 1;
        cursor: pointer;
    }

    .card-img img {
        width: 100%;
        height: auto;
        /* Ukuran gambar mengikuti proporsi asli */
        max-width: 100%;
    }
</style>
<div class="container-fluid mb-5">
    <h1 class="pb-4 pt-4 fw-semibold">Galeri Foto</h1>
    <div class="row" id="gambar-container">
        <?php foreach ($galeri as $item): ?>
            <?php if ($item['tipe'] === 'image'): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card">
                        <img class="card-img img-fluid" src="<?= base_url(esc($item['url'])) ?>" alt="galeri image" class="myGambar">
                        <div class="card-img-overlay">
                            <div class="row">
                                <div class="col-9">
                                    <h4 class="card-title text-white captionGambar"><?= $item['judul'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <!-- pagination -->
    <div id="gambar-pagination" class="d-flex justify-content-center mt-4 mb-4"></div>
</div>

<!-- Modal for full-size image -->
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const itemsPerPage = 9; // Jumlah item per halaman
        const contentContainer = document.getElementById("gambar-container");
        const paginationContainer = document.getElementById("gambar-pagination");
        const allItems = Array.from(contentContainer.children);
        const totalItems = allItems.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        function displayPage(page) {
            contentContainer.innerHTML = "";
            const start = (page - 1) * itemsPerPage;
            const end = Math.min(start + itemsPerPage, totalItems);

            for (let i = start; i < end; i++) {
                contentContainer.appendChild(allItems[i]);
            }

            updatePagination(page);
        }

        function updatePagination(currentPage) {
            paginationContainer.innerHTML = "";
            const ul = document.createElement("ul");
            ul.className = "pagination mb-sm-0";

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

            paginationContainer.appendChild(ul);
        }

        displayPage(1);
    });
</script>

<?= $this->endSection(); ?>