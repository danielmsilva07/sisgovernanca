<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubchefiaLider extends Model
{
    protected $table = 'subchefia_lider';
    protected $primaryKey = 'id_sub_lider';

    protected $fillable = [
        'nome_sub_lider',
        'sigla_sub_lider',
    ];

    public function ordens(): HasMany
    {
        return $this->hasMany(OrdemCm::class, 'id_sub_lider', 'id_sub_lider');
    }
}
