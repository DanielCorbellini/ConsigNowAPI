<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Attributes\Scope;

class Condicional extends Model
{
    protected  $fillable = [
        "representante_id",
        "data_entrega",
        "data_prevista_retorno",
        "status",
    ];

    protected $table = "condicionais";

    public function representante()
    {
        return $this->belongsTo(Representante::class, "representante_id");
    }

    /**
     * Scope para filtrar condicionais com base em diversos critérios ou não.
     */
    #[Scope]
    protected function comRepresentante(Builder $query, array $filtros): Builder
    {
        $query->select(
            'condicionais.*',
            'users.id as user_id',
            'users.name as user_name'
        )
            ->join('representantes', 'condicionais.representante_id', '=', 'representantes.id')
            ->join('users', 'representantes.user_id', '=', 'users.id');

        $query->when($filtros['representante_id'] ?? null, fn($q, $representanteId) => $q->where('condicionais.representante_id', $representanteId));
        $query->when($filtros['user_name'] ?? null, fn($q, $representanteNome) => $q->where('users.name', 'like', "%{$representanteNome}%"));
        $query->when($filtros['status'] ?? null, fn($q, $status) => $q->where('condicionais.status', $status));

        if (!empty($filtros['data_entrega_inicial']) && !empty($filtros['data_entrega_final'])) {
            $query->whereBetween('condicionais.data_entrega', [$filtros['data_entrega_inicial'], $filtros['data_entrega_final']]);
        }

        if (!empty($filtros['data_retorno_inicial']) && !empty($filtros['data_retorno_final'])) {
            $query->whereBetween('condicionais.data_prevista_retorno', [$filtros['data_retorno_inicial'], $filtros['data_retorno_final']]);
        }

        $query->when($filtros['id'] ?? null, fn($q, $id) => $q->where('condicionais.id', $id));

        return $query;
    }
}
