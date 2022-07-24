<?php

use App\Http\Controllers\Api\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;



Route::controller(AdminAuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

