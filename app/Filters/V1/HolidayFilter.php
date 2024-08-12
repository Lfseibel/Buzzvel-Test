<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class HolidayFilter extends ApiFilter
{
  protected $safeParms = 
  [
    'title' => ['eq', 'lk'],
    'description' => ['eq', 'lk'],
    'date' => ['eq','lt','lte','gte','gt'],
    'location' => ['eq', 'lk'],
    'participants' => ['lk','eq'],
  ];

  protected $columnMap =
  [
    //'primeiroNome' => 'primeiro_nome'
  ];

  protected $operatorMap = 
  [
    'eq' => '=',
    'lt' => '<',
    'lte' => '<=',
    'gte' => '>=',
    'gt' => '>',
    'lk' => 'LIKE',
  ];
}