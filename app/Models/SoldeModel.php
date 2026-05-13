<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table = 'solde';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_employee',
        'id_type_conge',
        'annee',
        'jours_attribues',
        'jours_pris',
        'restant',
        'pris',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'id_employee' => 'required|integer',
        'id_type_conge' => 'required|integer',
        'annee' => 'required|integer|exact_length[4]',
        'jours_attribues' => 'required|integer|greater_than_equal_to[0]',
        'jours_pris' => 'required|integer|greater_than_equal_to[0]',
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    protected $casts = [
        'annee' => 'integer',
        'jours_attribues' => 'integer',
        'jours_pris' => 'integer',
        'restant' => 'integer',
        'pris' => 'integer',
        'id_employee' => 'integer',
        'id_type_conge' => 'integer'
    ];

    /**
     * Récupère le solde d'un employé pour un type de congé
     */
    public function getByEmployeeAndType($employeeId, $typeCongeId, $annee = null)
    {
        if (!$annee) {
            $annee = date('Y');
        }

        return $this->where('id_employee', $employeeId)
            ->where('id_type_conge', $typeCongeId)
            ->where('annee', $annee)
            ->first();
    }

    /**
     * Récupère tous les soldes d'un employé pour une année
     */
    public function getByEmployee($employeeId, $annee = null)
    {
        if (!$annee) {
            $annee = date('Y');
        }

        return $this->select('solde.*, type_conge.libelle')
            ->join('type_conge', 'type_conge.id = solde.id_type_conge', 'left')
            ->where('solde.id_employee', $employeeId)
            ->where('solde.annee', $annee)
            ->findAll();
    }

    /**
     * Récupère les soldes par type de congé
     */
    public function getByType($typeCongeId, $annee = null)
    {
        if (!$annee) {
            $annee = date('Y');
        }

        return $this->select('solde.*, employees.prenom, employees.name')
            ->join('employees', 'employees.id = solde.id_employee', 'left')
            ->where('solde.id_type_conge', $typeCongeId)
            ->where('solde.annee', $annee)
            ->findAll();
    }

    /**
     * Initialise les soldes pour un employé (nouvelle année)
     */
    public function initializeForEmployee($employeeId, $annee = null)
    {
        if (!$annee) {
            $annee = date('Y');
        }

        $typeCongeModel = new TypeCongeModel();
        $types = $typeCongeModel->findAll();

        foreach ($types as $type) {
            $existing = $this->getByEmployeeAndType($employeeId, $type['id'], $annee);

            if (!$existing) {
                $this->insert([
                    'id_employee' => $employeeId,
                    'id_type_conge' => $type['id'],
                    'annee' => $annee,
                    'jours_attribues' => $type['jours_annuels'],
                    'jours_pris' => 0,
                    'restant' => $type['jours_annuels'],
                    'pris' => 0,
                ]);
            }
        }

        return true;
    }

    /**
     * Calcule le solde restant
     */
    public function calculateRestant($employeeId, $typeCongeId, $annee = null)
    {
        if (!$annee) {
            $annee = date('Y');
        }

        $solde = $this->getByEmployeeAndType($employeeId, $typeCongeId, $annee);

        if ($solde) {
            return $solde['jours_attribues'] - $solde['jours_pris'];
        }

        return 0;
    }

    /**
     * Met à jour le solde après approbation d'un congé
     */
    public function updateAfterApproval($employeeId, $typeCongeId, $nbJours, $annee = null)
    {
        if (!$annee) {
            $annee = date('Y');
        }

        $solde = $this->getByEmployeeAndType($employeeId, $typeCongeId, $annee);

        if ($solde) {
            $nouveauPris = $solde['jours_pris'] + $nbJours;
            $nouveauRestant = $solde['jours_attribues'] - $nouveauPris;

            return $this->update($solde['id'], [
                'jours_pris' => $nouveauPris,
                'restant' => max(0, $nouveauRestant),
                'pris' => max(0, $nouveauRestant),
            ]);
        }

        return false;
    }

    /**
     * Récupère les employés avec solde critique
     */
    public function getCriticalBalance($annee = null, $threshold = 2)
    {
        if (!$annee) {
            $annee = date('Y');
        }

        return $this->select('solde.*, employees.prenom, employees.name, type_conge.libelle')
            ->join('employees', 'employees.id = solde.id_employee', 'left')
            ->join('type_conge', 'type_conge.id = solde.id_type_conge', 'left')
            ->where('solde.annee', $annee)
            ->where('solde.restant <=', $threshold)
            ->findAll();
    }

    /**
     * Récupère les statistiques sur les soldes
     */
    public function getStats($annee = null)
    {
        if (!$annee) {
            $annee = date('Y');
        }

        return $this->select('
            COUNT(DISTINCT solde.id_employee) as total_employees,
            SUM(solde.jours_attribues) as total_allocated,
            SUM(solde.jours_pris) as total_taken,
            SUM(solde.restant) as total_remaining
        ')
            ->where('annee', $annee)
            ->first();
    }

    /**
     * Récupère les soldes pour rapport
     */
    public function getReport($annee = null, $departmentId = null)
    {
        if (!$annee) {
            $annee = date('Y');
        }

        $builder = $this->select('
            employees.prenom,
            employees.name,
            departments.name as department_name,
            type_conge.libelle,
            solde.jours_attribues,
            solde.jours_pris,
            solde.restant
        ')
            ->join('employees', 'employees.id = solde.id_employee', 'left')
            ->join('departments', 'departments.id = employees.id_department', 'left')
            ->join('type_conge', 'type_conge.id = solde.id_type_conge', 'left')
            ->where('solde.annee', $annee);

        if ($departmentId) {
            $builder->where('employees.id_department', $departmentId);
        }

        return $builder->findAll();
    }
}
