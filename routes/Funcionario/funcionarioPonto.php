<?php

use App\Http\Controllers\WebControllers\Empresa\VerificarDentroPontosController;
use App\Http\Controllers\WebControllers\Funcionario\FuncionarioPontoController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/funcionario/verificarPonto', [FuncionarioPontoController::class, 'getStatusPonto']);
    //Route::get('/funcionario/ponto/historico', [FuncionarioPontoController::class, 'getHistorico']);
    Route::get('/funcionario/ponto/historico/', [FuncionarioPontoController::class, 'getHistoricoComLimite']);
    Route::post('/funcionario/ponto/inicio', [FuncionarioPontoController::class, 'iniciar']);
    Route::post('/funcionario/ponto/intervalo/inicio', [FuncionarioPontoController::class, 'pausaInicio']);
    Route::post('/funcionario/ponto/intervalo/fim', [FuncionarioPontoController::class, 'pausaFim']);
    Route::post('/funcionario/ponto/fim', [FuncionarioPontoController::class, 'finalizar']);

    //Route::post('/funcionario/ponto/dentro', [VerificarDentroPontosController::class, 'verificarSeEstaDentroDeAlgumPontoLocal']);
});
