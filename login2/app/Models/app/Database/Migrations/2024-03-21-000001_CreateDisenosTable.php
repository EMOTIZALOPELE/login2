<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDisenosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'cortina' => [
                'type'       => 'ENUM',
                'constraint' => ['si', 'no'],
                'default'    => 'no',
            ],
            'ventana' => [
                'type'       => 'ENUM',
                'constraint' => ['si', 'no'],
                'default'    => 'no',
            ],
            'postigon' => [
                'type'       => 'ENUM',
                'constraint' => ['si', 'no'],
                'default'    => 'no',
            ],
            'fecha_creacion' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('disenos');
    }

    public function down()
    {
        $this->forge->dropTable('disenos');
    }
} 