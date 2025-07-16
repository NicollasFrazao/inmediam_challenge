<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () 
{
    return response()->json(['message' => 'ok']);
});

Route::apiResource('plans', \App\Http\Controllers\PlanController::class, ['only' => 'index']);

Route::apiSingleton('user', \App\Http\Controllers\UserController::class, ['only' => ['show']]);
Route::prefix('user')->group(function () 
{
    Route::prefix('contracts')->group(function () 
    {
        Route::get('/', [\App\Http\Controllers\ContractController::class, 'index']);
        Route::get('current', [\App\Http\Controllers\ContractController::class, 'current']);
    });
});
