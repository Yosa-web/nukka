<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Verifikasi Admin | Rumah Inovasi</title><?= $this->endSection() ?>
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
							Verifikasi Admin
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
									Verifikasi Admin
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<!-- end page title -->
			<?php if (session()->has('message')) : ?>
				<p style="color: green;"><?= session('message') ?></p>
			<?php endif; ?>

			<?php if (session()->has('error')) : ?>
				<p style="color: red;"><?= session('error') ?></p>
			<?php endif; ?>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<table id="datatable" class="table table-bordered dt-responsive w-100 table-hover">
								<thead>
									<tr>
										<th class="text-center" style="width: 100px">Nama Admin</th>
										<th class="text-center" style="width: 200px">OPD</th>
										<th class="text-center" style="width: 90px">NIP</th>
										<th class="text-center" style="width: 80px">No. Telepon</th>
										<th class="text-center" style="width: 100px">Email</th>
										<th class="text-center" style="width: 70px">Status</th>
										<th class="text-center" style="width: 70px">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($users as $index => $user): ?>
										<tr>
											<td class="text-center"><?= esc($user->name) ?></td>
											<td><?= esc($user->nama_opd) ?></td>
											<td class="text-center"><?= esc($user->NIP) ?></td>
											<td class="text-center"><?= esc($user->no_telepon); ?></td>
											<td class="text-center"><?= esc($user->email) ?></td>
											<td class="text-center"><span class="badge bg-secondary rounded-pill">Non Aktif</span></td>
											<td class="text-center">
												<form id="activateForm" action="<?= site_url('useractivation/activate/' . $user->id) ?>" method="post" style="display: inline;">
													<?= csrf_field() ?>
													<button type="button" class="btn btn-outline-success btn-sm delete mb-3" title="Verifikasi" id="sa-title">
														<i class="fas fa-check"></i>
													</button>
												</form>
												<a class="btn btn-outline-danger btn-sm delete ms-2 mb-3" title="Tolak" id="sa-params">
													<i class="fas fa-times"></i>
												</a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Sweet Alerts js -->
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<!-- Sweet alert init js-->
<script>
	document.getElementById("sa-title").addEventListener("click", function(event) {
			event.preventDefault(); // Mencegah form submit langsung

			Swal.fire({
				title: "Verifikasi Admin?",
				text: "Anda yakin akan memverifikasi pengguna ini?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Verifikasi",
				cancelButtonText: "Batal",
				confirmButtonClass: "btn btn-success mt-2",
				cancelButtonClass: "btn btn-danger ms-2 mt-2",
				buttonsStyling: false,
			}).then(function(e) {
				if (e.value) {
					// Jika pengguna menekan "Verifikasi", submit form
					document.getElementById("activateForm").submit();
					Swal.fire(
						"Diverifikasi!",
						"Akun pengguna tersebut telah terverifikasi.",
						"success",
					);
				}
			});
		}),
		document.getElementById("sa-params").addEventListener("click", function() {
			Swal.fire({
				title: "Apakah anda yakin?",
				text: "Anda yakin akan menolak pengguna ini?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Tolak",
				cancelButtonText: "Batal",
				confirmButtonClass: "btn btn-primary mt-2",
				cancelButtonClass: "btn btn-secondary ms-2 mt-2",
				buttonsStyling: false,
			}).then(function(e) {
				if (e.value) {
					Swal.fire(
						"Ditolak!",
						"Akun tersebut telah ditolak.",
						"error",
					);
				}
			});
		});
</script>
<?= $this->endSection(); ?>