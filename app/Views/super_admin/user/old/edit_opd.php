<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.editUser') ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

    <div class="container d-flex justify-content-center p-5">
        <div class="card col-12 col-md-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-5"><?= lang('Auth.editUser') ?></h5>

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
                
                <!-- Form untuk mengedit data pengguna -->
                <form action="/superadmin/user/update/<?= $user->id ?>" method="post">

                    <?= csrf_field() ?>

                    <!-- Email -->
                    <div class="form-floating mb-2">
                        <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email', $user->email) ?>" required>
                        <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                    </div>


                    <!-- ID OPD -->
                    <div class="form-floating mb-4">
                        <select class="form-select" id="floatingIdOpdInput" name="id_opd" required>
                            <option value="" disabled>Pilih OPD</option>
                            <?php foreach ($opd as $item): ?>
                                <option value="<?= esc($item->id_opd) ?>" <?= old('id_opd', $user->id_opd) == esc($item->id_opd) ? 'selected' : '' ?>><?= esc($item->nama_opd) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="floatingIdOpdInput">OPD</label>
                    </div>

                    <!-- No Telepon -->
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="floatingNoTeleponInput" name="no_telepon" inputmode="tel" autocomplete="tel" placeholder="No Telepon" value="<?= old('no_telepon', $user->no_telepon) ?>" required>
                        <label for="floatingNoTeleponInput">No Telepon</label>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="floatingNameInput" name="name" inputmode="text" autocomplete="name" placeholder="Nama Lengkap" value="<?= old('name', $user->name) ?>" required>
                        <label for="floatingNameInput">Nama Lengkap</label>
                    </div>

                    <!-- NIP -->
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="floatingNipInput" name="NIP" inputmode="text" autocomplete="nip" placeholder="NIP" value="<?= old('NIP', $user->NIP) ?>" required>
                        <label for="floatingNipInput">NIP</label>
                    </div>

                    <!-- Group -->
                    <div class="form-floating mb-4">
                        <select type="text" class="form-control" id="floatingGroupInput" name="group" required>
                            <option value="" disabled>Pilih Group User</option>
                            <option value="admin-opd" <?= $currentGroup == 'admin-opd' ? 'selected' : '' ?>>Admin Opd</option>
                            <option value="sekertaris-opd" <?= $currentGroup == 'sekertaris-opd' ? 'selected' : '' ?>>Sekertaris OPD</option>
                            <option value="super-admin" <?= $currentGroup == 'super-admin' ? 'selected' : '' ?>>Super Admin</option>
                            <option value="operator" <?= $currentGroup == 'operator' ? 'selected' : '' ?>>Operator</option>
                            <option value="user" <?= $currentGroup == 'user' ? 'selected' : '' ?>>User</option>
                        </select>
                        <label for="floatingGroupInput">Group</label>
                    </div>

                    <!-- Password -->
                    <div class="form-floating mb-2">
                        <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>">
                        <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                    </div>

                    <div class="d-grid col-12 col-md-8 mx-auto m-3">
                        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.saveChanges') ?></button>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>
