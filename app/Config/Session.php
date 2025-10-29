<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Session extends BaseConfig
{
    public string $driver = 'CodeIgniter\Session\Handlers\FileHandler';
    public string $cookieName = 'ci_session';
    
    // Duración de la sesión en segundos (ej. 2 horas).
    // Esto es para sesiones activas, pero la siguiente línea es la más importante.
    public int $expiration = 3100; 

    public string $savePath = WRITEPATH . 'session';
    public bool $matchIP = false;
    public int $timeToUpdate = 300;
    public bool $regenerateDestroy = false;
    
    // ... otras configuraciones ...

    // ===== ¡AQUÍ ESTÁ LA LÍNEA MÁS IMPORTANTE! =====
    /**
     * --------------------------------------------------------------------------
     * Expire on Close?
     * --------------------------------------------------------------------------
     *
     * Si está en `true`, la cookie de sesión se creará para que se elimine
     * automáticamente cuando el usuario cierre su navegador. Esto es lo que
     * queremos para sesiones normales que no usan "Recuérdame".
     */
    public bool $expireOnClose = true;
    // =================================================

}