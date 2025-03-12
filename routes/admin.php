<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPropertyController;
use Illuminate\Support\Facades\Route;

// Rutas protegidas para administración
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard de administración
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


    // CRUD de propiedades en el panel de administración
    Route::resource('properties', AdminPropertyController::class);
});
