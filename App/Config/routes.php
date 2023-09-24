<?php

use App\Controllers\FilesController;
use App\Controllers\HomeControllers;
use App\Controllers\RegisterController;
use App\Kernel\Router\Route;
use App\Controllers\LoginController;

return [
    Route::get('/home', [HomeControllers::class, 'index']),
    Route::get('/files/list', [FilesController::class, 'list']),
    Route::post('/files/list', [FilesController::class, 'store']),
    Route::get('/register', [RegisterController::class, 'index']),
    Route::post('/register', [RegisterController::class, 'register']),
    Route::get('/login', [LoginController::class, 'index']),
    Route::post('/login', [LoginController::class, 'login']),
    Route::post('/logout', [LoginController::class, 'logout']),

    Route::get('/files/get/{id}', [FilesController::class, 'show']),
//    Route::put('/files/rename/{id}', [FilesController::class, 'rename']),
//    Route::delete('/files/remove/{id}', [FilesController::class, 'remove']),
//    Route::post('/directories/add', [FilesController::class, 'addDirectories']),
//    Route::put('/directories/rename/{id}', [FilesController::class, 'renameDirectory']),
//    Route::get('/directories/get/{id}', [FilesController::class, 'getDirectory']),
//    Route::delete('/directories/delete/{id}', [FilesController::class, 'deleteDirectory'])
];
