<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nome',
        'cnpj',
        'senha',
        'email',
        'endereco',
        'descricao',
        'imagemPerfil',
        'telefone',
        'tipo',
        'aberto'
    ];


    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
