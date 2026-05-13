<?php

namespace App\Models;

use CodeIgniter\Model;

class CongeModel extends Model
{
    protected $table = 'conge';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_employee',
        'id_type_conge',
        'date_debut',
        'date_fin',
        'nb_jours',
        'motif',
        'status',
        'commentaire',
        'traite_par'
    ];
}