<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
$admins = glob(__DIR__ . '/Admin/*.php');
foreach ($admins as $file) {
    // prevents including file itself
    if ($file != __FILE__) {
        require($file);
    }
}
$admins = glob(__DIR__ . '/Empresa/*.php');
foreach ($admins as $file) {
    // prevents including file itself
    if ($file != __FILE__) {
        require($file);
    }
}
