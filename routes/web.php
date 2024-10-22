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
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
    Route::get('/dashboard', [UserController::class, 'index'])
        ->name('users.index');
    Route::get('/users/show/{id}', [UserController::class, 'show'])
        ->name('users.show');
    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])
        ->name('users.edit');
    Route::get('/users/destroy/{id}', [UserController::class, 'destroy'])
        ->name('users.destroy');
    Route::get('/users/store/{id}', [UserController::class, 'store'])
        ->name('users.store');
    Route::get('/users/update/{id}', [UserController::class, 'update'])
        ->name('users.update');
    Route::softDeletes('users', UserController::class);
    Route::get('/logout', function () {
        return view('auth/login');
    });
});
