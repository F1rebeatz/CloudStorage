<?php

use App\Controllers\AdminController;
use App\Controllers\FilesController;
use App\Controllers\HomeControllers;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Kernel\Router\Route;

return [
    Route::get('/', [HomeControllers::class, 'index']),
    Route::get('/home', [HomeControllers::class, 'index']),
    Route::get('/files/list', [FilesController::class, 'list'], [AuthMiddleware::class]),
    Route::post('/files/list', [FilesController::class, 'store']),
    Route::get('/files/get/{id}', [FilesController::class, 'show']),
    Route::get('/register', [RegisterController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/register', [RegisterController::class, 'register']),
    Route::get('/login', [LoginController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/login', [LoginController::class, 'login']),
    Route::post('/logout', [LoginController::class, 'logout']),
    Route::get('/admin/users/list', [AdminController::class, 'index'], [AuthMiddleware::class])



//    Route::put('/files/rename/{id}', [FilesController::class, 'rename']),
//    Route::delete('/files/remove/{id}', [FilesController::class, 'remove']),
//    Route::post('/directories/add', [FilesController::class, 'addDirectories']),
//    Route::put('/directories/rename/{id}', [FilesController::class, 'renameDirectory']),
//    Route::get('/directories/get/{id}', [FilesController::class, 'getDirectory']),
//    Route::delete('/directories/delete/{id}', [FilesController::class, 'deleteDirectory'])
];
