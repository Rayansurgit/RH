<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeModel extends Model
{
    protected $table = 'solde';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_employee',
        'id_type_conge',
        'annee',
        'jours_attribues',
        'jours_pris',
        'restant',
        'pris'
    ];
}