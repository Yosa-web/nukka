<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Edit Proposal | Rumah Inovasi</title><?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
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
                <div class="error" style="color: red;">
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
                                    <label for="tahun" class="col-sm-3 col-form-label">Tahun</label>
                                    <div class="col-sm-9">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="tahun"
                                            placeholder="Masukkan tahun proposal inovasi"
                                            id="tahun"
                                            value="<?= esc($inovasi['tahun']) ?>"
                                            oninput="validateYear()"
                                            required>
                                        <div id="tahun-error" style="color: red; font-size: 0.9em; display: none;">Tahun hanya boleh berupa angka.</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="kategori" required>
                                            <?php foreach ($jenis_inovasi as $jenis): ?>
                                                <option value="<?= $jenis['id_jenis_inovasi'] ?>" <?= $inovasi['kategori'] == $jenis['id_jenis_inovasi'] ? 'selected' : '' ?>>
                                                    <?= $jenis['nama_jenis'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="bentuk" class="col-sm-3 col-form-label">Bentuk</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="bentuk" required>
                                            <?php if (!empty($bentuk)): ?>
                                                <?php foreach ($bentuk as $item): ?>
                                                    <option value="<?= $item['id_bentuk'] ?>" <?= $inovasi['bentuk'] == $item['id_bentuk'] ? 'selected' : '' ?>>
                                                        <?= $item['nama_bentuk'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="" disabled selected>Tidak ada data bentuk</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="bentuk" class="col-sm-3 col-form-label">Tahapan</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="tahapan" required>
                                            <?php foreach ($tahapan as $item): ?>
                                                <option value="<?= $item['id_tahapan'] ?>" <?= $inovasi['tahapan'] == $item['id_tahapan'] ? 'selected' : '' ?>>
                                                    <?= $item['nama_tahapan'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="kecamatan" id="kecamatan" required>
                                            <?php foreach ($kecamatan as $kecamatan_item): ?>
                                                <option value="<?= $kecamatan_item['id_kecamatan'] ?>" <?= $inovasi['kecamatan'] == $kecamatan_item['id_kecamatan'] ? 'selected' : '' ?>>
                                                    <?= $kecamatan_item['nama_kecamatan'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="desa" class="col-sm-3 col-form-label">Desa</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="desa" id="desa" required>
                                            <?php if (!empty($desa)): ?>
                                                <?php foreach ($desa as $desa_item): ?>
                                                    <option value="<?= $desa_item['id_desa'] ?>" <?= $inovasi['desa'] == $desa_item['id_desa'] ? 'selected' : '' ?>>
                                                        <?= $desa_item['nama_desa'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="" disabled selected>Tidak ada data desa</option>
                                            <?php endif; ?>
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
                                        <select class="form-select" name="status" required>
                                            <option value="tertunda" <?= $inovasi['status'] == 'tertunda' ? 'selected' : '' ?>>Tertunda</option>
                                            <option value="draf" <?= $inovasi['status'] == 'draf' ? '' : '' ?>>Draf</option>
                                            <!-- <option value="terbit" <?= $inovasi['status'] == 'terbit' ? '' : '' ?>>Terbit</option> -->
                                            <!-- <option value="arsip" <?= $inovasi['status'] == 'arsip' ? '' : '' ?>>Arsip</option> -->
                                            <option value="tertolak" <?= $inovasi['status'] == 'tertolak' ? '' : '' ?>>Tertolak</option>
                                            <option value="revisi" <?= $inovasi['status'] == 'revisi' ? '' : '' ?>>Revisi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-5" id="pesan-container" style="display: none;">
                                    <label for="pesan" class="col-sm-3 col-form-label">Pesan</label>
                                    <div class="col-sm-9">
                                        <textarea name="pesan" id="pesan" class="form-control">{{ old('pesan', $inovasi->pesan) }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary w-md" onclick="window.history.back()">Batal</button>
                                            <button type="submit" class="btn btn-warning w-md ms-4">Perbarui</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#kecamatan').change(function() {
            var id_kecamatan = $(this).val();
            if (id_kecamatan) {
                $.ajax({
                    url: '/kepala/inovasi/getDesa', // Sesuaikan dengan endpoint yang akan dibuat
                    type: 'GET',
                    data: {
                        id_kecamatan: id_kecamatan
                    },
                    success: function(response) {
                        console.log(response); // Cek respons dari server
                        var desaOptions = '<option value="" disabled selected>Pilih Desa</option>';
                        $.each(response, function(index, desa) {
                            desaOptions += '<option value="' + desa.id_desa + '">' + desa.nama_desa + '</option>';
                        });
                        $('#desa').html(desaOptions); // Update dropdown Desa
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat memuat data desa');
                    }
                });
            } else {
                $('#desa').html('<option value="" disabled selected>Pilih Desa</option>');
            }
        });
    });
</script>
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
<script>
    function validateYear() {
        var input = document.getElementById('tahun');
        var errorDiv = document.getElementById('tahun-error');
        var value = input.value;

        // Cek apakah input hanya angka
        if (!/^\d*$/.test(value)) {
            errorDiv.style.display = 'block'; // Tampilkan pesan error
            input.value = value.replace(/\D/g, ''); // Hapus karakter non-angka
        } else {
            errorDiv.style.display = 'none'; // Sembunyikan pesan error jika valid
        }
    }
</script>

<?= $this->endSection(); ?>