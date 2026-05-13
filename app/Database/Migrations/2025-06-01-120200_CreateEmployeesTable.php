<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
                'type' => 'ENUM',
                'constraint' => ['admin', 'rh', 'employe'],
                'default' => 'employe',
            ],
            'date_embauche' => [
                'type' => 'DATE',
            ],
            'actif' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'id_department' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
