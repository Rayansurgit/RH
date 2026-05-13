<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTypeCongeTable extends Migration
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
            'libelle' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'jours_annuels' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'deductible' => [
                'type' => 'BOOLEAN',
                'default' => true,
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
        $this->forge->createTable('type_conge');
    }

    public function down()
    {
        $this->forge->dropTable('type_conge');
    }
}
