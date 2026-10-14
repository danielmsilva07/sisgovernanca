<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OmOrigem extends Model
{
    protected $table = 'om_origem';
    protected $primaryKey = 'id_om_origem';

    protected $fillable = [
        'nome_om_origem',
        'sigla_om_origem',
    ];

    public function ordens(): HasMany
    {
        return $this->hasMany(OrdemCm::class, 'id_om_origem', 'id_om_origem');
    }
}
