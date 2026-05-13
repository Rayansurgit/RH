<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // Seed Departments
        $this->seedDepartments();

        // Seed Type Conge
        $this->seedTypeConge();

        // Seed Employees
        $this->seedEmployees();

        // Seed Soldes
        $this->seedSoldes();

        // Seed Conges (optional test data)
        $this->seedConges();
    }

    private function seedDepartments()
    {
        $data = [
            [
                'name' => 'IT',
                'description' => 'Département Informatique',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Finance',
                'description' => 'Département Finance',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Marketing',
                'description' => 'Département Marketing',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'RH',
                'description' => 'Département Ressources Humaines',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('departments')->insertBatch($data);
    }

    private function seedTypeConge()
    {
        $data = [
            [
                'libelle' => 'Congé annuel',
                'jours_annuels' => 30,
                'deductible' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'libelle' => 'Congé maladie',
                'jours_annuels' => 10,
                'deductible' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'libelle' => 'Congé spécial',
                'jours_annuels' => 5,
                'deductible' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'libelle' => 'Congé sans solde',
                'jours_annuels' => 0,
                'deductible' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('type_conge')->insertBatch($data);
    }

    private function seedEmployees()
    {
        $data = [
            [
                'name' => 'Rakoto',
                'prenom' => 'Soa',
                'email' => 'soa.rakoto@techmada.mg',
                'role' => 'employe',
                'date_embauche' => '2022-03-01',
                'actif' => 1,
                'id_department' => 1,
                'mdp' => password_hash('emp123456', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Rabe',
                'prenom' => 'Marie',
                'email' => 'marie.rabe@techmada.mg',
                'role' => 'rh',
                'date_embauche' => '2020-01-15',
                'actif' => 1,
                'id_department' => 4,
                'mdp' => password_hash('rh123456', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Fidy',
                'prenom' => 'Tsiry',
                'email' => 'tsiry.fidy@techmada.mg',
                'role' => 'employe',
                'date_embauche' => '2019-07-10',
                'actif' => 1,
                'id_department' => 2,
                'mdp' => password_hash('emp123456', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Andria',
                'prenom' => 'Haja',
                'email' => 'haja.andria@techmada.mg',
                'role' => 'employe',
                'date_embauche' => '2021-05-22',
                'actif' => 1,
                'id_department' => 3,
                'mdp' => password_hash('emp123456', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Admin',
                'prenom' => 'Super',
                'email' => 'admin@techmada.mg',
                'role' => 'admin',
                'date_embauche' => '2020-01-01',
                'actif' => 1,
                'id_department' => 4,
                'mdp' => password_hash('admin123', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Ramarao',
                'prenom' => 'Noro',
                'email' => 'noro.ramarao@techmada.mg',
                'role' => 'employe',
                'date_embauche' => '2021-11-03',
                'actif' => 1,
                'id_department' => 1,
                'mdp' => password_hash('emp123456', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Feno',
                'prenom' => 'Ketaka',
                'email' => 'ketaka.feno@techmada.mg',
                'role' => 'employe',
                'date_embauche' => '2022-08-15',
                'actif' => 1,
                'id_department' => 2,
                'mdp' => password_hash('emp123456', PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('employees')->insertBatch($data);
    }

    private function seedSoldes()
    {
        $employees = $this->db->table('employees')->get()->getResult('array');
        $types = $this->db->table('type_conge')->get()->getResult('array');
        $annee = date('Y');

        $data = [];

        foreach ($employees as $employee) {
            foreach ($types as $type) {
                $data[] = [
                    'id_employee' => $employee['id'],
                    'id_type_conge' => $type['id'],
                    'annee' => $annee,
                    'jours_attribues' => $type['jours_annuels'],
                    'jours_pris' => 0,
                    'restant' => $type['jours_annuels'],
                    'pris' => $type['jours_annuels'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        $this->db->table('solde')->insertBatch($data);
    }

    private function seedConges()
    {
        $data = [
            [
                'id_employee' => 1, // Soa Rakoto
                'id_type_conge' => 1, // Annuel
                'date_debut' => '2025-06-23',
                'date_fin' => '2025-06-27',
                'nb_jours' => 5,
                'motif' => 'Repos familial',
                'status' => 'en_attente',
                'commentaire' => null,
                'traite_par' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_employee' => 1,
                'id_type_conge' => 2, // Maladie
                'date_debut' => '2025-06-02',
                'date_fin' => '2025-06-03',
                'nb_jours' => 2,
                'motif' => 'Virus gastrique',
                'status' => 'approuvee',
                'commentaire' => 'Approuvé',
                'traite_par' => 'Marie Rabe',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_employee' => 3, // Tsiry Fidy
                'id_type_conge' => 2, // Maladie
                'date_debut' => '2025-06-18',
                'date_fin' => '2025-06-19',
                'nb_jours' => 2,
                'motif' => null,
                'status' => 'en_attente',
                'commentaire' => null,
                'traite_par' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_employee' => 4, // Haja Andria
                'id_type_conge' => 1, // Annuel
                'date_debut' => '2025-06-30',
                'date_fin' => '2025-07-04',
                'nb_jours' => 5,
                'motif' => 'Vacances',
                'status' => 'en_attente',
                'commentaire' => null,
                'traite_par' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('conge')->insertBatch($data);
    }
}
