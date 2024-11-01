<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Edit Pegawai OPD | Rumah Inovasi</title><?= $this->endSection() ?>
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
                            Edit Pegawai
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Data Pengguna</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/superadmin/user/list/pegawai">Pegawai</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit Pegawai
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <?php if (session('error') !== null) : ?>
                <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
            <?php elseif (session('errors') !== null) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (is_array(session('errors'))) : ?>
                        <?php foreach (session('errors') as $error) : ?>
                            <?= $error ?>
                            <br>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?= session('errors') ?>
                    <?php endif ?>
                </div>
            <?php endif ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="/superadmin/user/update/<?= $user->id ?>" method="post">
                                <?= csrf_field() ?>
                                <!-- Nama -->
                                <div class="row mb-3">
                                    <label for="floatingNameInput" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="floatingNameInput" name="name" inputmode="text" autocomplete="name" placeholder="Masukkan Nama Lengkap" value="<?= old('name', $user->name) ?>" required>
                                    </div>
                                </div>
                                <!-- OPD -->
                                <div class="row mb-3">
                                    <label for="floatingIdOpdInput" class="col-sm-3 col-form-label">OPD</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select" id="floatingIdOpdInput" name="id_opd" required>
                                            <option value="" disabled>Pilih OPD</option>
                                            <?php foreach ($opd as $item): ?>
                                                <option value="<?= esc($item->id_opd) ?>" <?= old('id_opd', $user->id_opd) == esc($item->id_opd) ? 'selected' : '' ?>><?= esc($item->nama_opd) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- NIP -->
                                <div class="row mb-3">
                                    <label for="floatingNipInput" class="col-sm-3 col-form-label">NIP</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="floatingNipInput" placeholder="Masukkan NIP" name="NIP" inputmode="text" autocomplete="nip"
                                            value="<?= old('NIP', $user->NIP) ?>" required>
                                    </div>
                                </div>
                                <!-- Telepon -->
                                <div class="row mb-3">
                                    <label for="floatingNoTeleponInput" class="col-sm-3 col-form-label">No. Telepon</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="floatingNoTeleponInput" placeholder="Masukkan no. telp" name="no_telepon" inputmode="tel" autocomplete="tel"
                                            value="<?= old('no_telepon', $user->no_telepon) ?>" required>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="row mb-5">
                                    <label for="floatingEmailInput" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="floatingEmailInput" placeholder="Masukkan email" name="email" inputmode="email" autocomplete="email"
                                            value="<?= old('email', $user->email) ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='/superadmin/user/list/pegawai'">Batal</button>
                                            <button type="submit" class="btn btn-primary w-md ms-4">Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>