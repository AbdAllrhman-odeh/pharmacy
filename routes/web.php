<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\cashierController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\superAdminController;
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

//superAdmin middleware
Route::middleware(['superAdminMiddleware'])->group(function () {
    
    //superAdmin pages
    Route::group(['prefix' => 'superAdmin'], function () {
        Route::get('/dashboard', [superAdminController::class, 'dashboardPage']);
    });
});

//admin middleware
Route::middleware(['adminMiddleware'])->group(function () {
    
    //admin pages
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/dashboard', [adminController::class, 'dashboardPage']);
    });
});

//cashier middleware
Route::middleware(['cashierMiddleware'])->group(function () {
    
    //cashier pages
    Route::group(['prefix'=>'cashier'],function(){
        Route::get('/dashboard',[cashierController::class,'dashboardPage']);
    });
});



