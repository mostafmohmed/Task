<?php

use App\Http\Controllers\Auth\AuthController ;
use App\Http\Controllers\Auth\AuthgoogleController;
use App\Http\Controllers\Auth\emailveryfycontroller;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\paypalcontroller;
use App\Http\Controllers\ProduectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::get('payment',[paypalcontroller::class,'payment'])->name('payment');
Route::middleware(['auth:sanctum','iscustomer'])->group(function(){
    Route::get('cancel',[paypalcontroller::class,'cancel'])->name('payment.cancel');
    Route::get('payment/success',[paypalcontroller::class,'success'])->name('payment.success');
    Route::controller(CartController::class)->prefix('/Cart')->group(function(){
        Route::get('add','add');
        Route::get('get','get');
        // Route::put('update/{id}','update');
        // Route::delete('delete/{id}','delete');
    });
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/checkout',[OrderController::class,'checkout']);
    Route::get('/user_details',[AuthController::class,'Userdetails']);
    
});



Route::middleware(['auth:sanctum','isAdmin'])->group(function(){
    Route::controller(CategoryController::class)->prefix('/category')->group(function(){
        Route::post('create','create');
        Route::get('get','get');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
    Route::controller(ProduectController::class)->prefix('/Produect')->group(function(){
        Route::post('create','create');
        Route::get('get','get');
        Route::delete('delete/{id}','delete');
        Route::put('update/{id}','update');
      
    });
});



Route::controller(AuthgoogleController::class)->group(function () {
    Route::get('google','redirectToGoogle');
    Route::get('google/callback','handleGoogleCallback');
   
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login/User',[AuthController::class,'login']);
Route::post('/regster',[AuthController::class,'regster']);
