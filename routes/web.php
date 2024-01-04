<?php

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
    return view('welcome');
});

//handle the role of the user
Route::get('/home',[homeController::class,'index']);

Route::get('register',function(){
    return view('register');
});

Route::post('/registerFunction',[homeController::class,'create'])->name('create');

Route::get('signin',function(){
    return view('signin');
});

Route::post('/loginFunction',[homeController::class,'login'])->name('login');




