<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Edit Proposal | Rumah Inovasi</title><?= $this->endSection() ?>
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
                            Edit Proposal
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Data Inovasi</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('kepala/inovasi/filter') ?>">Daftar Proposal</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit Proposal
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php if (session()->get('errors')): ?>
                <div class="error">
                    <?= implode('<br>', session()->get('errors')) ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="/kepala/inovasi/update/<?= $inovasi['id_inovasi'] ?>" method="post" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="judul" class="col-sm-3 col-form-label">Judul Inovasi</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="judul" value="<?= esc($inovasi['judul']); ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="deskripsi" required rows="5"><?= esc($inovasi['deskripsi']); ?></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select" name="kategori" required>
                                            <?php foreach ($jenis_inovasi as $jenis): ?>
                                                <option value="<?= $jenis['id_jenis_inovasi'] ?>" <?= $inovasi['kategori'] == $jenis['id_jenis_inovasi'] ? 'selected' : '' ?>>
                                                    <?= $jenis['nama_jenis'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="id_opd" class="col-sm-3 col-form-label">OPD</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select" name="id_opd" required>
                                            <?php foreach ($opd as $row): ?>
                                                <option value="<?= $row->id_opd ?>" <?= $inovasi['id_opd'] == $row->id_opd ? 'selected' : '' ?>>
                                                    <?= $row->nama_opd ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select" name="kecamatan" id="kecamatan" required>
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
                                <div class="row mb-3">
                                    <label for="url_file" class="col-sm-3 col-form-label">File Proposal</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="url_file">
                                        <?php if (!empty($inovasi['url_file'])): ?>
                                            <p>File Saat Ini: <a href="<?= base_url($inovasi['url_file']) ?>" target="_blank">Lihat File</a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select" name="status" required>
                                            <option value="draf" <?= $inovasi['status'] == 'draf' ? 'selected' : '' ?>>Draf</option>
                                            <option value="terbit" <?= $inovasi['status'] == 'terbit' ? 'selected' : '' ?>>Terbit</option>
                                            <option value="arsip" <?= $inovasi['status'] == 'arsip' ? 'selected' : '' ?>>Arsip</option>
                                            <option value="tertunda" <?= $inovasi['status'] == 'tertunda' ? 'selected' : '' ?>>Tertunda</option>
                                            <option value="tertolak" <?= $inovasi['status'] == 'tertolak' ? 'selected' : '' ?>>Tertolak</option>
                                            <option value="revisi" <?= $inovasi['status'] == 'revisi' ? 'selected' : '' ?>>Revisi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-5" id="pesan-container" style="display: none;">
                                    <label for="pesan" class="col-sm-3 col-form-label">Pesan</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="pesan" id="pesan" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='<?= base_url('kepala/inovasi/filter') ?>'">Batal</button>
                                            <button type="submit" class="btn btn-warning w-md ms-4">Perbarui</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    const statusSelect = document.querySelector('[name="status"]');
    const pesanContainer = document.getElementById('pesan-container');

    statusSelect.addEventListener('change', function() {
        const selectedStatus = statusSelect.value;
        if (['tertolak', 'revisi', 'arsip'].includes(selectedStatus)) {
            pesanContainer.style.display = 'flex';
        } else {
            pesanContainer.style.display = 'none';
            document.getElementById('pesan').value = ''; // Reset pesan jika tidak dibutuhkan
        }
    });

    // Trigger perubahan saat halaman dimuat (jika status sudah terpilih)
    window.addEventListener('DOMContentLoaded', function() {
        statusSelect.dispatchEvent(new Event('change'));
    });
</script>
<?= $this->endSection(); ?>