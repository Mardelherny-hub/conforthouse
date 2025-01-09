<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Ruta principal del panel de administración
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas para la gestión de propiedades
    Route::resource('properties', PropertyController::class);
});
