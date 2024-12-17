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
                                    <a href="<?= base_url('sekertaris/inovasi/filter') ?>">Daftar Proposal</a>
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
                            <form action="/sekertaris/inovasi/store" method="post" enctype="multipart/form-data">
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
                                    <label for="tahun" class="col-sm-3 col-form-label">Tahun</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="tahun" placeholder="Masukkan tahun proposal inovasi" required oninput="validateYear(this)">
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
                                    <label for="kategori" class="col-sm-3 col-form-label">Bentuk</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select" name="bentuk" required>
                                            <option value="" disabled selected>
                                                Pilih Bentuk
                                            </option>
                                            <?php foreach ($bentuk as $bentuk): ?>
                                                <option value="<?= $bentuk['id_bentuk'] ?>"><?= $bentuk['nama_bentuk'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="kategori" class="col-sm-3 col-form-label">Tahapan</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select" name="tahapan" required>
                                            <option value="" disabled selected>
                                                Pilih Tahapan
                                            </option>
                                            <?php foreach ($tahapan as $tahapan): ?>
                                                <option value="<?= $tahapan['id_tahapan'] ?>"><?= $tahapan['nama_tahapan'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="id_opd" class="col-sm-3 col-form-label">Kecamatan</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="kecamatan" id="kecamatan" required>
                                            <option value="" disabled selected>Pilih Kecamatan</option>
                                            <?php if (!empty($kecamatan)): ?>
                                                <?php foreach ($kecamatan as $kecamatan_item): ?>
                                                    <option value="<?= $kecamatan_item['id_kecamatan'] ?>"><?= $kecamatan_item['nama_kecamatan'] ?></option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="" disabled>Tidak ada data kecamatan</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="desa" class="col-sm-3 col-form-label">Desa</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" name="desa" id="desa" required>
                                            <option value="" disabled selected>Pilih Desa</option>
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
                                                <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='<?= base_url('sekertaris/inovasi/filter') ?>'">Batal</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#kecamatan').change(function() {
            var id_kecamatan = $(this).val();
            if (id_kecamatan) {
                $.ajax({
                    url: '/sekertaris/inovasi/getDesa', // Sesuaikan dengan endpoint yang akan dibuat
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
    function validateYear(input) {
        // Hanya menerima angka
        var regex = /^[0-9]+$/;
        if (!regex.test(input.value)) {
            // Mengosongkan input jika tidak berupa angka
            input.setCustomValidity("Tahun hanya bisa berupa angka.");
            input.reportValidity();
        } else {
            // Menghapus validasi jika input berupa angka
            input.setCustomValidity("");
        }
    }
</script>

<?= $this->endSection(); ?>