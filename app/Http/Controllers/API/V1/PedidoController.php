<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\PedidoFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StorePedidoRequest;
use App\Http\Requests\V1\UpdatePedidoRequest;
use App\Http\Resources\V1\PedidoCollection;
use App\Http\Resources\V1\PedidoResource;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new PedidoFilter();
        $filterItems = $filter->transform($request); //[['column', 'operator', 'value']]
        

        $pedidos = Pedido::where($filterItems);

        
        $pedidos = $pedidos->with('cliente');
        return new PedidoCollection($pedidos->paginate()->appends($request->query()));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePedidoRequest $request)
    {
        return new PedidoResource(Pedido::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        return new PedidoResource($pedido->with('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePedidoRequest $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
