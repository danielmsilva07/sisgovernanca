<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubsidioOrdemCm extends Model
{
    protected $table = 'subsidios_ordens_cm';
    protected $primaryKey = 'id_subsidios_ordens_cm';

    protected $fillable = [
        'id_ordens_cm',
        'id_user',
        'medida_adotada',
    ];

    public function ordem(): BelongsTo
    {
        return $this->belongsTo(OrdemCm::class, 'id_ordens_cm', 'id_ordens_cm');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
