<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('jwt.auth')->group(function(){
    Route::apiResource('brand', 'App\Http\Controllers\BrandController',['only' => [ 'index', 'store','show', 'update', 'destroy']]);
    Route::apiResource('car', 'App\Http\Controllers\CarController');
    Route::apiResource('client', 'App\Http\Controllers\ClientController');
    Route::apiResource('rent', 'App\Http\Controllers\RentController');
    Route::apiResource('type', 'App\Http\Controllers\TypeController');

    Route::apiResource('config', 'App\Http\Controllers\ConfigController');
    
    //API AUTH
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
});


Route::post('login', 'App\Http\Controllers\AuthController@login');