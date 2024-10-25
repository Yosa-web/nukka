<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Shield\Controllers\RegisterController as BaseRegisterController;
use App\Models\OpdModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Exceptions\ValidationException;
use App\Models\GroupModel;

class CustomRegisterController extends BaseRegisterController
{
    public function registerView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (!setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        // Ambil data dari tabel opd
        $opdModel = new OpdModel(); // Inisialisasi model opd
        $test['opd'] = $opdModel->findAll(); // Ambil semua data opd

        // Kirim data ke view
        return $this->view(setting('Auth.views')['register'], $test);
    }

    public function registerViewUser()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (!setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        // Kirim data ke view
        return view('Shield/register_user');
    }


    public function registerActionNew(): RedirectResponse
{
    if (auth()->loggedIn()) {
        return redirect()->to(config('Auth')->registerRedirect());
    }

    // Check if registration is allowed
    if (! setting('Auth.allowRegistration')) {
        return redirect()->back()->withInput()
            ->with('error', lang('Auth.registerDisabled'));
    }

    $users = $this->getUserProvider();

    // Validate here first, since some things,
    // like the password, can only be validated properly here.
    $rules = $this->getValidationRules();

    if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Save the user
    $allowedPostFields = array_keys($rules);
    $user              = $this->getUserEntity();
    $user->fill($this->request->getPost($allowedPostFields));

    // Workaround for email only registration/login
    if ($user->username === null) {
        $user->username = null;
    }

    try {
        $users->save($user);
    } catch (ValidationException $e) {
        return redirect()->back()->withInput()->with('errors', $users->errors());
    }

    // To get the complete user object with ID, we need to get from the database
    $user = $users->findById($users->getInsertID());

    $groupModel = new GroupModel();
    $groupModel->addUserToGroup($user->id, 'admin'); // Menambahkan user ke grup 'admin'


    Events::trigger('register', $user);

    // Nonaktifkan otomatisasi OTP/aktivasi akun
    // Set akun sebagai non-aktif (superadmin yang akan mengaktifkan)
    $user->active = false;  // Status akun menjadi tidak aktif
    $users->save($user);

    // Jangan panggil startLogin dan completeLogin untuk menghindari login langsung

    // Success - Informasikan bahwa akun akan diaktivasi oleh superadmin
    return redirect()->to(config('Auth')->registerRedirect())
        ->with('message', 'Pendaftaran berhasil! Akun Anda akan diaktivasi oleh superadmin.');
        
}
    
public function registerAction(): RedirectResponse
{
    if (auth()->loggedIn()) {
        return redirect()->to(config('Auth')->registerRedirect());
    }

    // Check if registration is allowed
    if (! setting('Auth.allowRegistration')) {
        return redirect()->back()->withInput()
            ->with('error', lang('Auth.registerDisabled'));
    }

    $users = $this->getUserProvider();

    // Validate here first, since some things,
    // like the password, can only be validated properly here.
    $rules = config('Validation')->registrationUser;

    if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Save the user
    $allowedPostFields = array_keys($rules);
    $user              = $this->getUserEntity();
    $user->fill($this->request->getPost($allowedPostFields));

    // Workaround for email only registration/login
    if ($user->username === null) {
        $user->username = null;
    }

    try {
        $users->save($user);
    } catch (ValidationException $e) {
        return redirect()->back()->withInput()->with('errors', $users->errors());
    }

    // To get the complete user object with ID, we need to get from the database
    $user = $users->findById($users->getInsertID());

    // Add to default group
    $users->addToDefaultGroup($user);

    Events::trigger('register', $user);

    /** @var Session $authenticator */
    $authenticator = auth('session')->getAuthenticator();

    $authenticator->startLogin($user);

    // If an action has been defined for register, start it up.
    $hasAction = $authenticator->startUpAction('register', $user);
    if ($hasAction) {
        return redirect()->route('auth-action-show');
    }

    // Set the user active
    $user->activate();

    $authenticator->completeLogin($user);

    // Success!
    return redirect()->to(config('Auth')->registerRedirect())
        ->with('message', lang('Auth.registerSuccess'));
}
    
}


