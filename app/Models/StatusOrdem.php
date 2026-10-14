<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusOrdem extends Model
{
    protected $table = 'status_ordem';
    protected $primaryKey = 'id_status_ordem';

    protected $fillable = [
        'nome_status_ordem',
    ];

    public function ordens(): HasMany
    {
        return $this->hasMany(OrdemCm::class, 'id_status_ordem', 'id_status_ordem');
    }
}
