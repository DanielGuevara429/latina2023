<?php

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


Route::get('/usuarios','App\Http\Controllers\UsuarioController@index');
Route::post('/usuarios/registrar','App\Http\Controllers\UsuarioController@store');

Route::put('/usuarios/actualizar/{correo}','App\Http\Controllers\UsuarioController@updatePassword');
Route::post('/usuarios/login','App\Http\Controllers\UsuarioController@login');