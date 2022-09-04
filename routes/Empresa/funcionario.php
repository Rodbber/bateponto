<?php

use App\Http\Controllers\WebControllers\Empresa\FuncionarioBatePontoController;
use App\Http\Controllers\WebControllers\Empresa\FuncionarioUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:empresa')->group(function () {
    Route::post('/empresa/funcionario/create', [FuncionarioUserController::class, 'store']);

    Route::get('/empresa/funcionario/batepontos/{id}', [FuncionarioBatePontoController::class, 'show']);


});
