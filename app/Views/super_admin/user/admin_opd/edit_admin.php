<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Edit Admin OPD | Rumah Inovasi</title><?= $this->endSection() ?>
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
                            Edit Admin
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Data Pengguna</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/superadmin/user/list/admin">Admin</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Edit Admin
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
            class="form-select" id="floatingIdOpdInput" name="id_opd_disabled" disabled>
            <option value="" disabled>Pilih OPD</option>
            <?php foreach ($opd as $item): ?>
                <option value="<?= esc($item->id_opd) ?>" <?= old('id_opd', $user->id_opd) == esc($item->id_opd) ? 'selected' : '' ?>><?= esc($item->nama_opd) ?></option>
            <?php endforeach; ?>
        </select>
        <!-- Input hidden untuk menyimpan nilai id_opd -->
        <input type="hidden" name="id_opd" value="<?= esc($user->id_opd) ?>">
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
                                <!-- Status -->
                                <div class="row mb-3">
                                    <label for="floatingStatusInput" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select name="active" id="floatingStatusInput" class="form-select <?= isset(session()->getFlashdata('errors')['active']) ? 'is-invalid' : '' ?>">
                                            <option value="1" <?= old('active') == '1' ? 'selected' : '' ?>>Aktif</option>
                                            <option value="0" <?= old('active') == '0' ? 'selected' : '' ?>>Non Aktif</option>
                                        </select>
                                    </div>
                                    <div id="status_error" class="error"><?= isset(session()->getFlashdata('errors')['active']) ? session()->getFlashdata('errors')['active'] : '' ?></div>
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
                                            <button type="button" class="btn btn-secondary w-md" onclick="window.location.href='/superadmin/user/list/admin'">Batal</button>
                                            <button type="submit" class="btn btn-warning update w-md ms-4">Perbarui</button>
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
<script>
    // Ambil elemen yang diperlukan
    const passwordInput = document.getElementById('floatingPasswordInput');
    const confirmPasswordInput = document.getElementById('floatingPasswordConfirmInput');
    const updateButton = document.querySelector('.btn-warning.update'); // Tombol "Perbarui"

    // Fungsi untuk memvalidasi input password
    function validatePassword() {
        const passwordErrorDiv = document.getElementById('password-error');
        const confirmPasswordErrorDiv = document.getElementById('repassword-error');
        let isValid = true;

        // Validasi password tidak diawali dengan spasi
        if (passwordInput.value.startsWith(' ')) {
            passwordErrorDiv.textContent = 'Password tidak boleh diawali dengan spasi.';
            passwordInput.classList.add('is-invalid');
            isValid = false;
        } else {
            passwordErrorDiv.textContent = '';
            passwordInput.classList.remove('is-invalid');
        }

        // Validasi apakah konfirmasi password sesuai
        if (confirmPasswordInput.value && confirmPasswordInput.value !== passwordInput.value) {
            confirmPasswordErrorDiv.textContent = 'Password dan Konfirmasi Password harus sama.';
            confirmPasswordInput.classList.add('is-invalid');
            isValid = false;
        } else {
            confirmPasswordErrorDiv.textContent = '';
            confirmPasswordInput.classList.remove('is-invalid');
        }

        // Nonaktifkan tombol "Perbarui" jika ada error
        updateButton.disabled = !isValid;
    }

    // Tambahkan event listener pada input password dan konfirmasi password
    passwordInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validatePassword);

    // Pastikan tombol "Perbarui" aktif jika password tidak diisi (password tidak wajib)
    document.addEventListener('DOMContentLoaded', function() {
        validatePassword(); // Panggil saat halaman dimuat
    });
</script>
<?= $this->endSection(); ?>