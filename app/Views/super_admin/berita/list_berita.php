<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Kelola Berita | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0">
                            Kelola Berita
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Kelola Konten</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Kelola Berita
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .img-fluid {
                    aspect-ratio: 3 / 2;
                    width: 100%;
                }

                .img-fluid img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
            </style>
            <?php if (session()->getFlashdata('errors') || session()->getFlashdata('success')): ?>
                <div class="alert alert-dismissible fade show <?= session()->getFlashdata('errors') ? 'alert-danger' : 'alert-success' ?>">
                    <?= session()->getFlashdata('errors') ?: session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="row align-items-center">
                <div class="col-md-6">
                </div>

                <div class="col-md-6">
                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                        <div>
                            <a href="/superadmin/berita/create" class="btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-plus label-icon"></i>Tambah Berita</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="berita-container">
                <?php foreach ($berita as $item): ?>
                    <div class="col-xl-4 col-sm-6">
                        <div class="card">
                            <div class="">
                                <?php if ($item['gambar']): ?>
                                    <img src="<?= base_url($item['gambar']) ?>" alt="Gambar Berita" class="img-fluid">
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <p class="text-muted mb-2"><?= date('d M Y', strtotime($item['tanggal_post'])) ?>
                                        </p>
                                    </div>
                                    <div class="col-3 d-flex justify-content-end">
                                        <div>
                                            <span class="badge rounded-pill <?= $item['status'] === 'published' ? 'bg-success' : ($item['status'] === 'archive' ? 'bg-secondary' : 'bg-warning') ?>"><?= ucfirst($item['status']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <h5 class=""><a href="<?= base_url('berita/show/detail/' . $item['slug']) ?>" class="text-body"><?= substr($item['judul'], 0, 70) . '...' ?></a></h5>
                                <p class="mb-0 font-size-15"><?= substr($item['isi'], 0, 150) . '...' ?></p>
                                <div class="row mt-3">
                                    <div class="col-8">
                                        <a href="<?= base_url('berita/show/detail/' . $item['slug']) ?>" class="align-middle font-size-15">Lihat Detail <i class="mdi mdi-chevron-right"></i></a>
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <a href="<?= base_url('superadmin/berita/' . $item['slug'] . '/edit') ?>" class="btn btn-outline-warning btn-sm edit" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form id="delete-form-<?= $item['id_berita'] ?>" action="<?= base_url('superadmin/berita') ?>" method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="id_berita" value="<?= $item['id_berita'] ?>">
                                            <?= csrf_field() ?>
                                            <button type="button" class="btn btn-outline-danger btn-sm delete ms-2" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="berita-pagination" class="d-flex justify-content-center mt-4 mb-4"></div>
        </div>
    </div>
</div>

<!-- Sweet alert init js-->
<script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll(".delete").forEach(function(button) {
        button.addEventListener("click", function(event) {
            event.preventDefault();

            const form = this.closest("form");
            const formData = new FormData(form);

            Swal.fire({
                title: "Konfirmasi hapus?",
                text: "Anda yakin ingin menghapus data ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#2ab57d",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const itemsPerPage = 9; // Jumlah item per halaman
        const contentContainer = document.getElementById("berita-container");
        const paginationContainer = document.getElementById("berita-pagination");
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