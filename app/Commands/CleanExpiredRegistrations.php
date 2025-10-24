<?php
namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class CleanExpiredRegistrations extends BaseCommand
{
    protected $group = 'Tasks';
    protected $name = 'clean:expired-registrations';
    protected $description = 'Elimina usuarios no verificados después de 1 hora';

    public function run(array $params)
    {
        $userModel = new UserModel();
        $oneHourAgo = Time::now()->subHours(1);
        
        $result = $userModel->where('is_verified', 0)
                           ->where('expira_verificacion <', $oneHourAgo->toDateTimeString())
                           ->delete();
        
        CLI::write("Eliminados {$result} registros expirados.", 'green');
    }
}