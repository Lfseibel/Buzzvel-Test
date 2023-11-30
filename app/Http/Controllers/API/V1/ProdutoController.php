<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\BulkStoreProdutoRequest;
use App\Http\Requests\V1\StoreProdutoRequest;
use App\Http\Requests\V1\UpdateProdutoRequest;
use App\Models\Produto;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProdutoResource;
use App\Http\Resources\V1\ProdutoCollection;
use App\Filters\V1\ProdutoFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ProdutoFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]
        
        if(count($queryItems) == 0) 
        {
            return new ProdutoCollection(Produto::paginate());
        }
        else
        {
            $produtos = Produto::where($queryItems)->paginate();
            return new ProdutoCollection($produtos->appends($request->query()));
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdutoRequest $request)
    {
        return new ProdutoResource(Produto::create($request->all()));
    }

    public function bulkStore(BulkStoreProdutoRequest $request)
    {
        $bulk = collect($request->all())->map(function($arr, $key)
        {
            return Arr::except($arr, ['fornecedorID']);
        });

        Produto::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        return new ProdutoResource($produto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        $produto->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        $data = [
            'mensagem' => 'Produto '.$produto->nome.' apagado com sucesso',
        ];

        // Returning JSON response
        
        $produto->delete();
        return response()->json($data);
    }
}
