<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class RH extends Controller
{
    protected $helpers = ['form'];

    private function checkAuth()
    {
        if (!session('logged_in') || session('user_role') !== 'rh') {
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function dashboard()
    {
        $this->checkAuth();

        return view('rh/dashboard', [
            'title' => 'Tableau de bord - TechMada RH',
            'pageTitle' => 'Tableau de bord',
            'sidebarSubtitle' => 'Espace responsable',
            'sidebarMenu' => view('components/rh_menu'),
        ]);
    }

    public function conges()
    {
        $this->checkAuth();

        return view('rh/conge_index', [
            'title' => 'Demandes à traiter - TechMada RH',
            'pageTitle' => 'Demandes à traiter',
            'sidebarSubtitle' => 'Espace responsable',
            'sidebarMenu' => view('components/rh_menu'),
        ]);
    }

    public function approve($id = null)
    {
        $this->checkAuth();

        // Logique d'approbation
        session()->setFlashdata('success', 'Demande approuvée avec succès.');
        return redirect()->to(base_url('rh/conges'));
    }

    public function refuse($id = null)
    {
        $this->checkAuth();

        // Logique de refus
        session()->setFlashdata('success', 'Demande refusée.');
        return redirect()->to(base_url('rh/conges'));
    }

    public function historique()
    {
        $this->checkAuth();

        return view('rh/historique', [
            'title' => 'Historique - TechMada RH',
            'pageTitle' => 'Historique',
            'sidebarSubtitle' => 'Espace responsable',
            'sidebarMenu' => view('components/rh_menu'),
        ]);
    }

    public function soldes()
    {
        $this->checkAuth();

        return view('rh/soldes', [
            'title' => 'Soldes employés - TechMada RH',
            'pageTitle' => 'Soldes employés',
            'sidebarSubtitle' => 'Espace responsable',
            'sidebarMenu' => view('components/rh_menu'),
        ]);
    }
}
