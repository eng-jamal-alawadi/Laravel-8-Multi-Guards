<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//------------------------------Users------------------------------------------------

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
//-------------------------------Admins-----------------------------------------------
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
//--------------------------------Doctors----------------------------------------------

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
