<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'senha',
        'email',
        'endereco',
        'cpf',
        'imagem_perfil',
        'telefone'
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
