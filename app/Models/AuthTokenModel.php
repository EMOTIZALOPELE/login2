<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthTokenModel extends Model
{
    protected $table            = 'auth_tokens';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['selector', 'hashed_validator', 'user_id', 'expires'];

    /**
     * Busca un token por su selector.
     */
    public function findBySelector(string $selector)
    {
        return $this->where('selector', $selector)->first();
    }

    /**
     * Borra todos los tokens de un usuario. Útil para el logout.
     */
    public function deleteUserTokens(int $userId)
    {
        return $this->where('user_id', $userId)->delete();
    }
}