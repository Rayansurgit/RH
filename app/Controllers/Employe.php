<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\CongeModel;
use App\Models\SoldeModel;
use App\Models\TypeCongeModel;
use CodeIgniter\Controller;

class Employe extends Controller
{
    protected $helpers = ['form'];
    protected $employeeModel;
    protected $congeModel;
    protected $soldeModel;
    protected $typeCongeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->congeModel = new CongeModel();
        $this->soldeModel = new SoldeModel();
        $this->typeCongeModel = new TypeCongeModel();
    }

    private function checkAuth()
    {
        if (!session('logged_in') || session('user_role') !== 'employe') {
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function dashboard()
    {
        $this->checkAuth();
        
        $userId = session('user_id');
        $annee = date('Y');
        
        // Récupérer les soldes de l'employé
        $soldes = $this->soldeModel->getByEmployee($userId, $annee);
        
        // Pour les soldes, renommer les clés pour la compatibilité avec les vues
        foreach ($soldes as &$solde) {
            $solde['type_name'] = $solde['libelle'] ?? 'Type';
        }
        
        // Récupérer les dernières demandes
        $recentRequests = $this->congeModel
            ->where('id_employee', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->findAll();
        
        // Ajouter les infos de type de congé à chaque demande
        foreach ($recentRequests as &$req) {
            $type = $this->typeCongeModel->find($req['id_type_conge']);
            $req['type_name'] = $type['libelle'] ?? 'Unknown';
        }
        
        // Compter les demandes en attente
        $pendingCount = $this->congeModel
            ->where('id_employee', $userId)
            ->where('status', 'en_attente')
            ->countAllResults();

        return view('employe/dashboard', [
            'title' => 'Tableau de bord - TechMada RH',
            'pageTitle' => 'Tableau de bord',
            'sidebarSubtitle' => 'Espace employé',
            'sidebarMenu' => view('components/employe_menu'),
            'soldes' => $soldes,
            'recentRequests' => $recentRequests,
            'pendingCount' => $pendingCount,
            'annee' => $annee,
        ]);
    }

    public function conges()
    {
        $this->checkAuth();
        
        $userId = session('user_id');
        
        // Récupérer toutes les demandes de l'employé
        $requests = $this->congeModel
            ->where('id_employee', $userId)
            ->orderBy('date_debut', 'DESC')
            ->findAll();
        
        // Ajouter type de congé à chaque demande
        foreach ($requests as &$req) {
            $type = $this->typeCongeModel->find($req['id_type_conge']);
            $req['type_name'] = $type['libelle'] ?? 'Unknown';
        }

        return view('employe/conge_index', [
            'title' => 'Mes demandes de congé - TechMada RH',
            'pageTitle' => 'Mes demandes de congé',
            'sidebarSubtitle' => 'Espace employé',
            'sidebarMenu' => view('components/employe_menu'),
            'requests' => $requests,
        ]);
    }

    public function createConge()
    {
        $this->checkAuth();
        
        $userId = session('user_id');
        $annee = date('Y');
        
        // Récupérer les types de congé disponibles et les soldes
        $types = $this->typeCongeModel->findAll();
        $soldes = $this->soldeModel->getByEmployee($userId);
        
        // Mapper les soldes pour accès rapide
        $soldeMap = [];
        foreach ($soldes as $solde) {
            $soldeMap[$solde['id_type_conge']] = $solde;
        }

        return view('employe/conge_form', [
            'title' => 'Nouvelle demande de congé - TechMada RH',
            'pageTitle' => 'Nouvelle demande de congé',
            'sidebarSubtitle' => 'Espace employé',
            'sidebarMenu' => view('components/employe_menu'),
            'types' => $types,
            'soldes' => $soldeMap,
        ]);
    }

    public function storeConge()
    {
        $this->checkAuth();
        
        $userId = session('user_id');
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'type_conge' => 'required|numeric',
            'date_debut' => 'required|valid_date',
            'date_fin' => 'required|valid_date',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        $dateDebut = $this->request->getPost('date_debut');
        $dateFin = $this->request->getPost('date_fin');
        $typeCongeId = $this->request->getPost('type_conge');
        $motif = $this->request->getPost('motif');
        
        // Valider les dates
        if (strtotime($dateDebut) > strtotime($dateFin)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'La date de fin doit être après la date de début.');
        }
        
        // Vérifier le chevauchement
        if ($this->congeModel->hasOverlap($userId, $dateDebut, $dateFin)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Chevauchement détecté avec une demande existante.');
        }
        
        // Calculer le nombre de jours
        $nbJours = $this->congeModel->calculateDays($dateDebut, $dateFin);
        
        // Vérifier le solde disponible
        $solde = $this->soldeModel->getByEmployeeAndType($userId, $typeCongeId);
        if (!$solde || $solde['restant'] < $nbJours) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Solde insuffisant pour cette demande.');
        }

        // Créer la demande
        $data = [
            'id_employee' => $userId,
            'id_type_conge' => $typeCongeId,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'nb_jours' => $nbJours,
            'motif' => $motif,
            'status' => 'en_attente',
        ];
        
        $this->congeModel->save($data);
        
        session()->setFlashdata('success', 'Votre demande de congé a été soumise avec succès.');
        return redirect()->to(base_url('employe/conges'));
    }
    
    public function cancelConge($id = null)
    {
        $this->checkAuth();
        
        if (!$id) {
            return redirect()->back()->with('error', 'ID invalide.');
        }
        
        $userId = session('user_id');
        
        // Vérifier que la demande appartient à l'employé
        $conge = $this->congeModel->find($id);
        if (!$conge || $conge['id_employee'] != $userId) {
            return redirect()->back()->with('error', 'Accès non autorisé.');
        }
        
        // Vérifier qu'elle n'est pas déjà traitée
        if ($conge['status'] !== 'en_attente') {
            return redirect()->back()->with('error', 'Seules les demandes en attente peuvent être annulées.');
        }
        
        // Annuler la demande
        $this->congeModel->update($id, ['status' => 'annulee']);
        
        session()->setFlashdata('success', 'Demande annulée avec succès.');
        return redirect()->to(base_url('employe/conges'));
    }

    public function profil()
    {
        $this->checkAuth();
        
        $userId = session('user_id');
        $user = $this->employeeModel->find($userId);

        return view('employe/profil', [
            'title' => 'Mon profil - TechMada RH',
            'pageTitle' => 'Mon profil',
            'sidebarSubtitle' => 'Espace employé',
            'sidebarMenu' => view('components/employe_menu'),
            'user' => $user,
        ]);
    }
}

