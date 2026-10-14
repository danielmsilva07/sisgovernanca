<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OmResponsavel extends Model
{
    protected $table = 'om_responsavel';
    protected $primaryKey = 'id_om_resp';

    protected $fillable = [
        'nome_om_resp',
        'sigla_om_resp',
    ];

    public function ordens(): HasMany
    {
        return $this->hasMany(OrdemCm::class, 'id_om_resp', 'id_om_resp');
    }
}
