<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoOrdemCm extends Model
{
    protected $table = 'historico_ordens_cm';
    protected $primaryKey = 'id_historico_ordens_cm';

    public $timestamps = false; // Usa apenas created_at

    protected $fillable = [
        'id_ordens_cm',
        'id_user',
        'tipo_acao',
        'dados_anteriores',
        'dados_novos',
        'created_at',
    ];

    protected $casts = [
        'dados_anteriores' => 'array',
        'dados_novos'      => 'array',
        'created_at'       => 'datetime',
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
