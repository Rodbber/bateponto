<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:empresa')->group(function () {
    Route::get('empresa/home', function () {
        return view('empresa.home.home');
    })
        ->name('empresa.home');
});
