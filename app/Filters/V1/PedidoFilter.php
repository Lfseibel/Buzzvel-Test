<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class PedidoFilter extends ApiFilter
{
  protected $safeParms = 
  [
    'quantidade' => ['eq','lt','gt','lte','gte'],
    'data' => ['eq','lt','gt','lte','gte'],
    'produto_id' => ['eq'],
    'cliente_id' => ['eq'],
    'fornecedor_id' => ['eq'],
    'valor_total' => ['eq'],
    'retirada' => ['eq'],
    'status' => ['eq'],
  ];

  protected $columnMap =
  [

  ];

  protected $operatorMap = 
  [
    'eq' => '=',
    'lt' => '<',
    'lte' => '<=',
    'gte' => '>=',
    'gt' => '>'//in /like
  ];
}