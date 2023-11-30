<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\AdminFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreAdminRequest;
use App\Http\Requests\V1\UpdateAdminRequest;
use App\Http\Resources\V1\AdminCollection;
use App\Http\Resources\V1\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new AdminFilter();
        $filterItems = $filter->transform($request); //[['column', 'operator', 'value']]
        


        $admins = Admin::where($filterItems);

        
        return new AdminCollection($admins->paginate()->appends($request->query()));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        return new AdminResource(Admin::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return new AdminResource($admin);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $admin->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $data = [
            'mensagem' => 'Produto '.$admin->email.' apagado com sucesso',
        ];

        // Returning JSON response
        
        $admin->delete();
        return response()->json($data);
    }
}
