<?= $this->extend('layout/master_dashboard'); ?>
<?= $this->section('title') ?><title>Pengaturan Website | Rumah Inovasi</title><?= $this->endSection() ?>
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
                                                            <!-- Menampilkan teks yang telah difilter dengan tag HTML yang diizinkan -->
                                                            <?= $option['clean_text'] ?>
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
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Pengaturan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" action="" method="post" enctype="multipart/form-data">
                    <!-- Input hidden untuk mengirim tipe -->
                    <input type="hidden" name="tipe" id="hidden-tipe">

                    <!-- Input untuk Text atau Image -->
                    <div class="text-input">
                        <label for="setting-text" class="col-form-label">Teks:</label>
                        <textarea id="setting-text" name="text" class="form-control" placeholder="" rows="5"></textarea>
                    </div>
                    <div class="image-input" style="display: none;">
                        <label for="setting-image" class="col-form-label">Unggah Gambar:</label>
                        <input type="file" class="form-control" id="setting-image" name="image">
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning" form="edit-form">Perbarui</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit');
    const modal = document.getElementById('editModal');
    const form = modal.querySelector('#edit-form');
    const colorInputDiv = document.createElement('div'); // Div untuk input warna
    const textInputDiv = modal.querySelector('.text-input'); // Div untuk input teks
    const imageInputDiv = modal.querySelector('.image-input'); // Div untuk input gambar
    const hiddenTipeInput = modal.querySelector('#hidden-tipe');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const settingId = this.getAttribute('data-setting-id');
            const type = this.getAttribute('data-type').toLowerCase();
            const value = this.closest('tr').querySelector('td').innerText.trim();

            // Set form action
            form.action = `/superadmin/optionweb/update/${settingId}`;
            hiddenTipeInput.value = type;

            // Reset input warna
            if (colorInputDiv.parentNode) colorInputDiv.parentNode.removeChild(colorInputDiv);

            // Tampilkan input warna jika tipe pengaturan adalah 'warna'
            if (type === 'warna' || type === 'kode warna') {
                colorInputDiv.className = 'mb-3';
                colorInputDiv.innerHTML = `
                    <label for="setting-warna" class="col-form-label">Warna:</label>
                    <input
                        type="color"
                        class="form-control form-control-color"
                        id="setting-warna"
                        name="warna"
                        value="${value.startsWith('#') ? value : '#000000'}"
                        title="Pilih warna"
                    />
                `;
                form.insertBefore(colorInputDiv, form.querySelector('.modal-footer'));
                textInputDiv.style.display = 'none'; // Sembunyikan input teks
                imageInputDiv.style.display = 'none'; // Sembunyikan input gambar

                // Tampilkan input gambar jika tipe pengaturan adalah 'image'
            } else if (type === 'image') {
                textInputDiv.style.display = 'none'; // Sembunyikan input teks
                imageInputDiv.style.display = 'block'; // Tampilkan input gambar
                colorInputDiv.style.display = 'none'; // Sembunyikan input warna

                // Jika tipe bukan 'warna' atau 'image', tampilkan input teks dan sembunyikan lainnya
            } else {
                textInputDiv.style.display = 'block'; // Tampilkan input teks
                imageInputDiv.style.display = 'none'; // Sembunyikan input gambar
                colorInputDiv.style.display = 'none'; // Sembunyikan input warna
                modal.querySelector('#setting-text').value = value; // Set nilai teks
                if (window.ckEditorInstance) {
                    window.ckEditorInstance.setData(value); // Set data CKEditor
                }
            }
        });
    });

    // Sinkronisasi data CKEditor sebelum form dikirimkan
    form.addEventListener('submit', function () {
        if (window.ckEditorInstance) {
            modal.querySelector('#setting-text').value = window.ckEditorInstance.getData(); // Sinkronisasi data CKEditor
        }
    });
});
</script>

<!-- init js -->
<script src="/assets/js/pages/form-editor.init.js"></script>
<!-- ckeditor -->
<script src="/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
<script>
    ClassicEditor
    .create(document.querySelector('#setting-text'))
    .then(editor => {
        window.ckEditorInstance = editor; // Simpan referensi editor global untuk akses nanti
    })
    .catch(error => {
        console.error(error);
    });
</script>


<?= $this->endSection(); ?>