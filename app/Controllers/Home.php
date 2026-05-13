<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (session('logged_in')) {
            $role = session('user_role');
            if ($role === 'admin') {
                return redirect()->to(base_url('admin/dashboard'));
            } elseif ($role === 'rh') {
                return redirect()->to(base_url('rh/conges'));
            } else {
                return redirect()->to(base_url('employe/dashboard'));
            }
        }
        return redirect()->to(base_url('auth/login'));
    }
}
