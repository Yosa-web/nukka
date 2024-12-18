<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Berhasil Ubah Kata Sandi | Rumah Inovasi</title>
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

		.welcome {
			font-size: 15px;
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
			<div class="auth-content my-auto">
				<div class="text-center">
					<div class="avatar-lg mx-auto">
						<div class="avatar-title rounded-circle bg-light">
							<i
								class="bx bx-mail-send h2 mb-0 text-primary"></i>
						</div>
					</div>
					<div class="p-2 mt-4">
						<h4>Periksa email Anda!</h4>
						<p class="fw-normal">
							Kami baru saja mengirimi Anda email dengan tautan Masuk di dalamnya.
							<br>
							Ini hanya berlaku selama 60 menit.
						</p>
					</div>
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
</body>

</html>