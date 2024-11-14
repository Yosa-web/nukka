<?= $this->extend('layout/master_landing_page'); ?>
<?= $this->section('title') ?><title>Database Inovasi | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="page-title-left">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="beranda.html">Beranda</a>
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
                                    style="width: 280px">
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
                            <tr>
                                <td class="text-center">1.</td>
                                <td>
                                    Aksi Konsumen Cerdas Ayo Mengadu
                                    (SI KOMENG)
                                </td>
                                <td>
                                    Dinas Komunikasi dan Informatika
                                    Pesawaran
                                </td>
                                <td class="text-center">2008</td>
                                <td class="text-center">
                                    <a
                                        href="#"
                                        class="btn btn-outline-primary btn-sm mb-3"
                                        title="Unduh">
                                        <i
                                            class="fas fa-download"></i>
                                    </a>
                                    <a
                                        class="btn btn-outline-secondary btn-sm ms-2 mb-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModalScrollable"
                                        title="Detail"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">2.</td>
                                <td>
                                    Aplikasi JDIH Kaltim Berbasis
                                    Android
                                </td>
                                <td>
                                    Badan Hukum Kabupaten Pesawaran
                                </td>
                                <td class="text-center">2011</td>
                                <td class="text-center">
                                    <a
                                        href="#"
                                        class="btn btn-outline-primary btn-sm mb-3"
                                        title="Unduh">
                                        <i
                                            class="fas fa-download"></i>
                                    </a>
                                    <a
                                        class="btn btn-outline-secondary btn-sm ms-2 mb-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModalScrollable"
                                        title="Detail"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">3.</td>
                                <td>
                                    Aplikasi Simata Laut Kaltim
                                    (Sistem Informasi Tata Ruang
                                    Laut Kaltim)
                                </td>
                                <td>
                                    Dinas Komunikasi dan Informatika
                                    Pesawaran
                                </td>
                                <td class="text-center">2012</td>
                                <td class="text-center">
                                    <a
                                        href="#"
                                        class="btn btn-outline-primary btn-sm mb-3"
                                        title="Unduh">
                                        <i
                                            class="fas fa-download"></i>
                                    </a>
                                    <a
                                        class="btn btn-outline-secondary btn-sm ms-2 mb-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModalScrollable"
                                        title="Detail"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">4.</td>
                                <td>
                                    CAP JEMPOL (lanCAr Posyandu
                                    dengan menJEMput Pakai Ojek
                                    Lansia)
                                </td>
                                <td>
                                    Dinas Komunikasi dan Informatika
                                    Pesawaran
                                </td>
                                <td class="text-center">2012</td>
                                <td class="text-center">
                                    <a
                                        href="#"
                                        class="btn btn-outline-primary btn-sm mb-3"
                                        title="Unduh">
                                        <i
                                            class="fas fa-download"></i>
                                    </a>
                                    <a
                                        class="btn btn-outline-secondary btn-sm ms-2 mb-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModalScrollable"
                                        title="Detail"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>