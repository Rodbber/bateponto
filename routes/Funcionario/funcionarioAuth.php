<?php

use App\Http\Controllers\Webcontrollers\Funcionario\AutenticacaoController;
use Illuminate\Support\Facades\Route;


Route::post('/funcionario/login', [AutenticacaoController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/funcionario/user', [AutenticacaoController::class, 'eu']);
    Route::post('/funcionario/logout', [AutenticacaoController::class, 'logout']);
});
