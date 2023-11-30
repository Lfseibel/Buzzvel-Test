<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'valor',
        'descricao',
        'fornecedor_id',
        'disponivel'
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function imagens()
    {
        return $this->hasMany(Imagemproduto::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
