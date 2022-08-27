<?php

use App\Http\Controllers\WebControllers\Funcionario\FuncionarioPontoController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/funcionario/verificarPonto', [FuncionarioPontoController::class, 'getStatusPonto']);
});
