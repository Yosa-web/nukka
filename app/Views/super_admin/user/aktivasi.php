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
									<a href="<?= base_url('superadmin/user/list/admin') ?>">Admin</a>
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
			<?php if (session()->getFlashdata('error') || session()->getFlashdata('message')): ?>
				<div class="alert alert-dismissible fade show <?= session()->getFlashdata('error') ? 'alert-danger' : 'alert-success' ?>">
					<?= session()->getFlashdata('error') ?: session()->getFlashdata('message') ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
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
												<form id="activateForm" action="<?= site_url('useractivation/activate') ?>" method="post" style="display: inline;">
													<?= csrf_field() ?>
													<input type="hidden" name="id" value="<?= $user->id ?>">
													<button type="button" class="btn btn-outline-success btn-sm activate mb-3" title="Verifikasi">
														<i class="fas fa-check"></i>
													</button>
												</form>
												<form action="<?= site_url('useractivation/reject') ?>" method="post" style="display: inline;">
													<?= csrf_field() ?>
													<input type="hidden" name="id" value="<?= $user->id ?>">
													<button type="button" class="btn btn-outline-danger btn-sm reject ms-2 mb-3" title="Tolak">
														<i class="fas fa-times"></i>
													</button>
												</form>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Sweet alert verifikasi-->
<script>
    document.querySelectorAll(".activate").forEach(function(button) {
        button.addEventListener("click", function(event) {
            event.preventDefault();

            const form = this.closest("form");
            const formData = new FormData(form);

            Swal.fire({
                title: "Konfirmasi Verifikasi",
                text: "Anda yakin ingin mengaktifkan akun ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#2ab57d",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "Verifikasi",
                cancelButtonText: "Batal",
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
<!-- Sweet alert tolak -->
<script>
    document.querySelectorAll(".reject").forEach(function(button) {
        button.addEventListener("click", function(event) {
            event.preventDefault();

            const form = this.closest("form");
            const formData = new FormData(form);

            Swal.fire({
                title: "Konfirmasi Penolakan",
                text: "Anda yakin ingin menolak akun ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#2ab57d",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "Tolak",
                cancelButtonText: "Batal",
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>