<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCongeTable extends Migration
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
            'date_debut' => [
                'type' => 'DATE',
            ],
            'date_fin' => [
                'type' => 'DATE',
            ],
            'nb_jours' => [
                'type' => 'INTEGER',
                'constraint' => 11,
            ],
            'motif' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'en_attente',
            ],
            'commentaire' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'traite_par' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
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
        $this->forge->addKey(['id_employee', 'date_debut', 'date_fin']);
        $this->forge->addKey('status');
        $this->forge->addForeignKey('id_employee', 'employees', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_type_conge', 'type_conge', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('conge');
    }

    public function down()
    {
        $this->forge->dropTable('conge');
    }
}
