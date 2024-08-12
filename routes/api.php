<?php

use App\Http\Controllers\API\V1\HolidayController;
use App\Http\Controllers\API\V1\UserController;
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

// 'namespace' => 'App\Http\Controllers\Api\V1'

Route::post('v1/setup', [UserController::class, 'setup']);

Route::group(['prefix'=>'v1', 'middleware' => 'auth:api'], function()
{
    Route::apiResource('holidays', HolidayController::class, ['only' => ['index', 'store']]);
    Route::apiResource('holiday', HolidayController::class, ['only' => ['show', 'update', 'destroy']]);
    Route::get('pdf/holiday/{id}', [HolidayController::class, 'pdf']);
    Route::post('holidays/bulk', [HolidayController::class, 'bulkStore']);
});


// Route::prefix('v1')->group(function () {
//     Route::apiResource('holidays', HolidayController::class);
//     Route::apiResource('holiday', HolidayController::class, ['only' => ['show', 'update', 'destroy']]);
//     Route::post('holidays/bulk', [HolidayController::class, 'bulkStore']);
// });

