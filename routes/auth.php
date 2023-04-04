<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');  //view

    Route::post('register', [RegisteredUserController::class, 'store']); //handle the regist form submission

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login'); //get = view login form

    Route::post('login', [AuthenticatedSessionController::class, 'store']); //login form submission

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request'); //get=view forgot-password

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email'); // login form submission

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset'); //get = display password reset form

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store'); //post = masuk ke password reset controller
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
