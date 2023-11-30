<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class AdminFilter extends ApiFilter
{
  protected $safeParms = 
  [
    'email' => ['eq'],
    'senha' => ['eq'],
  ];

  protected $columnMap =
  [

  ];

  protected $operatorMap = 
  [
    'eq' => '=',
  ];
}