<?php

use App\Http\Controllers\WebControllers\Funcionario\FuncionarioPontoController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/funcionario/verificarPonto', [FuncionarioPontoController::class, 'getStatusPonto']);
    Route::post('/funcionario/ponto/inicio', [FuncionarioPontoController::class, 'iniciar']);
    //Route::post('/funcionario/ponto/pausa', [FuncionarioPontoController::class, 'pausar']);
    Route::post('/funcionario/ponto/fim', [FuncionarioPontoController::class, 'finalizar']);
});
