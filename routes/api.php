<?php

use App\Http\Controllers\ClassifierController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function(){
    //Rutas Abiertas
    Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::get('/index', [App\Http\Controllers\Auth\AuthController::class, 'index']);
    /*
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::resource('suppliers', SupplierController::class);
    });
    */
    
    Route::group(['middleware' => ['auth:sanctum']], function(){
        Route::resource('classifiers',ClassifierController::class);
        Route::resource('groups', GroupsController::class);
        Route::resource('suppliers', SupplierController::class);
    });
});