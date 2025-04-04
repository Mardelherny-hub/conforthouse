<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPropertyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminClientController;
use App\Http\Controllers\Admin\AdminCaracteristicController;

// Rutas protegidas para administración
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard de administración
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


    // CRUD de propiedades en el panel de administración
    Route::resource('properties', AdminPropertyController::class);

     // CRUD de clientes
     Route::resource('clients', AdminClientController::class);

     //CRUD de características de propiedades
    Route::resource('caracteristics', AdminCaracteristicController::class);

});
