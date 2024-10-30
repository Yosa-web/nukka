<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Rumah Inovasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/logo_litbang.png" />
    <!-- Sweet Alert-->
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- dropzone css -->
    <link href="/assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
    <!-- plugin css -->
    <link
        href="/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css"
        rel="stylesheet"
        type="text/css" />

    <!-- DataTables -->
    <link href="/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- alertifyjs Css -->
    <link
        href="/assets/libs/alertifyjs/build/css/alertify.min.css"
        rel="stylesheet"
        type="text/css" />

    <!-- alertifyjs default themes  Css -->
    <link
        href="/assets/libs/alertifyjs/build/css/themes/default.min.css"
        rel="stylesheet"
        type="text/css" />

    <!-- Bootstrap Css -->
    <link
        href="/assets/css/bootstrap.css"
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
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="#" class="logo logo-dark">
                            <span class="logo-sm">
                                <img
                                    src="/assets/images/logo_litbang.png"
                                    alt=""
                                    height="35" />
                            </span>
                            <span class="logo-lg">
                                <img
                                    src="/assets/images/logo_litbang.png"
                                    alt=""
                                    height="35" />
                                <span class="logo-txt">Rumah Inovasi</span>
                            </span>
                        </a>
                    </div>

                    <button
                        type="button"
                        class="btn btn-sm px-3 font-size-16 header-item"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex">
                    <div class="dropdown d-inline-block">
                        <button
                            type="button"
                            class="btn header-item bg-light-subtle border-start border-end"
                            id="page-header-user-dropdown"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <img
                                class="rounded-circle header-profile-user"
                                src="/assets/images/users/admin.jpg"
                                alt="Header Avatar" />
                            <span
                                class="d-none d-xl-inline-block ms-1 fw-medium">Super Admin</span>
                            <i
                                class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- <a
									class="dropdown-item"
									href="#"
									><i
										class="mdi mdi mdi-face-man font-size-16 align-middle me-1"></i>
									Profile</a
								>
								<div class="dropdown-divider"></div> -->
                            <a class="dropdown-item" href="login.html"><i
                                    class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                                Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li>
                            <a href="dashboard.html">
                                <i data-feather="home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="menu-title">
                            Inovasi
                        </li>

                        <li>
                            <a href="jenis-inovasi.html">
                                <i class='bx bx-bulb'></i>
                                <span>Jenis Inovasi</span>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="has-arrow">
                                <i data-feather="file-text"></i>
                                <span>Data Inovasi</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="daftar-proposal.html">Daftar Proposal</a></li>
                                <li><a href="verifikasi-proposal.html">Verifikasi Proposal</a></li>
                            </ul>
                        </li>

                        <li class="menu-title">
                            Pengguna
                        </li>

                        <li>
                            <a href="data-opd.html">
                                <i data-feather="user-check"></i>
                                <span>Data OPD</span>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="has-arrow">
                                <i data-feather="users"></i>
                                <span>Data Pengguna</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="data-admin.html">Admin</a></li>
                                <li>
                                    <a href="data-pegawai.html">Pegawai</a>
                                </li>
                                <li><a href="data-pengguna-umum.html">Umum</a></li>
                            </ul>
                        </li>

                        <li class="menu-title">
                            Kelola Konten
                        </li>

                        <li>
                            <a href="kelola-berita.html">
                                <i data-feather="layout"></i>
                                <span>Kelola Berita</span>
                            </a>
                        </li>

                        <li>
                            <a href="kelola-galeri.html">
                                <i data-feather="grid"></i>
                                <span>Kelola Galeri</span>
                            </a>
                        </li>

                        <li class="menu-title">
                            Pengaturan
                        </li>

                        <li>
                            <a href="pengaturan-web.html">
                                <i data-feather="settings"></i>
                                <span>Pengaturan Website</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>

        <?= $this->renderSection('content'); ?>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        Balitbang Pesawaran ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        All Right Reserved.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Developed by
                            <a
                                href="#"
                                class="text-decoration-underline">Tim 2 MSIB 7</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div class="right-bar">
        <div data-simplebar class="h-100">
            <!-- Settings -->
            <hr class="m-0" />

            <div class="p-4">
                <h6 class="mb-3">Layout</h6>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="layout"
                        id="layout-vertical"
                        value="vertical" />
                    <label class="form-check-label" for="layout-vertical">Vertical</label>
                </div>

                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="layout-mode"
                        id="layout-mode-light"
                        value="light" />
                    <label class="form-check-label" for="layout-mode-light">Light</label>
                </div>

                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="layout-width"
                        id="layout-width-fuild"
                        value="fuild"
                        onchange="document.body.setAttribute('data-layout-size', 'fluid')" />
                    <label class="form-check-label" for="layout-width-fuild">Fluid</label>
                </div>

                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="layout-position"
                        id="layout-position-fixed"
                        value="fixed"
                        onchange="document.body.setAttribute('data-layout-scrollable', 'false')" />
                    <label
                        class="form-check-label"
                        for="layout-position-fixed">Fixed</label>
                </div>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="topbar-color"
                        id="topbar-color-light"
                        value="light"
                        onchange="document.body.setAttribute('data-topbar', 'light')" />
                    <label class="form-check-label" for="topbar-color-light">Light</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="sidebar-size"
                        id="sidebar-size-default"
                        value="default"
                        onchange="document.body.setAttribute('data-sidebar-size', 'lg')" />
                    <label
                        class="form-check-label"
                        for="sidebar-size-default">Default</label>
                </div>

                <div class="form-check sidebar-setting">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="sidebar-color"
                        id="sidebar-color-light"
                        value="light"
                        onchange="document.body.setAttribute('data-sidebar', 'light')" />
                    <label
                        class="form-check-label"
                        for="sidebar-color-light">Light</label>
                </div>

                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="layout-direction"
                        id="layout-direction-ltr"
                        value="ltr" />
                    <label
                        class="form-check-label"
                        for="layout-direction-ltr">LTR</label>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/libs/jquery/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <!-- pace js -->
    <script src="/assets/libs/pace-js/pace.min.js"></script>
    <!-- echarts js -->
    <script src="/assets/libs/echarts/echarts.min.js"></script>
    <!-- echarts init -->
    <script src="/assets/js/pages/echarts.init.js"></script>
    <!-- Plugins js-->
    <script src="/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
    <!-- dashboard init -->
    <script src="/assets/js/pages/dashboard.init.js"></script>
    <!-- Required datatable js -->
    <script src="/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Responsive examples -->
    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Datatable init js -->
    <script src="/assets/js/pages/datatables.init.js"></script>
    <script src="/assets/js/app.js"></script>
    <!-- Buttons examples -->
    <script src="/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>

</html>