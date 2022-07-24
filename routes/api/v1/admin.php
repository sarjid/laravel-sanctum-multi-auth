<?php

use App\Http\Controllers\Api\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;



Route::controller(AdminAuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});


Route::middleware('auth:admin-api')->group(function () {

    Route::controller(AdminAuthController::class)->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/me',  'user');
    });
});
