<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\StoreClienteRequest;
use App\Http\Requests\V1\UpdateClienteRequest;
use App\Models\Cliente;
use App\Http\Controllers\Controller;
use App\Filters\V1\ClienteFilter;
use App\Http\Resources\V1\ClienteCollection;
use App\Http\Resources\V1\ClienteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ClienteFilter();
        $filterItems = $filter->transform($request); //[['column', 'operator', 'value']]
        
        
        $includePedidos = $request->query('includePedidos');  


        $clientes = Cliente::where($filterItems);

        if($includePedidos)
        {
            $clientes = $clientes->with('pedidos');
        }
        return new ClienteCollection($clientes->paginate()->appends($request->query()));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        $requestData = $request->all();
        if($request->imagem_perfil)
        {
            $imageName = Str::random(32).".".$request->imagem_perfil->getClientOriginalExtension();
            $requestData['imagem_perfil'] = $imageName;
            Storage::disk('public')->put($imageName, file_get_contents($request->imagem_perfil));
        }
        
        return new ClienteResource(Cliente::create($requestData));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        return new ClienteResource($cliente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $cliente->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
    }
}
