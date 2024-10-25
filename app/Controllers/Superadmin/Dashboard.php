<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('super_admin/dashboard');
    }
}
