<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToServos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('servos', [
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('servos', 'updated_at');
    }
} 