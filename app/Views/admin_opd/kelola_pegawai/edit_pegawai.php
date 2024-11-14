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
                        <p>User Group Debug: <?= isset($user->group) ? esc($user->group) : 'Group tidak ditemukan' ?></p>
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
                            <form action="/adminopd/pegawai/update" method="post" >
                                <?= csrf_field() ?>
                                <!-- Input hidden untuk ID Pegawai -->
                                <input type="hidden" name="id" value="<?= $user->id ?>">
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
                                        <label class="form-label"><?= esc($opd->nama_opd) ?></label>
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
                                <!-- Jabatan -->
                                <div class="row mb-3">
                                    <label for="floatingGroupInput" class="col-sm-3 col-form-label">Jabatan</label>
                                    <div class="col-sm-9">
                                    <select name="group" id="floatingGroupInput" class="form-select <?= isset(session()->getFlashdata('errors')['group']) ? 'is-invalid' : '' ?>" required>
                                        <option value="" disabled <?= !$user->group ? 'selected' : '' ?>>Pilih Jabatan</option>
                                        <option value="kepala-opd" <?= (old('group') ?? $user->group) === 'kepala-opd' ? 'selected' : '' ?>>Kepala OPD</option>
                                        <option value="sekertaris-opd" <?= (old('group') ?? $user->group) === 'sekertaris-opd' ? 'selected' : '' ?>>Sekretaris OPD</option>
                                        <option value="operator" <?= (old('group') ?? $user->group) === 'operator' ? 'selected' : '' ?>>Operator</option>
                                    </select>
                                        <?php if (isset(session()->getFlashdata('errors')['group'])): ?>
                                            <div class="invalid-feedback">
                                                <?= session()->getFlashdata('errors')['group'] ?>
                                            </div>
                                        <?php endif; ?>
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
                                <!-- Status -->
                                <div class="row mb-3">
                                    <label for="floatingStatusInput" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select name="active" id="floatingStatusInput" class="form-select <?= isset(session()->getFlashdata('errors')['active']) ? 'is-invalid' : '' ?>">
                                            <option value="1" <?= (old('active', $user->active) == '1') ? 'selected' : '' ?>>Aktif</option>
                                            <option value="0" <?= (old('active', $user->active) == '0') ? 'selected' : '' ?>>Non Aktif</option>
                                        </select>
                                    </div>
                                    <div id="status_error" class="error">
                                        <?= isset(session()->getFlashdata('errors')['active']) ? session()->getFlashdata('errors')['active'] : '' ?>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="row mb-3">
                                    <label for="floatingEmailInput" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="floatingEmailInput" placeholder="Masukkan email" name="email" inputmode="email" autocomplete="email"
                                            value="<?= old('email', $user->email) ?>" required>
                                    </div>
                                </div>
                                <!-- password -->
                                <div class="row mb-3">
                                    <label for="floatingPasswordInput" class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <div class="input-group auth-pass-inputgroup">
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="floatingPasswordInput"
                                                name="password"
                                                inputmode="text"
                                                autocomplete="new-password"
                                                placeholder="Masukkan password baru jika ingin mengubah"
                                                aria-label="Password"
                                                aria-describedby="password-addon" />
                                            <button
                                                class="btn btn-light shadow-none ms-0"
                                                type="button"
                                                id="password-addon">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </button>
                                            <div class="invalid-feedback" id="password-error"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- re-password -->
                                <div class="row mb-5">
                                    <label for="floatingPasswordConfirmInput" class="col-sm-3 col-form-label">Konfirmasi Password</label>
                                    <div class="col-sm-9">
                                        <div class="input-group auth-pass-inputgroup">
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="floatingPasswordConfirmInput"
                                                name="password_confirm"
                                                inputmode="text"
                                                autocomplete="new-password"
                                                placeholder="Masukkan kembali password baru"
                                                aria-label="Re-Password"
                                                aria-describedby="repassword-addon" />
                                            <button
                                                class="btn btn-light shadow-none ms-0"
                                                type="button"
                                                id="repassword-addon">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </button>
                                            <div class="invalid-feedback" id="repassword-error"></div>
                                        </div>
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

<!-- password addon init -->
<script src="/assets/js/pages/pass-addon.init.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("password-addon").addEventListener("click", function() {
            const passwordInput = document.getElementById("floatingPasswordInput");
            const icon = this.querySelector("i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("mdi-eye-outline");
                icon.classList.add("mdi-eye-off-outline");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("mdi-eye-off-outline");
                icon.classList.add("mdi-eye-outline");
            }
        });

        document.getElementById("repassword-addon").addEventListener("click", function() {
            const confirmPasswordInput = document.getElementById("floatingPasswordConfirmInput");
            const icon = this.querySelector("i");

            if (confirmPasswordInput.type === "password") {
                confirmPasswordInput.type = "text";
                icon.classList.remove("mdi-eye-outline");
                icon.classList.add("mdi-eye-off-outline");
            } else {
                confirmPasswordInput.type = "password";
                icon.classList.remove("mdi-eye-off-outline");
                icon.classList.add("mdi-eye-outline");
            }
        });
    });
</script>
<?= $this->endSection(); ?>