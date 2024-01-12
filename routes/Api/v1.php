<?php

use App\Http\Controllers\Api\V1\Auth\AuthenticatedController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (Router $router) {

    Route::prefix('auth')->group(
        function (Router $router) {
            Route::controller(AuthenticatedController::class)->group(
                function (Router $router) {
                    $router->post('/logout', 'destroy')
                        ->middleware('auth:sanctum')
                        ->name('logout');

                    $router->get('/me', 'me')
                        ->middleware('auth:sanctum')
                        ->name('me');

                    $router->get('/isValid/{username}', 'isValidUsername');
                }
            );

            $router->post('/login', App\Http\Controllers\Api\V1\Auth\LoginController::class)
                ->middleware('guest')
                ->name('login');


            $router->post('/socialite', App\Http\Controllers\Api\V1\Auth\SocialiteController::class)
                ->middleware('guest')
                ->name('socialite');

            $router->post('/register', App\Http\Controllers\Api\V1\Auth\RegisterController::class)
                ->middleware('guest')
                ->name('register');

            $router->post('/forgot-password', [App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

            $router->post('/change-password', App\Http\Controllers\Api\V1\Auth\ChangePasswordController::class)
                ->middleware('auth:sanctum')
                ->name('change.password');

            $router->post('/close-account', App\Http\Controllers\Api\V1\Auth\CloseAccountController::class)
                ->middleware('auth:sanctum')
                ->name('close.account');

            $router->post('/reset-password', [App\Http\Controllers\Api\V1\Auth\NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.store');
        }
    );
});
