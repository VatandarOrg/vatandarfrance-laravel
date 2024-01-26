<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'can:admin dashboard'])->group(function (Router $router) {

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    $router->resource('files', App\Http\Controllers\Admin\FileController::class)->except(['create', 'show']);
    $router->view('files/create', 'admin.files.create')->name('files.create');


    Route::group(
        ['middleware' => ['can:crud role']],
        function (Router $router) {
            $router->resource('roles', App\Http\Controllers\Admin\RoleController::class)->except(['create', 'show']);
        }
    );

    Route::group(
        ['middleware' => ['can:crud permission']],
        function (Router $router) {
            $router->resource('permissions', App\Http\Controllers\Admin\PermissionController::class)->except(['create', 'show']);
        }
    );

    Route::group(
        ['middleware' => ['can:crud user']],
        function (Router $router) {
            $router->resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show']);
        }
    );
});
