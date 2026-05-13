<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $helpers = ['form'];

    private function checkAuth()
    {
        if (!session('logged_in') || session('user_role') !== 'admin') {
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function dashboard()
    {
        $this->checkAuth();

        return view('admin/dashboard', [
            'title' => 'Vue d\'ensemble - TechMada RH',
            'pageTitle' => 'Vue d\'ensemble',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
        ]);
    }

    public function employes()
    {
        $this->checkAuth();

        return view('admin/employes', [
            'title' => 'Gestion des employés - TechMada RH',
            'pageTitle' => 'Gestion des employés',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
        ]);
    }

    public function storeEmploye()
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required',
            'departement' => 'required',
            'role' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Traitement de création d'employé
        session()->setFlashdata('success', 'Employé créé avec succès.');
        return redirect()->to(base_url('admin/employes'));
    }

    public function editEmploye($id = null)
    {
        $this->checkAuth();

        return view('admin/employe_edit', [
            'id' => $id,
            'title' => 'Modifier employé - TechMada RH',
            'pageTitle' => 'Modifier employé',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
        ]);
    }

    public function updateEmploye($id = null)
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'required|valid_email',
            'departement' => 'required',
            'role' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        session()->setFlashdata('success', 'Employé modifié avec succès.');
        return redirect()->to(base_url('admin/employes'));
    }

    public function departements()
    {
        $this->checkAuth();

        return view('admin/departements', [
            'title' => 'Gestion des départements - TechMada RH',
            'pageTitle' => 'Gestion des départements',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
        ]);
    }

    public function typeConge()
    {
        $this->checkAuth();

        return view('admin/types_conge', [
            'title' => 'Types de congé - TechMada RH',
            'pageTitle' => 'Types de congé',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
        ]);
    }

    public function soldes()
    {
        $this->checkAuth();

        return view('admin/soldes', [
            'title' => 'Soldes annuels - TechMada RH',
            'pageTitle' => 'Soldes annuels',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
        ]);
    }
}
