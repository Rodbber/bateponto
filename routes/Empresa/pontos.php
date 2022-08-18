<?php

use App\Http\Controllers\WebControllers\Empresa\QuadrilaterosController;
use App\Http\Controllers\WebControllers\Empresa\VerificarDentroPontosController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:empresa')->group(function () {
    Route::get('empresa/pontos', function () {
        return view('empresa.pontos.pontos');
    })
        ->name('empresa.pontos');

    Route::post('/empresa/pontos/createPonto', [QuadrilaterosController::class, 'store']);
    Route::post('/empresa/pontos/quadrilatero/update/{id}', [QuadrilaterosController::class, 'edit']);
    Route::post('/empresa/pontos/validarPontoDentro/{id}', [VerificarDentroPontosController::class, 'verificarSeEstaDentroDeAlgumPonto']);
    Route::get('/empresa/pontos/quadrilatero/get', [QuadrilaterosController::class, 'indexEmpresa']);

});
