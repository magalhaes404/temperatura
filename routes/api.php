<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemperaturaController;
use App\Http\Controllers\FaixaController;
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

Route::post('/Buscar_Cidade', [ TemperaturaController::class,'temperaturaCidade']);
Route::get('/FaixaPop', [ FaixaController::class,'faixa_pop']);
Route::get('/FaixaRock', [ FaixaController::class,'faixa_rock']);
Route::get('/FaixaFesta', [ FaixaController::class,'faixa_festa']);
Route::get('/FaixaClassicas', [ FaixaController::class,'faixa_classica']);
