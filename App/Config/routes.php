<?php

use App\Controllers\AdminController;
use App\Controllers\DirectoryController;
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
    Route::post('/files/add', [FilesController::class, 'store'], [AuthMiddleware::class]),
    Route::get('/files/get/{id}', [FilesController::class, 'download'], [AuthMiddleware::class]),
    Route::delete('/files/remove/{id}', [FilesController::class, 'delete'], [AuthMiddleware::class]),
    Route::post('/files/edit/', [FilesController::class, 'update'],[AuthMiddleware::class]),
    Route::get('/files/edit/{id}', [FilesController::class, 'edit'],[AuthMiddleware::class]),

    Route::get('/directories/add', [DirectoryController::class, 'add'], [AuthMiddleware::class]),
    Route::post('/directories/add', [DirectoryController::class, 'create'], [AuthMiddleware::class]),
    Route::get('/directories/get/{id}', [DirectoryController::class, 'index'], [AuthMiddleware::class]),
    Route::delete('/directories/remove/{id}', [DirectoryController::class, 'delete'],[AuthMiddleware::class]),
    Route::get('/directories/edit/{id}', [DirectoryController::class, 'edit'],[AuthMiddleware::class]),


    Route::get('/register', [RegisterController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/register', [RegisterController::class, 'register']),
    Route::get('/login', [LoginController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/login', [LoginController::class, 'login']),
    Route::post('/logout', [LoginController::class, 'logout']),

    Route::get('/admin/users/list', [AdminController::class, 'index'], [AuthMiddleware::class]),

];
