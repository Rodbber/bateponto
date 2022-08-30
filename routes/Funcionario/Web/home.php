<?php
use Illuminate\Support\Facades\Route;

Route::middleware('auth:funcionario')->group(function () {
    Route::get('funcionario/home', function () {
        return view('funcionario.home.home');
    })
        ->name('funcionario.home');
});
