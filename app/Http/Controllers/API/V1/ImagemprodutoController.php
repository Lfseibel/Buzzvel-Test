<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\ImagemprodutoFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreImagemprodutoRequest;
use App\Http\Requests\V1\UpdateImagemprodutoRequest;
use App\Http\Resources\V1\ImagemprodutoCollection;
use App\Http\Resources\V1\ImagemprodutoResource;
use App\Models\Imagemproduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImagemprodutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ImagemprodutoFilter();
        $filterItems = $filter->transform($request); //[['column', 'operator', 'value']]
          

        $imagens = Imagemproduto::where($filterItems);

        return new ImagemprodutoCollection($imagens->paginate()->appends($request->query()));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImagemprodutoRequest $request)
    {
        $requestData = $request->all();
        
        $imageName = Str::random(32).".".$request->imagem->getClientOriginalExtension();
        $requestData['imagem'] = $imageName;
        Storage::disk('public')->put($imageName, file_get_contents($request->imagem));
        return new ImagemprodutoResource(Imagemproduto::create($requestData));
    }

    /**
     * Display the specified resource.
     */
    public function show(Imagemproduto $imagemproduto)
    {
        return new ImagemprodutoResource($imagemproduto);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImagemprodutoRequest $request, Imagemproduto $imagemproduto)
    {
        $imagemproduto->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imagemproduto $imagemproduto)
    {
        $imagemproduto->delete();
    }
}
