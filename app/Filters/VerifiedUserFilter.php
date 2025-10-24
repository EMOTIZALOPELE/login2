<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class VerifiedUserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si el usuario no está logueado, dejar que el auth filter se encargue
        if (!session()->get('logged_in')) {
            return;
        }

        // Verificar si el usuario tiene email verificado
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session()->get('id'));

        if ($user && $user['is_verified'] != 1) {
            // Usuario logueado pero no verificado
            session()->destroy();
            return redirect()->to('/iniciovalogin')->with('error', 'Debes verificar tu email antes de acceder al sistema.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacer nada después de la ejecución
    }
}