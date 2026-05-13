<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $helpers = ['form'];

    public function login()
    {
        // Si déjà connecté, rediriger
        if (session('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Validation simple (à améliorer avec une vraie base de données)
            $credentials = [
                'admin@techmada.mg' => ['password' => 'admin123', 'name' => 'Administrateur', 'role' => 'admin'],
                'rh@techmada.mg' => ['password' => 'rh123', 'name' => 'Marie Rabe', 'role' => 'rh'],
                'employe@techmada.mg' => ['password' => 'emp123', 'name' => 'Soa Rakoto', 'role' => 'employe'],
            ];

            if (isset($credentials[$email]) && $credentials[$email]['password'] === $password) {
                session()->set([
                    'logged_in' => true,
                    'user_email' => $email,
                    'user_name' => $credentials[$email]['name'],
                    'user_role' => $credentials[$email]['role'],
                    'user_id' => md5($email),
                ]);

                // Rediriger selon le rôle
                $role = $credentials[$email]['role'];
                if ($role === 'admin') {
                    return redirect()->to(base_url('admin/dashboard'));
                } elseif ($role === 'rh') {
                    return redirect()->to(base_url('rh/conges'));
                } else {
                    return redirect()->to(base_url('employe/dashboard'));
                }
            }

            session()->setFlashdata('error', 'Identifiants incorrects. Veuillez réessayer.');
        }

        return view('auth/login', [
            'title' => 'Connexion - TechMada RH',
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'));
    }

    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'prenom' => 'required',
                'nom' => 'required',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[8]',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            // Traitement de l'enregistrement
            session()->setFlashdata('success', 'Inscription réussie. Vous pouvez vous connecter.');
            return redirect()->to(base_url('auth/login'));
        }

        return view('auth/register', [
            'title' => 'Inscription - TechMada RH',
        ]);
    }
}
