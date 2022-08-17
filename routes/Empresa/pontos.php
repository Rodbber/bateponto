<?php

use App\Http\Controllers\WebControllers\Empresa\QuadrilaterosController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:empresa')->group(function () {
    Route::get('empresa/pontos', function () {
        return view('empresa.pontos.pontos');
    })
        ->name('empresa.pontos');

    Route::post('/empresa/pontos/createPonto', [QuadrilaterosController::class, 'store']);
});
