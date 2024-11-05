<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Shield\Controllers\RegisterController as BaseRegisterController;
use App\Models\OpdModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Database\Database; // Tambahkan ini

use App\Models\GroupModel;

class CustomRegisterController extends BaseRegisterController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); // Memuat database
    }

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
    
        $opdModel = new OpdModel();
    
        // Mendapatkan id_opd yang sudah digunakan oleh user dalam grup 'admin-opd'
        $usedOpdIds = $this->db->table('auth_groups_users')
            ->join('users', 'auth_groups_users.user_id = users.id')
            ->where('auth_groups_users.group', 'admin-opd')
            ->select('users.id_opd')
            ->distinct()
            ->get()
            ->getResultArray();
    
        // Ekstrak id_opd ke dalam array
        $usedOpdIdsArray = array_column($usedOpdIds, 'id_opd');
    
        // Ambil OPD yang tidak ada dalam daftar id_opd yang sudah digunakan
        $opd = !empty($usedOpdIdsArray) 
            ? $opdModel->getAvailableOpd($usedOpdIdsArray) 
            : $opdModel->findAll();
    
        // Kirim data ke view
        return $this->view(setting('Auth.views')['register'], ['opd' => $opd]);
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
    
        if (!setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }
    
        $users = $this->getUserProvider();
        $groupModel = new GroupModel();
        $opdModel = new OpdModel();
    
        // Mendapatkan id_opd yang sudah digunakan oleh user dalam grup 'admin-opd'
        $usedOpdIds = $this->db->table('auth_groups_users')
            ->join('users', 'auth_groups_users.user_id = users.id')
            ->where('auth_groups_users.group', 'admin-opd')
            ->select('users.id_opd')
            ->distinct()
            ->get()
            ->getResultArray();
    
        // Ekstrak id_opd ke dalam array
        $usedOpdIdsArray = array_column($usedOpdIds, 'id_opd');
    
        // Ambil OPD yang tidak ada dalam daftar id_opd yang sudah digunakan
        $opd = !empty($usedOpdIdsArray) 
            ? $opdModel->getAvailableOpd($usedOpdIdsArray) 
            : $opdModel->findAll();
    
        // Validasi dan penyimpanan user
        $rules = $this->getValidationRules();
        if (!$this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $allowedPostFields = array_keys($rules);
        $user = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));
    
        if ($user->username === null) {
            $user->username = null;
        }
    
        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
    
        $user = $users->findById($users->getInsertID());
        $groupModel->addUserToGroup($user->id, 'admin-opd');
    
        // Nonaktifkan otomatisasi OTP/aktivasi akun
        $user->active = false;
        $users->save($user);
    
        Events::trigger('register', $user);
    
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


