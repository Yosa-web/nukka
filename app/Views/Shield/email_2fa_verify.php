<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Verifikasi OTP | Rumah Inovasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/uploads/images/optionweb/logo.png" />

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

        .two-step {
            width: 50px;
            height: 50px;
            font-size: 20px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        @media (max-width: 576px) {
            .two-step {
                width: 38px;
                height: 38px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="auth-box">
            <div class="mb-4 mb-md-5 text-center">
                <a href="#" class="d-block auth-logo">
                    <img
                        src="/assets/uploads/images/optionweb/logo.png"
                        alt=""
                        height="50" />
                </a>
            </div>
            <div class="auth-content my-auto">
                <div class="text-center">
                    <div class="avatar-lg mx-auto">
                        <div class="avatar-title rounded-circle bg-light">
                            <i
                                class="bx bxs-envelope h2 mb-0 text-primary"></i>
                        </div>
                    </div>
                    <div class="p-2 mt-4">
                        <h3 class="fw-bold">Verifikasi Email Anda</h3>
                        <p class="text-muted mb-3">
                            Masukkan 6 digit kode yang dikirimkan ke email Anda.
                        </p>
                        <div
                            class="alert alert-danger text-center my-4"
                            role="alert">
                            Jangan bagikan kode OTP Anda kepada siapapun!
                        </div>
                        <?php if (session('error') !== null) : ?>
                            <div class="alert alert-danger"><?= session('error') ?></div>
                        <?php endif ?>
                        <form action="<?= url_to('auth-action-verify') ?>" method="post" id="token-form">
                            <?= csrf_field() ?>
                            <div class="row">
                                <?php for ($i = 1; $i <= 6; $i++): ?>
                                    <div class="col-2">
                                        <div class="mb-3">
                                            <label for="digit<?= $i ?>-input" class="visually-hidden">Digit <?= $i ?></label>
                                            <input
                                                type="text"
                                                class="form-control form-control-lg text-center two-step"
                                                maxlength="1"
                                                pattern="[0-9]*"
                                                inputmode="numeric"
                                                id="digit<?= $i ?>-input"
                                                oninput="updateTokenInput()"
                                                required />
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="token" id="token-hidden-input" required>
                            <div class="mt-4">
                                <button
                                    class="btn btn-primary w-100 waves-effect waves-light"
                                    type="submit">
                                    Konfirmasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <p class="text-muted mb-0">
                        Tidak menerima email?
                        <a href="<?= base_url('auth/a/show') ?>" class="text-primary fw-semibold">
                            Kirim Ulang
                        </a>
                    </p>
                </div>
            </div>
            <div class="text-muted mt-3 mt-md-5 text-center">
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
    <script>
        function updateTokenInput() {
            const tokenInput = document.getElementById('token-hidden-input');
            const digits = document.querySelectorAll('.two-step');

            // Gabungkan semua nilai input menjadi satu string
            let tokenValue = '';
            digits.forEach(input => {
                tokenValue += input.value;
            });

            // Set nilai gabungan ke input tersembunyi
            tokenInput.value = tokenValue;
        }
    </script>
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
    <!-- two-step-verification js -->
    <script src="/assets/js/pages/two-step-verification.init.js"></script>
</body>

</html>