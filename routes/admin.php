<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;





Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware(['guest:admin','preventBackHistory'])->group(function(){
        Route::view('/login','dashboard.admin.login')->name('login');
        Route::view('/register','dashboard.admin.register')->name('register');

        Route::post('/create',[AdminController::class,'create'])->name('create');
        Route::post('/login',[AdminController::class,'login'])->name('login');
    });

    Route::middleware(['auth:admin','preventBackHistory'])->group(function(){
        Route::view('/home','dashboard.admin.home')->name('home');
        Route::post('/logout',[AdminController::class,'logout'])->name('logout');
    });

});
