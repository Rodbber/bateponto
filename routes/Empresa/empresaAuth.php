<?php

use App\Http\Controllers\WebControllers\Empresa\Auth\AuthenticatedSessionController;
use App\Http\Controllers\WebControllers\Empresa\Auth\ConfirmablePasswordController;
use App\Http\Controllers\WebControllers\Empresa\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\WebControllers\Empresa\Auth\EmailVerificationPromptController;
use App\Http\Controllers\WebControllers\Empresa\Auth\NewPasswordController;
use App\Http\Controllers\WebControllers\Empresa\Auth\RegisteredUserController;
use App\Http\Controllers\WebControllers\Empresa\Auth\VerifyEmailController;

use Illuminate\Support\Facades\Route;

Route::middleware('guest:empresa')->group(function () {
    Route::get('empresa/register', [RegisteredUserController::class, 'create'])
                ->name('empresa.register');

    Route::post('empresa/register', [RegisteredUserController::class, 'store']);

    Route::get('empresa/login', [AuthenticatedSessionController::class, 'create'])
                ->name('empresa.login');

    Route::post('empresa/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('empresa/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('empresa.password.request');

    Route::post('empresa/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('empresa.password.email');

    Route::get('empresa/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('empresa.password.reset');

    Route::post('empresa/reset-password', [NewPasswordController::class, 'store'])
                ->name('empresa.password.update');
});

Route::middleware('auth:empresa')->group(function () {
    Route::get('empresa/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('empresa.verification.notice');

    Route::get('empresa/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('empresa.verification.verify');

    Route::post('empresa/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('empresa.verification.send');

    Route::get('empresa/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('empresa.password.confirm');

    Route::post('empresa/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('empresa/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('empresa.logout');
});
