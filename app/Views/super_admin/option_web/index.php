<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan | Rumah Inovasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logo_litbang.png" />
    <!-- Sweet Alert-->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- dropzone css -->
    <link href="assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
    <!-- plugin css -->
    <link
        href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css"
        rel="stylesheet"
        type="text/css" />

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link
        href="assets/css/bootstrap.css"
        id="bootstrap-style"
        rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link
        href="assets/css/icons.min.css"
        rel="stylesheet"
        type="text/css" />
    <!-- App Css-->
    <link
        href="assets/css/app.min.css"
        id="app-style"
        rel="stylesheet"
        type="text/css" />
</head>

<body>
    <div class="container">
        <h1>Option Web Settings</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div style="color: green;">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div style="color: red;">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <table class="table align-middle mb-0 table-hover">
            <thead>
                <tr>
                    <th style="width: 200px">Key</th>
                    <th>Value</th>
                    <th class="text-center" style="width: 200px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($options)): ?>
                    <?php foreach ($options as $option): ?>
                        <tr>
                            <td scope="row"><?= esc($option['key']) ?></td>
                            <td>
                                <?php if ($option['seting_type'] === 'Image'): ?>
                                    <!-- Menampilkan gambar -->
                                    <img src="<?= base_url('assets/uploads/images/optionweb/' . esc($option['value'])) ?>" alt="Option Image" class="option-image rounded me-2" width="200">
                                <?php else: ?>
                                    <!-- Menampilkan teks jika bukan gambar -->
                                    <?= esc($option['value']) ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-warning btn-sm edit" title="Edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fas fa-pencil-alt"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No options found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Modal edit logo -->
    <div
        class="modal fade"
        id="staticBackdrop"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        role="dialog"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div
            class="modal-dialog modal-dialog-centered"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5
                        class="modal-title"
                        id="staticBackdropLabel">
                        Edit Logo
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form
                        action="javascript: void(0);">
                        <div class="mb-3">
                            <label
                                for="setting-logo"
                                class="col-form-label">Upload Logo</label>
                            <div class="dropzone" id="imageDropzone">
                                <div class="fallback">
                                    <input name="file" type="file" multiple="multiple">
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <i class="display-4 text-muted bx bx-cloud-upload"></i>
                                    </div>
                                    <h5>Drop files here or click to upload.</h5>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        data-bs-dismiss="modal"
                        id="alert-success">
                        Kirim
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <!-- pace js -->
    <script src="assets/libs/pace-js/pace.min.js"></script>
    <!-- Plugins js-->
    <script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>
    <!-- Buttons examples -->
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/app.js"></script>
    <!-- Sweet Alerts js -->
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <!-- Sweet alert init js-->
    <script>
        document
            .getElementById("sa-warning")
            .addEventListener("click", function() {
                Swal.fire({
                    title: "Konfirmasi hapus data?",
                    text: "",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#2ab57d",
                    cancelButtonColor: "#fd625e",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal",
                }).then(function(e) {
                    e.value &&
                        Swal.fire(
                            "Terhapus!",
                            "Data telah dihapus",
                            "success",
                        );
                });
            });
    </script>
    <!-- dropzone js -->
    <script src="assets/libs/dropzone/min/dropzone.min.js"></script>
</body>

</html>