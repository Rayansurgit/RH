<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $helpers = ['form'];
    protected $employeeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
    }

    public function login()
    {
        // Si déjà connecté, rediriger
        if (session('logged_in')) {
            $role = session('user_role');
            if ($role === 'admin') {
                return redirect()->to(base_url('admin/dashboard'));
            } elseif ($role === 'rh') {
                return redirect()->to(base_url('rh/dashboard'));
            } else {
                return redirect()->to(base_url('employe/dashboard'));
            }
        }

        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Authentifier avec le modèle
            $employee = $this->employeeModel->authenticate($email, $password);
            
            if ($employee) {
                session()->set([
                    'logged_in' => true,
                    'user_id' => $employee['id'],
                    'user_email' => $employee['email'],
                    'user_name' => $employee['prenom'] . ' ' . $employee['name'],
                    'user_role' => $employee['role'],
                    'user_department' => $employee['id_department'],
                    'user_full' => $employee,
                ]);

                // Rediriger selon le rôle
                if ($employee['role'] === 'admin') {
                    return redirect()->to(base_url('admin/dashboard'));
                } elseif ($employee['role'] === 'rh') {
                    return redirect()->to(base_url('rh/dashboard'));
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
