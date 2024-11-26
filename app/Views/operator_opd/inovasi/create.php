<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Tambah Proposal | Rumah Inovasi</title><?= $this->endSection() ?>
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
                            Tambah Proposal
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Data Inovasi</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('operator/inovasi/filter') ?>">Daftar Proposal</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Tambah Proposal
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php if (session()->get('errors')): ?>
                <div style="color: red;">
                    <?= implode('<br>', session()->get('errors')) ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="/operator/inovasi/store" method="post" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="judul" class="col-sm-3 col-form-label">Judul Inovasi</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="judul" placeholder="Masukkan judul proposal inovasi" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="5" placeholder="Masukkan deskripsi inovasi" name="deskripsi" required></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select" name="kategori" required>
                                            <option value="" disabled selected>
                                                Pilih Kategori
                                            </option>
                                            <?php foreach ($jenis_inovasi as $jenis): ?>
                                                <option value="<?= $jenis['id_jenis_inovasi'] ?>"><?= $jenis['nama_jenis'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="id_opd" class="col-sm-3 col-form-label">OPD</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select" name="id_opd" required>
                                            <option value="" disabled selected>
                                                Pilih OPD
                                            </option>
                                            <?php foreach ($opd as $row): ?>
                                                <option value="<?= $row->id_opd ?>"><?= $row->nama_opd ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="kecamatan" id="kecamatan" required>
                                            <option value="" disabled selected>Pilih Kecamatan</option>
                                            <option value="GEDONG TATAAN" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'GEDONG TATAAN') ? 'selected' : '' ?>>Gedong Tataan</option>
                                            <option value="KEDONDONG" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'KEDONDONG') ? 'selected' : '' ?>>Kedondong</option>
                                            <option value="MARGA PUNDUH" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'MARGA PUNDUH') ? 'selected' : '' ?>>Marga Punduh</option>
                                            <option value="NEGERI KATON" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'NEGERI KATON') ? 'selected' : '' ?>>Negeri Katon</option>
                                            <option value="PADANG CERMIN" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'PADANG CERMIN') ? 'selected' : '' ?>>Padang Cermin</option>
                                            <option value="PUNDUH PIDADA" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'PUNDUH PIDADA') ? 'selected' : '' ?>>Punduh Pidada</option>
                                            <option value="TEGINENENG" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'TEGINENENG') ? 'selected' : '' ?>>Tegineneng</option>
                                            <option value="TELUK PANDAN" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'TELUK PANDAN') ? 'selected' : '' ?>>Teluk Pandan</option>
                                            <option value="WAY LIMA" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'WAY LIMA') ? 'selected' : '' ?>>Way Lima</option>
                                            <option value="WAY KHILAU" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'WAY KHILAU') ? 'selected' : '' ?>>Way Khilau</option>
                                            <option value="WAY RATAI" <?= (isset($inovasi['kecamatan']) && $inovasi['kecamatan'] == 'WAY RATAI') ? 'selected' : '' ?>>Way Ratai</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <label for="url_file" class="col-sm-3 col-form-label">Upload File Proposal</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="url_file"">
                                    </div>
                                </div>

                                <div class=" row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='<?= base_url('operator/inovasi/filter') ?>'">Batal</button>
                                            <button type="submit" class="btn btn-primary w-md ms-4">Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Alert untuk notifikasi sukses atau error -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>