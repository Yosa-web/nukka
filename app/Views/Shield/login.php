<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Rumah Inovasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/logo_litbang.png" />
    <!-- choices css -->
    <link href="/assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

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
            height: 100vh;
        }

        .auth-box {
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }

        .welcome {
            font-size: 15px;
        }
    </style>
</head>

<body>
    <?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>
    <div class="container">
        <div class="auth-box">
            <div class="mb-4 mb-md-5 text-center">
                <a href="#" class="d-block auth-logo">
                    <img
                        src="/assets/images/logo_litbang.png"
                        alt=""
                        height="50" />
                </a>
            </div>
            <div class="auth-content my-auto">
                <div class="text-center">
                    <h3 class="mb-0 fw-bold">LOGIN</h3>
                    <p class="mt-2 welcome fw-semibold">
                        Hi, Selamat Datang di
                        <span class="text-primary">#RumahInovasi</span>
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

                <?php if (session('message') !== null) : ?>
                    <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                <?php endif ?>

                <form
                    class="needs-validation mt-4 pt-2"
                    novalidate
                    action="<?= url_to('login') ?>" method="post">
                    <?= csrf_field() ?>
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="floatingEmailInput" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="floatingEmailInput" name="email" inputmode="email" autocomplete="email"
                            placeholder="Masukkan email anda" value="<?= old('email') ?>"
                            required />
                        <div class="invalid-feedback">
                            Please Enter Email
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="mb-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <label for="floatingPasswordInput" class="form-label">Kata Sandi</label>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="">
                                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                                        <a href="<?= url_to('magic-link') ?>" class="text-muted">Lupa kata sandi?</a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                        <div class="input-group auth-pass-inputgroup">
                            <input
                                type="password"
                                class="form-control"
                                placeholder="Masukkan kata sandi"
                                id="floatingPasswordInput" name="password" inputmode="text" autocomplete="current-password"
                                required />
                            <button
                                class="btn btn-light shadow-none ms-0"
                                type="button"
                                id="password-addon">
                                <i class="mdi mdi-eye-outline"></i>
                            </button>
                            <div class="invalid-feedback">
                                Please Enter Password
                            </div>
                        </div>
                    </div>
                    <!-- remember me -->
                    <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox" name="remember"
                                        id="remember-check" <?php if (old('remember')): ?> checked<?php endif ?> />
                                    <label
                                        class="form-check-label"
                                        for="remember-check">
                                        Ingat Saya
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <button
                            class="btn btn-primary w-100 waves-effect waves-light"
                            type="submit">
                            Login
                        </button>
                    </div>

                </form>
                <div class="mt-4 text-center">
                    <?php if (setting('Auth.allowRegistration')) : ?>
                        <p class="mb-0">
                            Belum punya akun?
                            <a
                                href="#"
                                class="text-primary fw-semibold"
                                id="custom-alert">
                                Daftar
                            </a>
                        </p>
                    <?php endif ?>
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
    <!-- Sweet Alerts js -->
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <!-- Sweet alert init js-->
    <script src="/assets/js/pages/sweetalert.init.js"></script>
    <!-- form init js -->
    <script src="/assets/js/pages/form-advanced.init.js"></script>
    <!-- choices js -->
    <script src="/assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
			document
				.getElementById("custom-alert")
				.addEventListener("click", function () {
					Swal.fire({
						title: "Pilih Role",
						icon: "question",
						html: "Buat akun sebagai?",
						showCloseButton: true,
						showCancelButton: true,
						confirmButtonClass: "btn btn-primary",
						cancelButtonClass: "btn btn-info ms-1",
						confirmButtonColor: "#5156be",
						cancelButtonColor: "#4ba6ef",
						confirmButtonText: "Admin OPD",
						cancelButtonText: "Umum",
					}).then((result) => {
						if (result.isConfirmed) {
							window.location.href = "<?= url_to('register') ?>";
						} else if (
							result.dismiss === Swal.DismissReason.cancel
						) {
							window.location.href = "<?= url_to('user/register') ?>";
						}
					});
				});
		</script>
</body>

</html>