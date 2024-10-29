<?php

namespace App\Controllers;

// namespace CodeIgniter\Shield\Controllers;

// use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
// use CodeIgniter\Shield\Traits\Viewable;
// use CodeIgniter\Shield\Validation\ValidationRules;
// use App\Controllers\BaseController;
// use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Controllers\LoginController as BaseLoginController;
use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Models\UserModel;

class CustomLoginController extends BaseLoginController
{

    public function loginView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->loginRedirect());
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        return $this->view(setting('Auth.views')['login']);
    }
    public function loginAction(): RedirectResponse
    {
        // Validate here first
        $rules = $this->getValidationRules();
    
        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        /** @var array $credentials */
        $credentials = $this->request->getPost(setting('Auth.validFields')) ?? [];
        $credentials = array_filter($credentials);
        $credentials['password'] = $this->request->getPost('password');
        $remember = (bool) $this->request->getPost('remember');
    
        // Check if the user is active by searching in auth_identities and users table
        $userIdentityModel = new UserIdentityModel();
        $userIdentity = $userIdentityModel->where('secret', $credentials['email'])->first(); // Cari berdasarkan 'secret' (email)
    
        if (!$userIdentity) {
            return redirect()->route('login')->withInput()->with('error', 'User not found.');
        }
    
        // Ambil data user dari tabel users menggunakan user_id dari objek UserIdentity
        $userModel = new UserModel();
        $user = $userModel->find($userIdentity->user_id); // Akses user_id sebagai properti objek
    
        if (!$user || !$user->active) {
            return redirect()->route('login')->withInput()->with('error', 'Account is not activated.');
        }
    
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();
    
        // Attempt to login
        $result = $authenticator->remember($remember)->attempt($credentials);
        if (! $result->isOK()) {
            return redirect()->route('login')->withInput()->with('error', $result->reason());
        }
    
        // If an action has been defined for login, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show')->withCookies();
        }
    
        return redirect()->to(config('Auth')->loginRedirect())->withCookies();
    }
}
