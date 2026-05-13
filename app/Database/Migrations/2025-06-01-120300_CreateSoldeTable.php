<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSoldeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_employee' => [
                'type' => 'INTEGER',
                'constraint' => 11,
            ],
            'id_type_conge' => [
                'type' => 'INTEGER',
                'constraint' => 11,
            ],
            'annee' => [
                'type' => 'INTEGER',
                'constraint' => 4,
            ],
            'jours_attribues' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'default' => 0,
            ],
            'jours_pris' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'default' => 0,
            ],
            'restant' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'default' => 0,
            ],
            'pris' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', false, true);
        $this->forge->addKey(['id_employee', 'id_type_conge', 'annee']);
        $this->forge->addForeignKey('id_employee', 'employees', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_type_conge', 'type_conge', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('solde');
    }

    public function down()
    {
        $this->forge->dropTable('solde');
    }
}
