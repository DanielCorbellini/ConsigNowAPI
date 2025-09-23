<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        "descricao",
        "categoria_id",
        "preco_custo",
        "preco_venda",
    ];

    protected $hidden = ['categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(CategoriasProduto::class, 'categoria_id', 'id');
    }
}
