<?php

use App\Http\Controllers\WebControllers\Empresa\EmpresaController;
use App\Http\Controllers\WebControllers\Empresa\FuncionarioUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:empresa')->group(function () {
    Route::get('empresa/home', function () {
        return view('empresa.home.home');
    })
        ->name('empresa.home');

    Route::get('/empresa/funcionario/cadastrar', function () {
        return view('empresa.funcionario.cadastro');
    })->name('empresa.funcionario.cadastrar');

    Route::get('/empresa/funcionarios', [FuncionarioUserController::class, 'indexEmpresa']);

    Route::get('empresa/user', [EmpresaController::class, 'showLogada']);
});
