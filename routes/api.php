<?php

use App\Http\Controllers\API\V1\AdminController;
use App\Http\Controllers\API\V1\ClienteController;
use App\Http\Controllers\API\V1\FornecedorController;
use App\Http\Controllers\API\V1\ImagemprodutoController;
use App\Http\Controllers\API\V1\PedidoController;
use App\Http\Controllers\API\V1\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// 'namespace' => 'App\Http\Controllers\Api\V1'
Route::group(['prefix' => 'v1' ], function(){
    Route::apiResource('fornecedores', FornecedorController::class);
    Route::apiResource('fornecedor', FornecedorController::class, ['show','update','destroy']);
    Route::post('produtos/bulk', [ProdutoController::class, 'bulkStore']);

    
    Route::apiResource('admins', AdminController::class);
    Route::apiResource('produtos', ProdutoController::class);
    Route::apiResource('clientes', ClienteController::class);
    Route::apiResource('pedidos', PedidoController::class);
    Route::apiResource('imagemprodutos', ImagemprodutoController::class);

});
