<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ProfileController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(
    'auth:sanctum'
)->group(function () {

    Route::post(
        '/logout',
        [LogoutController::class, 'logout']
    );

    Route::get(
        '/profile',
        [ProfileController::class, 'profile']
    );

});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout']);
Route::get('/profile', [ProfileController::class, 'profile']);
