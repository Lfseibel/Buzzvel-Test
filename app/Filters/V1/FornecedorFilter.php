<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class FornecedorFilter extends ApiFilter
{
  protected $safeParms = 
  [
    'nome' => ['eq'],
    'endereco' => ['eq'],
    'email' => ['eq'],
    'senha' => ['eq'],
    'cnpj' => ['eq', 'gt', 'lt'],
    'telefone' => ['eq'],
    'imagemPerfil' => ['eq'],
    'descricao' => ['eq'],
    'tipo' => ['eq'],
    'aberto' => ['eq']
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