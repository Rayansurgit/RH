<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeCongeModel extends Model
{
    protected $table = 'type_conge';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'libelle',
        'jours_annuels',
        'deductible'
    ];
}