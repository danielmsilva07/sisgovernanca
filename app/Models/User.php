<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user'; // Define a chave primária customizada do PostgreSQL

    protected $fillable = [
        'name',
        'email',
        'username',
        'password_hash',
        'two_factor_secret',
        'two_factor_enabled',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    /**
     * Informa ao Laravel para utilizar a coluna 'password_hash' no lugar do padrão 'password'
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function subsidios()
    {
        return $this->hasMany(SubsidioOrdemCm::class, 'id_user', 'id_user');
    }

    public function historicos()
    {
        return $this->hasMany(HistoricoOrdemCm::class, 'id_user', 'id_user');
    }
}