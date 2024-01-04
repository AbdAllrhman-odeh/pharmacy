<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\cashierController;
use App\Http\Controllers\homeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//welcome page
Route::get('/', function () {
    return redirect()->to('signin');
});


//register
Route::get('register',function(){
    return view('register');
});
Route::post('/registerFunction',[homeController::class,'create'])->name('create');

//sing in
Route::get('signin',function(){
    return view('signin');
});
Route::post('/loginFunction',[homeController::class,'login'])->name('login');



Route::middleware(['authMiddleware'])->group(function () {
    
    //admin pages
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/dashboard', [adminController::class, 'dashboardPage']);
    });
});

Route::middleware(['authMiddleware2'])->group(function () {
    
    //cashier pages
    Route::group(['prefix'=>'cashier'],function(){
        Route::get('/dashboard',[cashierController::class,'dashboardPage']);
    });
});



