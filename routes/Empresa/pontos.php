<?php

use App\Http\Controllers\WebControllers\Empresa\PoligonoController;
use App\Http\Controllers\WebControllers\Empresa\QuadrilaterosController;
use App\Http\Controllers\WebControllers\Empresa\VerificarDentroPontosController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:empresa')->group(function () {
    Route::get('empresa/pontos', function () {
        return view('empresa.pontos.pontos');
    })
        ->name('empresa.pontos');

    Route::post('/empresa/pontos/quadrilatero/createPonto', [QuadrilaterosController::class, 'store']);
    Route::post('/empresa/pontos/quadrilatero/update/{id}', [QuadrilaterosController::class, 'edit']);

    Route::post('/empresa/pontos/poligono/createPonto', [PoligonoController::class, 'store']);
    Route::post('/empresa/pontos/poligono/update/{id}', [PoligonoController::class, 'update']);

    Route::post('/empresa/pontos/validarPontoDentro/{id}', [VerificarDentroPontosController::class, 'verificarSeEstaDentroDeAlgumPonto']);

    Route::get('/empresa/pontos/quadrilatero/get', [QuadrilaterosController::class, 'indexEmpresa']);
    Route::get('/empresa/pontos/poligono/get', [PoligonoController::class, 'indexEmpresa']);

    // get pontos desconsiderando desabilitados
    Route::get('/empresa/pontos/quadrilatero/get/ativos', [QuadrilaterosController::class, 'indexEmpresaSemDesabilitados']);
    Route::get('/empresa/pontos/poligono/get/ativos', [PoligonoController::class, 'indexEmpresaSemDesabilitados']);
});
