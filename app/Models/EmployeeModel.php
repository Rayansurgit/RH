<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected string $table = 'employees';
    protected string $primaryKey = 'id';
    protected bool $useAutoIncrement = true;
    protected string $returnType = 'array';
    protected bool $useSoftDeletes = false;
    protected array $allowedFields = [
        'name',
        'prenom',
        'email',
        'role',
        'date_embauche',
        'actif',
        'id_department',
        'mdp',
        'created_at',
        'updated_at'
    ];
    protected bool $useTimestamps = true;
    protected string $dateFormat = 'datetime';
    protected string $createdField = 'created_at';
    protected string $updatedField = 'updated_at';
    protected array $validationRules = [
        'name' => 'required|string|max_length[100]',
        'prenom' => 'required|string|max_length[100]',
        'email' => 'required|valid_email|is_unique[employees.email]',
        'role' => 'required|in_list[employe,rh,admin]',
        'date_embauche' => 'required|valid_date',
        'id_department' => 'required|integer',
        'mdp' => 'required|string|min_length[8]',
    ];
    protected array $validationMessages = [
        'email' => [
            'is_unique' => 'Cet email est déjà utilisé.'
        ]
    ];
    protected bool $skipValidation = false;
    protected bool $cleanValidationRules = true;
    protected array $casts = [
        'date_embauche' => 'date',
        'actif' => 'boolean',
        'id_department' => 'integer'
    ];

    /**
     * Récupère un employé avec son département
     */
    public function getWithDepartment($id)
    {
        return $this->select('employees.*, departments.name as department_name')
            ->join('departments', 'departments.id = employees.id_department', 'left')
            ->find($id);
    }

    /**
     * Récupère tous les employés avec leurs départements
     */
    public function getAllWithDepartments()
    {
        return $this->select('employees.*, departments.name as department_name')
            ->join('departments', 'departments.id = employees.id_department', 'left')
            ->where('employees.actif', 1)
            ->findAll();
    }

    /**
     * Récupère les employés d'un département
     */
    public function getByDepartment($departmentId)
    {
        return $this->where('id_department', $departmentId)
            ->where('actif', 1)
            ->findAll();
    }

    /**
     * Récupère un employé par email
     */
    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Authentifie un employé
     */
    public function authenticate($email, $password)
    {
        $employee = $this->where('email', $email)->where('actif', 1)->first();
        
        if ($employee && password_verify($password, $employee['mdp'])) {
            return $employee;
        }
        
        return null;
    }

    /**
     * Compte les employés actifs
     */
    public function countActive()
    {
        return $this->where('actif', 1)->countAllResults();
    }

    /**
     * Récupère les RH (responsables)
     */
    public function getRH()
    {
        return $this->where('role', 'rh')
            ->where('actif', 1)
            ->findAll();
    }

    /**
     * Récupère les admins
     */
    public function getAdmins()
    {
        return $this->where('role', 'admin')
            ->where('actif', 1)
            ->findAll();
    }
}
