<?php 
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $currentURL = current_url();

        // Rutas que requieren autenticación
        $protectedRoutes = ['/mis-compras', '/guardar-direccion'];

        // Verificar si la ruta actual está protegida
        $isProtectedRoute = false;
        foreach ($protectedRoutes as $route) {
            if (strpos($currentURL, $route) !== false) {
                $isProtectedRoute = true;
                break;
            }
        }

        if ($isProtectedRoute && !$session->get('usuario_id')) { 
            return redirect()->to('/iniciovalogin'); 
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No necesitamos hacer nada aquí
    }
}