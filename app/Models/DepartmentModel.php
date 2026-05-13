<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartmentModel extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name',
        'description',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name' => 'required|string|max_length[50]|is_unique[departments.name]',
        'description' => 'permit_empty|string',
    ];
    protected $validationMessages = [
        'name' => [
            'is_unique' => 'Ce département existe déjà.'
        ]
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Récupère un département par son nom
     */
    public function getByName($name)
    {
        return $this->where('name', $name)->first();
    }

    /**
     * Compte les employés d'un département
     */
    public function countEmployees($departmentId)
    {
        return $this->db->table('employees')
            ->where('id_department', $departmentId)
            ->where('actif', 1)
            ->countAllResults();
    }

    /**
     * Récupère les statistiques d'un département
     */
    public function getStats($departmentId)
    {
        $employeeCount = $this->countEmployees($departmentId);
        $congeCount = $this->db->table('conge')
            ->whereIn('status', ['en_attente', 'approuvee'])
            ->where('id_employee IN (SELECT id FROM employees WHERE id_department = ' . $departmentId . ')')
            ->countAllResults();

        return [
            'department_id' => $departmentId,
            'employee_count' => $employeeCount,
            'pending_conge' => $congeCount
        ];
    }
}
