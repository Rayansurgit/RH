<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Employe extends Controller
{
    protected $helpers = ['form'];

    private function checkAuth()
    {
        if (!session('logged_in') || session('user_role') !== 'employe') {
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function dashboard()
    {
        $this->checkAuth();

        return view('employe/dashboard', [
            'title' => 'Tableau de bord - TechMada RH',
            'pageTitle' => 'Tableau de bord',
            'sidebarSubtitle' => 'Espace employé',
            'sidebarMenu' => view('components/employe_menu'),
        ]);
    }

    public function conges()
    {
        $this->checkAuth();

        return view('employe/conge_index', [
            'title' => 'Mes demandes de congé - TechMada RH',
            'pageTitle' => 'Mes demandes de congé',
            'sidebarSubtitle' => 'Espace employé',
            'sidebarMenu' => view('components/employe_menu'),
        ]);
    }

    public function createConge()
    {
        $this->checkAuth();

        return view('employe/conge_form', [
            'title' => 'Nouvelle demande de congé - TechMada RH',
            'pageTitle' => 'Nouvelle demande de congé',
            'sidebarSubtitle' => 'Espace employé',
            'sidebarMenu' => view('components/employe_menu'),
        ]);
    }

    public function storeConge()
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'type_conge' => 'required',
            'date_debut' => 'required|valid_date',
            'date_fin' => 'required|valid_date',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Traitement de la demande
        session()->setFlashdata('success', 'Votre demande de congé a été soumise avec succès.');
        return redirect()->to(base_url('employe/conges'));
    }

    public function profil()
    {
        $this->checkAuth();

        return view('employe/profil', [
            'title' => 'Mon profil - TechMada RH',
            'pageTitle' => 'Mon profil',
            'sidebarSubtitle' => 'Espace employé',
            'sidebarMenu' => view('components/employe_menu'),
        ]);
    }
}
