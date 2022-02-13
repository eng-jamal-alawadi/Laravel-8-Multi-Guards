<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorsController;




Route::prefix('doctor')->name('doctor.')->group(function(){

    Route::middleware('guest:doctor','preventBackHistory')->group(function(){
        Route::view('/login','dashboard.doctor.login')->name('login');
        Route::view('/register','dashboard.doctor.register')->name('register');

        Route::post('/create',[DoctorsController::class,'create'])->name('create');
        Route::post('/login',[DoctorsController::class,'login'])->name('login');



    });

    Route::middleware('auth:doctor','preventBackHistory')->group(function(){
        Route::view('/home','dashboard.doctor.home')->name('home');
        Route::post('/logout',[DoctorsController::class,'logout'])->name('logout');
    });

});
