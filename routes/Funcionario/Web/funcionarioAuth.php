<?php

use App\Http\Controllers\WebControllers\Funcionario\Auth\AuthenticatedSessionController;
use App\Http\Controllers\WebControllers\Funcionario\Auth\ConfirmablePasswordController;
use App\Http\Controllers\WebControllers\Funcionario\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\WebControllers\Funcionario\Auth\EmailVerificationPromptController;
use App\Http\Controllers\WebControllers\Funcionario\Auth\NewPasswordController;
use App\Http\Controllers\WebControllers\Funcionario\Auth\RegisteredUserController;
use App\Http\Controllers\WebControllers\Funcionario\Auth\VerifyEmailController;

use Illuminate\Support\Facades\Route;

Route::middleware('guest:funcionario')->group(function () {
    /* Route::get('funcionario/register', [RegisteredUserController::class, 'create'])
                ->name('funcionario.register');

    Route::post('funcionario/register', [RegisteredUserController::class, 'store']); */

    Route::get('funcionario/login', [AuthenticatedSessionController::class, 'create'])
                ->name('funcionario.login');

    Route::post('funcionario/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('funcionario/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('funcionario.password.request');

    Route::post('funcionario/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('funcionario.password.email');

    Route::get('funcionario/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('funcionario.password.reset');

    Route::post('funcionario/reset-password', [NewPasswordController::class, 'store'])
                ->name('funcionario.password.update');
});

Route::middleware('auth:funcionario')->group(function () {
    Route::get('funcionario/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('funcionario.verification.notice');

    Route::get('funcionario/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('funcionario.verification.verify');

    Route::post('funcionario/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('funcionario.verification.send');

    Route::get('funcionario/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('funcionario.password.confirm');

    Route::post('funcionario/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('funcionario/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('funcionario.logout');
});
