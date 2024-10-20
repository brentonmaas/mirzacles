<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

if(!Auth::user()) {
    Route::get('/', function () {
        return view('auth/login');
    });
}


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [UserController::class, 'index'])
        ->name('users.index');
    Route::get('/dashboard', [UserController::class, 'index'])
        ->name('users.index');
    Route::get('/logout', function () {
        return view('auth/login');
    });
});
