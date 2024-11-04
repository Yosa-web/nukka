<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register Umum | Rumah Inovasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/logo_litbang.png" />
    <!-- choices css -->
    <link
        href="/assets/libs/choices.js/public/assets/styles/choices.min.css"
        rel="stylesheet"
        type="text/css" />

    <!-- Bootstrap Css -->
    <link
        href="/assets/css/bootstrap.min.css"
        id="bootstrap-style"
        rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link
        href="/assets/css/icons.min.css"
        rel="stylesheet"
        type="text/css" />
    <!-- App Css-->
    <link
        href="/assets/css/app.min.css"
        id="app-style"
        rel="stylesheet"
        type="text/css" />

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .auth-box {
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>
    <div class="container">
        <div class="auth-box">
            <div class="mb-4 mb-md-4 text-center">
                <a href="#" class="d-block auth-logo">
                    <img
                        src="/assets/images/logo_litbang.png"
                        alt=""
                        height="50" />
                </a>
            </div>
            <div class="auth-content my-auto">
                <div class="text-center">
                    <h3 class="mb-0 fw-bold">Buat Akun Baru</h3>
                    <p class="text-muted mt-2">
                        Registrasi sebagai pengguna Umum
                    </p>
                </div>
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
                <form
                    class="needs-validation mt-4 pt-2"
                    novalidate
                    onsubmit="return validateForm()"
                    action="<?= url_to('user/register') ?>" method="post">
                    <?= csrf_field() ?>
                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="floatingNameInput" class="form-label">Nama Lengkap</label>
                        <input
                            type="text"
                            class="form-control"
                            id="floatingNameInput" name="name" inputmode="text" autocomplete="name"
                            placeholder="Masukkan Nama Anda" value="<?= old('name') ?>"
                            required />
                        <div class="invalid-feedback">
                            Please Enter Name
                        </div>
                    </div>
                    <!-- NIK -->
                    <div class="mb-3">
                        <label for="floatingNikInput" class="form-label">NIK</label>
                        <input
                            type="text"
                            class="form-control"
                            id="floatingNikInput" name="NIK" inputmode="text" autocomplete="nik"
                            placeholder="Masukkan NIK Anda" value="<?= old('NIK') ?>"
                            required />
                        <div class="invalid-feedback">Please Enter NIK</div>
                    </div>
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="floatingEmailInput" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="floatingEmailInput" name="email" inputmode="email" autocomplete="email"
                            placeholder="Masukkan Email Anda" value="<?= old('email') ?>"
                            required />
                        <div class="invalid-feedback">
                            Please Enter Email
                        </div>
                    </div>
                    <!-- Telepon -->
                    <div class="mb-3">
                        <label for="floatingNoTeleponInput" class="form-label">No. Telepon</label>
                        <input
                            type="text"
                            class="form-control"
                            id="floatingNoTeleponInput" name="no_telepon" inputmode="tel" autocomplete="tel"
                            placeholder="Masukkan Nomor Telepon" value="<?= old('no_telepon') ?>"
                            required />
                        <div class="invalid-feedback">
                            Please Enter Phone Number
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="mb-4">
                        <label for="floatingPasswordInput" class="form-label">Password</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input
                                type="password"
                                class="form-control"
                                id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password"
                                placeholder="Masukkan Kata Sandi"
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
                    <!-- re-password -->
                    <div class="mb-4">
                        <label for="floatingPasswordConfirmInput" class="form-label">Konfirmasi Password</label>
                        <div class="input-group auth-pass-inputgroup">
                            <input
                                type="password"
                                class="form-control"
                                id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password"
                                placeholder="Masukkan kembali kata sandi"
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
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="remember-check"
                                    required />
                                <label
                                    class="form-check-label text-muted fw-normal"
                                    for="remember-check">
                                    Saya setuju dengan
                                    <a href="#" class="text-primary">Syarat dan Ketentuan</a>
                                    yang berlaku
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button
                            class="btn btn-primary w-100 waves-effect waves-light"
                            type="submit">
                            <?= lang('Auth.register') ?>
                        </button>
                    </div>
                </form>

                <div class="mt-4 text-center">
                    <p class="mb-0">
                        Sudah punya akun?
                        <a
                            href="<?= url_to('login') ?>"
                            class="text-primary fw-semibold">
                            <?= lang('Auth.login') ?>
                        </a>
                    </p>
                </div>
            </div>
            <div class="text-muted mt-4 mt-md-5 text-center">
                <p class="mb-0">
                    Balitbang Pesawaran ©
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    All Right Reserved.
                </p>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="/assets/libs/jquery/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <!-- pace js -->
    <script src="/assets/libs/pace-js/pace.min.js"></script>
    <!-- password addon init -->
    <script src="/assets/js/pages/pass-addon.init.js"></script>
    <!-- validation init -->
    <script src="/assets/js/pages/validation.init.js"></script>
    <!-- form init js -->
    <script src="/assets/js/pages/form-advanced.init.js"></script>
    <!-- choices js -->
    <script src="/assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>

</html>