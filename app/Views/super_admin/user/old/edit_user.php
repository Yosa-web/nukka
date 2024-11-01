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
                <form action="/superadmin/userumum/update/<?= $user->id ?>" method="post">

                    <?= csrf_field() ?>

                    <!-- Email -->
                    <div class="form-floating mb-2">
                        <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email', $user->email) ?>" required>
                        <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
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
                        <input type="text" class="form-control" id="floatingNipInput" name="NIK" inputmode="text" autocomplete="nik" placeholder="NIK" value="<?= old('NIK', $user->NIK) ?>" required>
                        <label for="floatingNipInput">NIK</label>
                    </div>

                    <!-- Group -->
                    <div class="form-floating mb-4">
                        <select type="text" class="form-control" id="floatingGroupInput" name="group" inputmode="text" autocomplete="group" placeholder="group" required>
                            <option value="" disabled>Pilih Group User</option>
                            <option value="admin-opd" <?= old('group', $user->group) == 'admin-opd' ? 'selected' : '' ?>>Admin Opd</option>
                            <option value="sekertaris-opd" <?= old('group', $user->group) == 'sekertaris-opd' ? 'selected' : '' ?>>Sekertaris OPD</option>
                            <option value="super-admin" <?= old('group', $user->group) == 'super-admin' ? 'selected' : '' ?>>Super Admin</option>
                            <option value="operator" <?= old('group', $user->group) == 'operator' ? 'selected' : '' ?>>Operator</option>
                            <option value="user" <?= old('group', $user->group) == 'user' ? 'selected' : '' ?>>User</option>
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
