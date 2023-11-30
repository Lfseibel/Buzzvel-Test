<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\StoreFornecedorRequest;
use App\Http\Requests\V1\UpdateFornecedorRequest;
use App\Models\Fornecedor;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FornecedorResource;
use App\Http\Resources\V1\FornecedorCollection;
use App\Filters\V1\FornecedorFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new FornecedorFilter();
        $filterItems = $filter->transform($request); //[['column', 'operator', 'value']]
        
        $includeProdutos = $request->query('includeProdutos');  

        $fornecedores = Fornecedor::where($filterItems);

        if($includeProdutos)
        {
            $fornecedores = $fornecedores->with('produtos');
        }
        return new FornecedorCollection($fornecedores->paginate()->appends($request->query()));
    
        

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFornecedorRequest $request)
    {
        $requestData = $request->all();

        if($request->imagem_perfil)
        {
            $imageName = Str::random(32).".".$request->imagem_perfil->getClientOriginalExtension();
            $requestData['imagem_perfil'] = $imageName;
            Storage::disk('public')->put($imageName, file_get_contents($request->imagem_perfil));
        }
        
        return new FornecedorResource(Fornecedor::create($requestData));

    }


    /**
     * Display the specified resource.
     */
    public function show(Fornecedor $fornecedor, Request $request)
    {
        $includeProdutos = $request->query('includeProdutos'); 

        if($includeProdutos)
        {
            return new FornecedorResource($fornecedor->loadMissing('produtos'));
        }

        return new FornecedorResource($fornecedor); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFornecedorRequest $request, Fornecedor $fornecedor)
    {
        $data = [
            'mensagem' => 'Fornecedor '.$fornecedor->nome.' atualizado com sucesso',
        ];
        $fornecedor->update($request->all());
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fornecedor $fornecedor)
    {
        $data = [
            'mensagem' => 'Fornecedor '.$fornecedor->nome.' apagado com sucesso',
        ];

        // Returning JSON response
        
        $fornecedor->delete();
        return response()->json($data);
    }
}
