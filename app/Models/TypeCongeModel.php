<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeCongeModel extends Model
{
    protected $table = 'type_conge';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'libelle',
        'jours_annuels',
        'deductible',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'libelle' => 'required|string|max_length[50]|is_unique[type_conge.libelle]',
        'jours_annuels' => 'required|integer|greater_than[0]',
        'deductible' => 'required|in_list[0,1]',
    ];
    protected $validationMessages = [
        'libelle' => [
            'is_unique' => 'Ce type de congé existe déjà.'
        ]
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    protected $casts = [
        'jours_annuels' => 'integer',
        'deductible' => 'boolean'
    ];

    /**
     * Récupère tous les types de congé qui sont déductibles
     */
    public function getDeductible()
    {
        return $this->where('deductible', 1)->findAll();
    }

    /**
     * Récupère tous les types de congé actifs
     */
    public function getActive()
    {
        return $this->findAll();
    }

    /**
     * Récupère un type par son libellé
     */
    public function getByLibelle($libelle)
    {
        return $this->where('libelle', $libelle)->first();
    }
}
