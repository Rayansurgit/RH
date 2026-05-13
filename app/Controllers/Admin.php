<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\DepartmentModel;
use App\Models\TypeCongeModel;
use App\Models\SoldeModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $helpers = ['form'];
    protected $employeeModel;
    protected $departmentModel;
    protected $typeCongeModel;
    protected $soldeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->departmentModel = new DepartmentModel();
        $this->typeCongeModel = new TypeCongeModel();
        $this->soldeModel = new SoldeModel();
    }

    private function checkAuth()
    {
        if (!session('logged_in') || session('user_role') !== 'admin') {
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function dashboard()
    {
        $this->checkAuth();
        
        // Statistiques
        $stats = [
            'total_employees' => $this->employeeModel->countAllResults(),
            'active_employees' => $this->employeeModel->where('actif', true)->countAllResults(),
            'departments' => $this->departmentModel->countAllResults(),
            'leave_types' => $this->typeCongeModel->countAllResults(),
        ];

        return view('admin/dashboard', [
            'title' => 'Vue d\'ensemble - TechMada RH',
            'pageTitle' => 'Vue d\'ensemble',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
            'stats' => $stats,
        ]);
    }

    public function employes()
    {
        $this->checkAuth();
        
        $search = $this->request->getGet('search');
        $department = $this->request->getGet('department');
        
        $query = $this->employeeModel;
        
        if ($search) {
            $query = $query->like('name', $search)
                          ->orLike('prenom', $search)
                          ->orLike('email', $search);
        }
        
        if ($department) {
            $query = $query->where('id_department', $department);
        }
        
        $employees = $query->findAll();
        $departments = $this->departmentModel->findAll();

        return view('admin/employes', [
            'title' => 'Gestion des employés - TechMada RH',
            'pageTitle' => 'Gestion des employés',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
            'employees' => $employees,
            'departments' => $departments,
        ]);
    }

    public function storeEmploye()
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'required|valid_email|is_unique[employees.email]',
            'password' => 'required|min_length[8]',
            'id_department' => 'required|numeric',
            'role' => 'required|in_list[admin,rh,employe]',
            'date_embauche' => 'required|valid_date',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'prenom' => $this->request->getPost('prenom'),
            'name' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'mdp' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'id_department' => $this->request->getPost('id_department'),
            'role' => $this->request->getPost('role'),
            'date_embauche' => $this->request->getPost('date_embauche'),
            'actif' => true,
        ];
        
        $empId = $this->employeeModel->insert($data);
        
        // Initialiser les soldes
        $this->soldeModel->initializeForEmployee($empId, date('Y'));
        
        session()->setFlashdata('success', 'Employé créé avec succès.');
        return redirect()->to(base_url('admin/employes'));
    }

    public function editEmploye($id = null)
    {
        $this->checkAuth();
        
        if (!$id) {
            return redirect()->back()->with('error', 'ID invalide.');
        }
        
        $employee = $this->employeeModel->find($id);
        if (!$employee) {
            return redirect()->back()->with('error', 'Employé introuvable.');
        }
        
        $departments = $this->departmentModel->findAll();

        return view('admin/employe_edit', [
            'id' => $id,
            'title' => 'Modifier employé - TechMada RH',
            'pageTitle' => 'Modifier employé',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
            'employee' => $employee,
            'departments' => $departments,
        ]);
    }

    public function updateEmploye($id = null)
    {
        $this->checkAuth();
        
        if (!$id) {
            return redirect()->back()->with('error', 'ID invalide.');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'required|valid_email',
            'id_department' => 'required|numeric',
            'role' => 'required|in_list[admin,rh,employe]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'prenom' => $this->request->getPost('prenom'),
            'name' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'id_department' => $this->request->getPost('id_department'),
            'role' => $this->request->getPost('role'),
        ];
        
        // Mettre à jour le mot de passe si fourni
        if ($this->request->getPost('password')) {
            $data['mdp'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }
        
        $this->employeeModel->update($id, $data);

        session()->setFlashdata('success', 'Employé modifié avec succès.');
        return redirect()->to(base_url('admin/employes'));
    }
    
    public function deleteEmploye($id = null)
    {
        $this->checkAuth();
        
        if (!$id) {
            return redirect()->back()->with('error', 'ID invalide.');
        }
        
        $this->employeeModel->update($id, ['actif' => false]);
        
        session()->setFlashdata('success', 'Employé désactivé.');
        return redirect()->to(base_url('admin/employes'));
    }

    public function departements()
    {
        $this->checkAuth();
        
        $departments = $this->departmentModel->findAll();

        return view('admin/departements', [
            'title' => 'Gestion des départements - TechMada RH',
            'pageTitle' => 'Gestion des départements',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
            'departments' => $departments,
        ]);
    }
    
    public function storeDepartement()
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|is_unique[departments.name]',
            'description' => 'permit_empty|string',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];
        
        $this->departmentModel->insert($data);
        
        session()->setFlashdata('success', 'Département créé avec succès.');
        return redirect()->to(base_url('admin/departements'));
    }

    public function typeConge()
    {
        $this->checkAuth();
        
        $types = $this->typeCongeModel->findAll();

        return view('admin/types_conge', [
            'title' => 'Types de congé - TechMada RH',
            'pageTitle' => 'Types de congé',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
            'types' => $types,
        ]);
    }
    
    public function storeTypeConge()
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'libelle' => 'required',
            'jours_annuels' => 'required|numeric|greater_than_equal_to[0]',
            'deductible' => 'permit_empty|in_list[0,1]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'libelle' => $this->request->getPost('libelle'),
            'jours_annuels' => $this->request->getPost('jours_annuels'),
            'deductible' => $this->request->getPost('deductible') ? true : false,
        ];
        
        $this->typeCongeModel->insert($data);
        
        session()->setFlashdata('success', 'Type de congé créé avec succès.');
        return redirect()->to(base_url('admin/types_conge'));
    }

    public function soldes()
    {
        $this->checkAuth();
        
        $annee = $this->request->getGet('annee') ?? date('Y');
        
        $stats = $this->soldeModel->getStats($annee);

        return view('admin/soldes', [
            'title' => 'Soldes annuels - TechMada RH',
            'pageTitle' => 'Soldes annuels',
            'sidebarSubtitle' => 'Administration',
            'sidebarMenu' => view('components/admin_menu'),
            'stats' => $stats,
            'annee' => $annee,
        ]);
    }
}

