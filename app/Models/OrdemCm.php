<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdemCm extends Model
{
    protected $table = 'ordens_cm';
    protected $primaryKey = 'id_ordens_cm';

    protected $fillable = [
        'nr_ordem_cm',
        'docum_origem',
        'data_docum',
        'id_om_origem',
        'id_om_resp',
        'id_sub_lider',
        'id_sub_apoio',
        'id_status_ordem',
        'prazo',
        'tema_pauta',
        'determinacao',
        'evento',
        'observacao',
        'data_cumpr',
    ];

    protected $casts = [
        'nr_ordem_cm'  => 'integer',
        'id_sub_apoio' => 'array',
        'data_docum'   => 'date',
        'prazo'        => 'date',
        'data_cumpr'   => 'date',
    ];

    /**
     * Relacionamento com OM de Origem
     */
    public function omOrigem(): BelongsTo
    {
        return $this->belongsTo(OmOrigem::class, 'id_om_origem', 'id_om_origem');
    }

    /**
     * Relacionamento com OM Responsável
     */
    public function omResponsavel(): BelongsTo
    {
        return $this->belongsTo(OmResponsavel::class, 'id_om_resp', 'id_om_resp');
    }

    /**
     * Relacionamento com Subchefia Líder
     */
    public function subchefiaLider(): BelongsTo
    {
        return $this->belongsTo(SubchefiaLider::class, 'id_sub_lider', 'id_sub_lider');
    }

    /**
     * Relacionamento com Status da Ordem
     */
    public function statusOrdem(): BelongsTo
    {
        return $this->belongsTo(StatusOrdem::class, 'id_status_ordem', 'id_status_ordem');
    }

    /**
     * Relacionamento com os Subsídios registrados para a ordem
     */
    public function subsidios(): HasMany
    {
        return $this->hasMany(SubsidioOrdemCm::class, 'id_ordens_cm', 'id_ordens_cm')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Relacionamento com o Histórico de Auditoria da ordem
     */
    public function historicos(): HasMany
    {
        return $this->hasMany(HistoricoOrdemCm::class, 'id_ordens_cm', 'id_ordens_cm')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Retorna a lista formatada de siglas das Subchefias de Apoio selecionadas
     */
    public function getSubchefiasApoioSiglasAttribute(): string
    {
        if (empty($this->id_sub_apoio) || !is_array($this->id_sub_apoio)) {
            return '-';
        }

        $siglas = SubchefiaApoio::whereIn('id_sub_apoio', $this->id_sub_apoio)
            ->pluck('sigla_sub_apoio')
            ->toArray();

        return !empty($siglas) ? implode(', ', $siglas) : '-';
    }

    /**
     * Retorna o último número de ordem cadastrado (ou 1 se não houver)
     */
    public static function getUltimoNumeroOrdem(): int
    {
        $ultimo = self::max('nr_ordem_cm');
        return $ultimo !== null ? (int)$ultimo : 1;
    }

    /**
     * Retorna o próximo número de ordem sugerido
     */
    public static function getProximoNumeroOrdem(): int
    {
        $ultimo = self::max('nr_ordem_cm');
        return $ultimo !== null ? ((int)$ultimo + 1) : 1;
    }
}