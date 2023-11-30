<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantidade',
        'data',
        'cliente_id',
        'fornecedor_id',
        'produto_id',
        'status',
        'valor_total',
        'retirada',
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class);
    }
}
