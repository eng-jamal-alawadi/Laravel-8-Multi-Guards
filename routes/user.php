<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;



Route::prefix('user')->name('user.')->group(function () {

    Route::middleware(['guest:web', 'preventBackHistory'])->group(function () {
        Route::view('/login', 'dashboard.user.login')->name('login');
        Route::view('/register', 'dashboard.user.register')->name('register');

        Route::post('/create', [UserController::class, 'create'])->name('create');
        Route::post('/login', [UserController::class, 'login'])->name('login');
    });

    Route::middleware(['auth:web', 'preventBackHistory'])->group(function () {
        Route::view('/home', 'dashboard.user.home')->name('home');
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    });
});
