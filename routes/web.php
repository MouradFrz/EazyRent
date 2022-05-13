<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Admin\AdminController;
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

Route::middleware(['guest:web','PreventBackHistory'])->group(function(){
    Route::view('/','guestHome')->name('guestHome');
});


// users
Route::prefix('user')->name('user.')->group(function(){

    Route::middleware(['guest:web','PreventBackHistory'])->group(function(){
        Route::view('/login','users.login')->name('login');
        Route::view('/register','users.register')->name('register');
        Route::post('/create',[UserController::class,'create'])->name('create');
        Route::post('/check',[UserController::class,'check'])->name('check');
        });

    Route::middleware(['auth:web','PreventBackHistory'])->group(function(){
        Route::view('/home','guestHome')->name('home');
        Route::post('/logout',[UserController::class,'logout'])->name('logout');
    });
});

//owners
Route::prefix('owner')->name('owner.')->group(function(){

    Route::middleware(['guest:owner','PreventBackHistory'])->group(function(){
        Route::view('/login','owners.login')->name('login');
        Route::view('/register','owners.register')->name('register');
        Route::post('/create',[OwnerController::class,'create'])->name('create');
        Route::post('/check',[OwnerController::class,'check'])->name('check');
        });
    Route::middleware(['auth:owner','PreventBackHistory'])->group(function(){
        Route::view('/home','owners.ownerHome')->name('home');
        Route::post('/logout',[OwnerController::class,'logout'])->name('logout');
    });
});

//admins
Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
        Route::view('/login','admin.login')->name('login');
        Route::post('/check',[AdminController::class,'check'])->name('check');
        });
    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
        Route::view('/dashboard','admin.dashboard')->name('dashboard');
        Route::post('/logout',[AdminController::class,'logout'])->name('logout');
    });
});



