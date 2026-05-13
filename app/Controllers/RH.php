<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\SoldeModel;
use App\Models\TypeCongeModel;
use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class RH extends Controller
{
    protected $helpers = ['form'];
    protected $congeModel;
    protected $soldeModel;
    protected $typeCongeModel;
    protected $employeeModel;

    public function __construct()
    {
        $this->congeModel = new CongeModel();
        $this->soldeModel = new SoldeModel();
        $this->typeCongeModel = new TypeCongeModel();
        $this->employeeModel = new EmployeeModel();
    }

    private function checkAuth()
    {
        if (!session('logged_in') || session('user_role') !== 'rh') {
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function dashboard()
    {
        $this->checkAuth();
        
        // Statistiques
        $stats = [
            'pending' => $this->congeModel->where('status', 'en_attente')->countAllResults(),
            'approved' => $this->congeModel->where('status', 'approuvee')->countAllResults(),
            'refused' => $this->congeModel->where('status', 'refusee')->countAllResults(),
            'employees_count' => $this->employeeModel->where('role', 'employe')->where('actif', true)->countAllResults(),
        ];
        
        // Demandes en attente récentes
        $recentPending = $this->congeModel->getPending();

        return view('rh/dashboard', [
            'title' => 'Tableau de bord - TechMada RH',
            'pageTitle' => 'Tableau de bord',
            'sidebarSubtitle' => 'Espace responsable',
            'sidebarMenu' => view('components/rh_menu'),
            'stats' => $stats,
            'recentPending' => $recentPending,
        ]);
    }

    public function conges()
    {
        $this->checkAuth();
        
        $status = $this->request->getGet('status') ?? 'all';
        
        // Récupérer les demandes avec détails
        $query = $this->congeModel
            ->select('conge.*, employees.prenom as employee_prenom, employees.name as employee_name, type_conge.libelle as type_libelle')
            ->join('employees', 'employees.id = conge.id_employee', 'left')
            ->join('type_conge', 'type_conge.id = conge.id_type_conge', 'left');
        
        if ($status !== 'all') {
            $query = $query->where('conge.status', $status);
        }
        
        $requests = $query->orderBy('conge.created_at', 'DESC')->findAll();
        
        // Ajouter le solde restant à chaque demande
        foreach ($requests as &$req) {
            $solde = $this->soldeModel->getByEmployeeAndType(
                $req['id_employee'],
                $req['id_type_conge']
            );
            $req['solde_restant'] = $solde['restant'] ?? 0;
        }
        
        // Grouper par statut
        $stats = [
            'all' => count($requests),
            'pending' => $this->congeModel->where('status', 'en_attente')->countAllResults(),
            'approved' => $this->congeModel->where('status', 'approuvee')->countAllResults(),
            'refused' => $this->congeModel->where('status', 'refusee')->countAllResults(),
        ];

        return view('rh/conge_index', [
            'title' => 'Demandes à traiter - TechMada RH',
            'pageTitle' => 'Demandes à traiter',
            'sidebarSubtitle' => 'Espace responsable',
            'sidebarMenu' => view('components/rh_menu'),
            'requests' => $requests,
            'stats' => $stats,
            'currentStatus' => $status,
        ]);
    }

    public function approve($id = null)
    {
        $this->checkAuth();
        
        if (!$id) {
            return redirect()->back()->with('error', 'ID invalide.');
        }
        
        $conge = $this->congeModel->find($id);
        if (!$conge) {
            return redirect()->back()->with('error', 'Demande introuvable.');
        }
        
        if ($conge['status'] !== 'en_attente') {
            return redirect()->back()->with('error', 'Seules les demandes en attente peuvent être approuvées.');
        }
        
        // Approuver la demande
        $rhName = session('user_name');
        $this->congeModel->approve($id, $rhName);
        
        // Mettre à jour le solde
        $this->soldeModel->updateAfterApproval(
            $conge['id_employee'],
            $conge['id_type_conge'],
            $conge['nb_jours']
        );
        
        session()->setFlashdata('success', 'Demande approuvée avec succès.');
        return redirect()->to(base_url('rh/conges'));
    }

    public function refuse($id = null)
    {
        $this->checkAuth();
        
        if (!$id) {
            return redirect()->back()->with('error', 'ID invalide.');
        }
        
        $conge = $this->congeModel->find($id);
        if (!$conge) {
            return redirect()->back()->with('error', 'Demande introuvable.');
        }
        
        if ($conge['status'] !== 'en_attente') {
            return redirect()->back()->with('error', 'Seules les demandes en attente peuvent être refusées.');
        }
        
        $commentaire = $this->request->getPost('commentaire') ?? '';
        $rhName = session('user_name');
        
        // Refuser la demande
        $this->congeModel->refuse($id, $commentaire, $rhName);
        
        session()->setFlashdata('success', 'Demande refusée.');
        return redirect()->to(base_url('rh/conges'));
    }

    public function historique()
    {
        $this->checkAuth();
        
        $requests = $this->congeModel
            ->where('status', 'approuvee')
            ->orWhere('status', 'refusee')
            ->orderBy('updated_at', 'DESC')
            ->getWithDetails();

        return view('rh/historique', [
            'title' => 'Historique - TechMada RH',
            'pageTitle' => 'Historique',
            'sidebarSubtitle' => 'Espace responsable',
            'sidebarMenu' => view('components/rh_menu'),
            'requests' => $requests,
        ]);
    }

    public function soldes()
    {
        $this->checkAuth();
        
        $annee = $this->request->getGet('annee') ?? date('Y');
        
        // Récupérer tous les employés avec leurs soldes
        $employees = $this->employeeModel->where('actif', true)->findAll();
        
        $soldeData = [];
        foreach ($employees as $emp) {
            $balances = $this->soldeModel
                ->where('id_employee', $emp['id'])
                ->where('annee', $annee)
                ->findAll();
            
            $soldeData[] = [
                'employee' => $emp,
                'balances' => $balances,
            ];
        }

        return view('rh/soldes', [
            'title' => 'Soldes employés - TechMada RH',
            'pageTitle' => 'Soldes employés',
            'sidebarSubtitle' => 'Espace responsable',
            'sidebarMenu' => view('components/rh_menu'),
            'soldeData' => $soldeData,
            'annee' => $annee,
        ]);
    }
}

