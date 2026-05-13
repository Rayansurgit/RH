<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'prenom' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'unique' => true,
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'employe',
            ],
            'date_embauche' => [
                'type' => 'DATE',
            ],
            'actif' => [
                'type' => 'INTEGER',
                'default' => 1,
            ],
            'id_department' => [
                'type' => 'INTEGER',
                'constraint' => 11,
            ],
            'mdp' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addKey('email');
        $this->forge->addKey('id_department');
        $this->forge->addForeignKey('id_department', 'departments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('employees');
    }

    public function down()
    {
        $this->forge->dropTable('employees');
    }
}
