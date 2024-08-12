<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
  protected $safeParms = 
  [
  ];

  protected $columnMap =
  [

  ];

  protected $operatorMap = 
  [
  ];

  public function transform(Request $request)
  {
    $eloquentQuery = [];

    foreach ($this->safeParms as $parm => $operators) {
        $query = $request->query($parm);
        if (!isset($query)) {
            continue;
        }
        $column = $this->columnMap[$parm] ?? $parm;
        foreach ($operators as $operator) {
            if (isset($query[$operator])) {
                $value = $query[$operator];
                if ($operator == 'lk') {
                    $value = '%' . $value . '%'; // Adiciona o curinga % para o operador LIKE
                }
                $eloquentQuery[] = [$column, $this->operatorMap[$operator], $value];
            }
        }
    }
    return $eloquentQuery;
  }
}