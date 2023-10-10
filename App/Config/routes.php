<?php

use App\Controllers\AdminController;
use App\Controllers\FilesController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Kernel\Router\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/home', [HomeController::class, 'index']),
    Route::get('/files/list', [FilesController::class, 'index'], [AuthMiddleware::class]),
    Route::get('/files/add', [FilesController::class, 'add'], [AuthMiddleware::class]),
    Route::post('/files/add', [FilesController::class, 'store']),
    Route::get('/files/get/', [FilesController::class, 'download']),
    Route::delete('/files/remove/', [FilesController::class, 'delete']),
    Route::get('/files/edit/', [FilesController::class, 'edit']),
    Route::post('/files/edit/', [FilesController::class, 'update']),

    Route::get('/register', [RegisterController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/register', [RegisterController::class, 'register']),
    Route::get('/login', [LoginController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/login', [LoginController::class, 'login']),
    Route::post('/logout', [LoginController::class, 'logout']),

    Route::get('/admin/users/list', [AdminController::class, 'index'], [AuthMiddleware::class]),




];
