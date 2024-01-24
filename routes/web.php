<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\cashierController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\superAdminController;
use App\Models\admin;
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
    // return redirect()->to('signin');
    return redirect()->to('/signin');
});


//register
Route::get('register',function(){
    return redirect()->to('/signin');
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
        
        Route::get('/pharamcyDetalis',[superAdminController::class,'pharmacyDetails'])->name('pharmacyDetails');
        Route::post('/pharmacyInfo',[superAdminController::class,'pharmacyInfo'])->name('pharmacyInfo');

        Route::get('/admins',[superAdminController::class,'adminsPage']);
        Route::post('/addAdmin',[superAdminController::class,'addAdmin'])->name('addAdmin');

        Route::get('/settings',[superAdminController::class,'settingsPage']);
        Route::post('/update',[superAdminController::class,'updateFunction'])->name('updateFunctionForSuperAdmin');
    });
});

//admin middleware
Route::middleware(['adminMiddleware'])->group(function () {
    
    //admin pages
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/dashboard', [adminController::class, 'dashboardPage']);

        Route::get('/addCashier',[adminController::class, 'addCashierPage']);
        Route::post('/addCashierFunction',[adminController::class,'addCashier'])->name('addCashierFunction');
       
        Route::get('/addDrug',[adminController::class,'addDrugPage']);
        Route::post('/updateMedicine/{id}',[adminController::class,'updateMedicine'])->name('updateMedicine');
        Route::post('/deleteMedicine',[adminController::class,'deleteMedicine'])->name('deleteMedicine');
        Route::post('/dd',[adminController::class,'dd'])->name('dd');
        Route::post('/addMedicine',[adminController::class,'addMedicine'])->name('addMedicine');

        Route::get('/myStore',[adminController::class,'myStorePage']);
        Route::get('/searchMethod',[adminController::class,'searchMethod'])->name('searchMethod');
       
        Route::get('/orderHistory',[adminController::class,'orderHistoryPage']);
        Route::get('/searchMethodForOrder',[adminController::class,'searchMethodForOrder'])->name('searchMethodForOrder');

        Route::get('/settings',[adminController::class,'settingsPage']);
        Route::post('/updateInfo',[adminController::class,'updateFunction'])->name('updateFunction');

        Route::get('/alternativeMedicines',[adminController::class,'alternativeMedicines']);
        Route::post('/alternativeFunction',[adminController::class,'alternativeFunction'])->name('alternativeFunction');
        Route::post('/delteAlt',[adminController::class,'deleteAlt'])->name('deleteAlt');
    });
});

//cashier middleware
Route::middleware(['cashierMiddleware'])->group(function () {
    
    //cashier pages
    Route::group(['prefix'=>'cashier'],function(){
        Route::get('/medicines',[cashierController::class,'MedcicinesPage']);
        Route::get('/searchMethodCashier',[cashierController::class,'searchMethodForCashier'])->name('searchMethodCashier');

        Route::get('/searchMethodCashier_sell',[cashierController::class,'searchMethodCashier_sell'])->name('searchMethodCashier_sell');
        Route::get('/sellMedicines',[cashierController::class,'sellMedicinesPage']);
        Route::post('/checkOut',[cashierController::class,'checkOut'])->name('checkOut');
        Route::post('/addToCart',[cashierController::class,'addToCart'])->name('addToCart');
        Route::post('/editCart',[cashierController::class,'editCart'])->name('editCart');
        Route::post('/deleteMedicine',[cashierController::class,'deleteMedicine'])->name('deleteMedicine');

        // Route::post('/checkOut',[cashierController::class,'checkOut'])->name('checkOut');

        Route::get('/settings',[cashierController::class,'settingsPage']);
        Route::post('/updateInfo',[cashierController::class,'updateInfo'])->name('updateInfo');

        Route::get('/orderHistory',[cashierController::class,'orderHistoryPage']);
        // Route::post('/ajax_search',[cashierController::class,'ajax_search'])->name('ajax_search');
        Route::get('search',[cashierController::class,'liveSearchTable']);
        Route::get('searchMedicines',[cashierController::class,'liveSearchTableMedicines']);
    });
});

