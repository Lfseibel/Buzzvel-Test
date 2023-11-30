<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class ProdutoFilter extends ApiFilter
{
  protected $safeParms = 
  [
    'nome' => ['eq'],
    'descricao' => ['eq'],
    'valor' => ['eq','gt','gte','lt','lte'],
    'fornecedorID' => ['eq'],
    'fornecedor_id' => ['eq'],
    'disponivel' => ['eq', 'ne']
  ];

  protected $columnMap = 
  [
    'fornecedorID' => 'fornecedor_id',
    'categoriaID' => 'categoria_id',
    'medidaID' => 'medida_id'
  ];

  protected $operatorMap = 
  [
    'eq' => '=',
    'lt' => '<',
    'lte' => '<=',
    'gte' => '>=',
    'gt' => '>',
    'ne' => '!='
  ];
}