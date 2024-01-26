<?php

use App\Http\Controllers\Api\V1\Auth\AuthenticatedController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (Router $router) {

    Route::prefix('auth')->group(
        function (Router $router) {

            $router->post('/register', App\Http\Controllers\Api\V1\Auth\RegisterController::class)
                ->middleware('guest');

            Route::controller(App\Http\Controllers\Api\V1\Auth\TwoFactorController::class)->group(function (Router $router) {
                $router->post('/confirmCode', 'confirmCode')
                    ->middleware(['guest', 'throttle:10,1']);

                $router->post('/resendCode', 'resend')
                    ->middleware(['guest', 'throttle:10,1']);
            });

            Route::controller(AuthenticatedController::class)->group(
                function (Router $router) {
                    $router->post('/logout', 'destroy')
                        ->middleware('auth:sanctum');

                    $router->get('/me', 'me')
                        ->middleware('auth:sanctum');
                }
            );

            $router->post('/login', App\Http\Controllers\Api\V1\Auth\LoginController::class)
                ->middleware(['guest', 'throttle:10,1']);

            $router->post('/forgot-password', [App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController::class, 'store'])
                ->middleware('guest');

            $router->post('/change-password', App\Http\Controllers\Api\V1\Auth\ChangePasswordController::class)
                ->middleware('auth:sanctum');

            $router->post('/close-account', App\Http\Controllers\Api\V1\Auth\CloseAccountController::class)
                ->middleware('auth:sanctum');

            $router->post('/reset-password', [App\Http\Controllers\Api\V1\Auth\NewPasswordController::class, 'store'])
                ->middleware('guest');
        }
    );
});
