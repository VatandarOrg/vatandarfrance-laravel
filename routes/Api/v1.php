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

            $router->post('/forgot-password/email', [App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController::class, 'email'])
                ->middleware('guest');

            $router->post('/forgot-password/mobile', [App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController::class, 'mobile'])
                ->middleware('guest');

            $router->post('/reset-password/email', [App\Http\Controllers\Api\V1\Auth\NewPasswordController::class, 'email'])
                ->middleware('guest');

            $router->post('/reset-password/mobile', [App\Http\Controllers\Api\V1\Auth\NewPasswordController::class, 'mobile'])
                ->middleware('guest');

            $router->post('/change-password', App\Http\Controllers\Api\V1\Auth\ChangePasswordController::class)
                ->middleware('auth:sanctum');

            $router->post('/close-account', App\Http\Controllers\Api\V1\Auth\CloseAccountController::class)
                ->middleware('auth:sanctum');
        }
    );

    $router->get('/payments', App\Http\Controllers\Api\V1\Subscription\PaymentIndexController::class)
        ->middleware('auth:sanctum');

    $router->get('/subscription/create', App\Http\Controllers\Api\V1\Subscription\PaymentCreateController::class)
        ->middleware('auth:sanctum');

    $router->get('/subscription/callback', App\Http\Controllers\Api\V1\Subscription\PaymentCallbackController::class)
        ->name('subscription.callback');

    $router->get('/subscription/callback/cancel', App\Http\Controllers\Api\V1\Subscription\PaymentCallbackCancelController::class)
        ->name('subscription.callback.cancel');

    $router->get('/subscription/cancel/{subscription_id}', App\Http\Controllers\Api\V1\Subscription\PaymentCancelController::class)->middleware('auth:sanctum');

    $router->get('/home', App\Http\Controllers\Api\V1\HomeController::class);
});
