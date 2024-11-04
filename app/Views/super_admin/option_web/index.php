<?= $this->extend('layout/master_dashboard'); ?>

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
                            Pengaturan Website
                        </h3>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Pengaturan</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="pengaturan-web.html">Pengaturan Web</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
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
                                                    <th scope="row"><?= esc($option['key']) ?></th>
                                                    <td>
                                                        <?php if ($option['seting_type'] === 'Image'): ?>
                                                            <img class="rounded me-2" alt="Option Image" width="200" src="<?= base_url('assets/uploads/images/optionweb/' . esc($option['value'])) ?>" data-holder-rendered="true">
                                                        <?php else: ?>
                                                            <?= esc($option['value']) ?>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-warning btn-sm edit" title="Edit" data-bs-toggle="modal"
                                                            data-bs-target="#editModal" data-key="<?= esc($option['key']) ?>"
                                                            data-setting-id="<?= esc($option['id_setting']) ?>"
                                                            data-type="<?= esc($option['seting_type']) ?>">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit -->
<div
    class="modal fade"
    id="editModal"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    role="dialog"
    aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div
        class="modal-dialog modal-dialog-centered"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="editModalLabel">
                    Edit Pengaturan
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" action="" method="post" enctype="multipart/form-data">
                    <div id="edit-field">
                        <!-- Isi input akan berubah berdasarkan key -->
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
                    class="btn btn-warning"
                    form="edit-form">
                    Perbarui
                </button>
            </div>
        </div>
    </div>
</div>


<!-- dropzone js -->
<script src="/assets/libs/dropzone/min/dropzone.min.js"></script>
<script>
    // Disable Dropzone auto-discovering all elements with .dropzone class
    Dropzone.autoDiscover = false;
    // Initialize Dropzone
    var myDropzone = new Dropzone("#imageDropzone", {
        url: "/your-upload-endpoint", // URL untuk mengupload file
        maxFiles: 5,
        maxFilesize: 2, // Maksimal ukuran file dalam MB
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        dictRemoveFile: "Remove",
        thumbnailWidth: 200,
        thumbnailHeight: 200,
        init: function() {
            this.on("success", function(file, response) {
                console.log("File successfully uploaded!");
            });
            this.on("error", function(file, errorMessage) {
                console.log("Error: " + errorMessage);
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tangkap klik pada tombol edit
        const editButtons = document.querySelectorAll('.edit');
        const modal = document.getElementById('editModal');
        const modalLabel = modal.querySelector('.modal-title');
        const editField = modal.querySelector('#edit-field');
        const form = modal.querySelector('#edit-form');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const key = this.getAttribute('data-key');
                const settingId = this.getAttribute('data-setting-id');
                const type = this.getAttribute('data-type');

                // Set form action URL berdasarkan setting ID
                form.action = `/superadmin/optionweb/edit/${settingId}`;

                // Ubah konten modal berdasarkan key dan type
                modalLabel.textContent = `Edit ${key}`;
                editField.innerHTML = ''; // Bersihkan konten sebelumnya

                switch (key) {
                    case 'Logo':
                        editField.innerHTML = `
                            <div class="mb-3">
                                <label
                                    for="setting-logo"
                                    class="col-form-label"
                                    >Upload Logo</label>
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
                            </div>`;
                        break;

                    case 'Warna':
                        editField.innerHTML = `
                            <div class="mb-3">
                                <label
                                    for="setting-warna"
                                    class="col-form-label"
                                    >Warna</label>
                                <input
                                    type="color"
                                    class="form-control form-control-color mw-100"
                                    id="setting-warna"
                                    value="#5156be"
                                    title="Choose your color"
                                />
                            </div>`;
                        break;

                    case 'Nama':
                        editField.innerHTML = `
                            <div class="mb-3">
                                <label
                                    for="setting-nama"
                                    class="col-form-label"
                                    >Nama Website</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="setting-nama"
                                    required />
                            </div>`;
                        break;

                    case 'Regulasi':
                        editField.innerHTML = `
                            <div class="mb-3">
                                <label
                                    for="setting-regulasi"
                                    class="col-form-label"
                                    >Regulasi</label
                                >
                                <textarea class="form-control" id="setting-regulasi" rows="4"></textarea>
                            </div>`;
                        break;

                    case 'Banner':
                        editField.innerHTML = `
                            <div class="mb-3">
                                <label
                                    for="setting-banner"
                                    class="col-form-label"
                                    >Unggah Banner</label
                                >
                                <div class="dropzone" id="bannerDropzone">
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
                            </div>`;
                        break;

                    case 'Deskripsi':
                        editField.innerHTML = `
                            <div class="mb-3">
                                <label
                                    for="setting-deskripsi"
                                    class="col-form-label"
                                    >Deskripsi</label
                                >
                                <textarea class="form-control" id="setting-deskripsi" rows="4"></textarea>
                            </div>`;
                        break;

                    default:
                        editField.innerHTML = `
                            <div class="mb-3">
                                <label for="setting-value" class="col-form-label">Value</label>
                                <input type="text" class="form-control" name="value" id="setting-value" required>
                            </div>`;
                        break;
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>