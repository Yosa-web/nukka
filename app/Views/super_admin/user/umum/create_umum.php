<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Tambah Pengguna Umum | Rumah Inovasi</title><?= $this->endSection() ?>
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
                            Tambah Pengguna Umum
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Data Pengguna</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/superadmin/user/list/umum">Umum</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Tambah Pengguna Umum
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
                            <form action="<?= url_to('superadmin/userumum/store') ?>" method="post">
                                <?= csrf_field() ?>
                                <!-- Nama -->
                                <div class="row mb-3">
                                    <label for="floatingNameInput" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="floatingNameInput" name="name" inputmode="text" autocomplete="name" placeholder="Masukkan nama pengguna" value="<?= old('name') ?>" required>
                                    </div>
                                </div>
                                <!-- NIK -->
                                <div class="row mb-3">
                                    <label for="floatingNikInput" class="col-sm-3 col-form-label">NIK</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="floatingNikInput" name="NIK" inputmode="text" autocomplete="nik" placeholder="Masukkan NIK pengguna" value="<?= old('NIK') ?>" required>
                                    </div>
                                </div>
                                <!-- Telepon -->
                                <div class="row mb-3">
                                    <label for="floatingNoTeleponInput" class="col-sm-3 col-form-label">No. Telepon</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="floatingNoTeleponInput" name="no_telepon" inputmode="tel" autocomplete="tel" placeholder="Masukkan no. telepon" value="<?= old('no_telepon') ?>" required>
                                    </div>
                                </div>
                                <!-- group -->
                                <div class="row mb-3">
                                    <label for="floatingGroupInput" class="col-sm-3 col-form-label">Group</label>
                                    <div class="col-sm-9">
                                        <select
                                            class="form-select" id="floatingGroupInput" name="group" inputmode="text" autocomplete="group" value="<?= old('group') ?>" required>
                                            <option value="user">
                                                User
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="row mb-5">
                                    <label for="floatingEmailInput" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="Masukkan Email Pengguna" value="<?= old('email') ?>" required>
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
                                                id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password"
                                                placeholder="Masukkan kata sandi"
                                                aria-label="Password"
                                                aria-describedby="password-addon"
                                                required />
                                            <button
                                                class="btn btn-light shadow-none ms-0"
                                                type="button"
                                                id="password-addon">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </button>
                                            <div
                                                class="invalid-feedback"
                                                id="password-error">
                                            </div>
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
                                                id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password"
                                                placeholder="Masukkan kembali kata sandi"
                                                aria-label="Re-Password"
                                                aria-describedby="repassword-addon"
                                                required />
                                            <button
                                                class="btn btn-light shadow-none ms-0"
                                                type="button"
                                                id="repassword-addon">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </button>
                                            <div
                                                class="invalid-feedback"
                                                id="repassword-error">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='/superadmin/user/list/umum'">Batal</button>
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
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("password-addon").addEventListener("click", function () {
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

        document.getElementById("repassword-addon").addEventListener("click", function () {
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