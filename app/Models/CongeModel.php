<?php

namespace App\Models;

use CodeIgniter\Model;

class CongeModel extends Model
{
    protected $table = 'conge';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_employee',
        'id_type_conge',
        'date_debut',
        'date_fin',
        'nb_jours',
        'motif',
        'status',
        'commentaire',
        'traite_par',
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
        'date_debut' => 'required|valid_date',
        'date_fin' => 'required|valid_date',
        'nb_jours' => 'required|integer|greater_than[0]',
        'status' => 'required|in_list[en_attente,approuvee,refusee,annulee]',
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'nb_jours' => 'integer',
        'id_employee' => 'integer',
        'id_type_conge' => 'integer'
    ];

    /**
     * Récupère une demande avec détails employé et type de congé
     */
    public function getWithDetails($id)
    {
        return $this->select('conge.*, employees.prenom, employees.name, employees.email, type_conge.libelle, departments.name as department_name')
            ->join('employees', 'employees.id = conge.id_employee', 'left')
            ->join('type_conge', 'type_conge.id = conge.id_type_conge', 'left')
            ->join('departments', 'departments.id = employees.id_department', 'left')
            ->find($id);
    }

    /**
     * Récupère tous les congés d'un employé
     */
    public function getByEmployee($employeeId)
    {
        return $this->select('conge.*, type_conge.libelle')
            ->join('type_conge', 'type_conge.id = conge.id_type_conge', 'left')
            ->where('id_employee', $employeeId)
            ->orderBy('date_debut', 'DESC')
            ->findAll();
    }

    /**
     * Récupère les demandes en attente
     */
    public function getPending()
    {
        return $this->select('conge.*, employees.prenom, employees.name, type_conge.libelle, departments.name as department_name')
            ->join('employees', 'employees.id = conge.id_employee', 'left')
            ->join('type_conge', 'type_conge.id = conge.id_type_conge', 'left')
            ->join('departments', 'departments.id = employees.id_department', 'left')
            ->where('conge.status', 'en_attente')
            ->orderBy('conge.created_at', 'ASC')
            ->findAll();
    }

    /**
     * Récupère les demandes approuvées
     */
    public function getApproved()
    {
        return $this->where('status', 'approuvee')
            ->orderBy('date_debut', 'DESC')
            ->findAll();
    }

    /**
     * Récupère l'historique (demandes traitées)
     */
    public function getHistory($limit = null)
    {
        $builder = $this->select('conge.*, employees.prenom, employees.name, type_conge.libelle')
            ->join('employees', 'employees.id = conge.id_employee', 'left')
            ->join('type_conge', 'type_conge.id = conge.id_type_conge', 'left')
            ->whereIn('conge.status', ['approuvee', 'refusee'])
            ->orderBy('conge.updated_at', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->findAll();
    }

    /**
     * Approuve une demande de congé
     */
    public function approve($id, $traitePar = null)
    {
        return $this->update($id, [
            'status' => 'approuvee',
            'traite_par' => $traitePar,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Refuse une demande de congé
     */
    public function refuse($id, $commentaire = null, $traitePar = null)
    {
        return $this->update($id, [
            'status' => 'refusee',
            'commentaire' => $commentaire,
            'traite_par' => $traitePar,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Annule une demande de congé
     */
    public function cancel($id)
    {
        return $this->update($id, [
            'status' => 'annulee',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Compte les demandes en attente
     */
    public function countPending()
    {
        return $this->where('status', 'en_attente')->countAllResults();
    }

    /**
     * Compte les demandes approuvées ce mois
     */
    public function countApprovedThisMonth()
    {
        $currentMonth = date('Y-m');
        return $this->where('status', 'approuvee')
            ->where("DATE_FORMAT(created_at, '%Y-%m')", $currentMonth)
            ->countAllResults();
    }

    /**
     * Vérifie s'il y a un chevauchement
     */
    public function hasOverlap($employeeId, $dateDebut, $dateFin, $excludeId = null)
    {
        $builder = $this->where('id_employee', $employeeId)
            ->whereIn('status', ['en_attente', 'approuvee'])
            ->where('date_debut <=', $dateFin)
            ->where('date_fin >=', $dateDebut);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() > 0;
    }

    /**
     * Récupère les congés pour une période donnée
     */
    public function getForPeriod($dateDebut, $dateFin)
    {
        return $this->select('conge.*, employees.prenom, employees.name, type_conge.libelle')
            ->join('employees', 'employees.id = conge.id_employee', 'left')
            ->join('type_conge', 'type_conge.id = conge.id_type_conge', 'left')
            ->where('conge.date_debut >=', $dateDebut)
            ->where('conge.date_fin <=', $dateFin)
            ->where('conge.status', 'approuvee')
            ->findAll();
    }

    /**
     * Récupère les demandes par département
     */
    public function getByDepartment($departmentId, $status = null)
    {
        $builder = $this->select('conge.*, employees.prenom, employees.name, type_conge.libelle')
            ->join('employees', 'employees.id = conge.id_employee', 'left')
            ->join('type_conge', 'type_conge.id = conge.id_type_conge', 'left')
            ->where('employees.id_department', $departmentId);

        if ($status) {
            $builder->where('conge.status', $status);
        }

        return $builder->findAll();
    }

    /**
     * Calcule le nombre de jours
     */
    public static function calculateDays($dateDebut, $dateFin)
    {
        $debut = new \DateTime($dateDebut);
        $fin = new \DateTime($dateFin);
        $interval = $debut->diff($fin);
        return $interval->days + 1; // +1 pour inclure les deux dates
    }
}
