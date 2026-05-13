<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employees';
    
    protected $allowedFields = [
        'name',
        'prenom',
        'email',
        'role',
        'date_embauche',
        'actif',
        'id_department',
        'mdp'
    ];
}