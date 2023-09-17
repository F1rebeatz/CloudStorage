<?php

use App\Controllers\FilesController;
use App\Controllers\HomeControllers;
use App\Kernel\Router\Route;

return [
    Route::get('/home',[HomeControllers::class, 'index']),
    Route::get('/files', [FilesController::class, 'index'])
 ];
