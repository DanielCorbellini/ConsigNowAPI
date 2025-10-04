<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CondicionalItem extends Model
{
    protected $fillable = [
        'condicional_id',
        'produto_id',
        'quantidade_entregue',
        'quantidade_devolvida',
        'quantidade_vendida',
    ];

    protected $table = "condicional_itens";

    public function condicional(): BelongsTo
    {
        return $this->belongsTo(Condicional::class, 'condicional_id');
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
