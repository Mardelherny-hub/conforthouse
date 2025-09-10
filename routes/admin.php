<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPropertyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminClientController;
use App\Http\Controllers\Admin\AdminCaracteristicController;
use App\Http\Controllers\Admin\UserController;

// 🔐 Rutas protegidas por rol y permiso
Route::middleware(['auth', 'verified', 'role:admin|agente'])->group(function () {

    // 🏠 Dashboard (visible con cualquier rol válido)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 📦 Propiedades
    Route::get('properties', [AdminPropertyController::class, 'index'])
        ->name('properties.index')
        ->middleware('permission:ver propiedades');

    Route::get('properties/create', [AdminPropertyController::class, 'create'])
        ->name('properties.create')
        ->middleware('permission:crear propiedades');

    Route::post('properties', [AdminPropertyController::class, 'store'])
        ->name('properties.store')
        ->middleware('permission:crear propiedades');
    Route::get('properties/{property}', [AdminPropertyController::class, 'show'])
        ->name('properties.show')
        ->middleware('permission:ver propiedades');

    Route::get('properties/{property}/edit', [AdminPropertyController::class, 'edit'])
        ->name('properties.edit')
        ->middleware('permission:editar propiedades');

    Route::put('properties/{property}', [AdminPropertyController::class, 'update'])
        ->name('properties.update')
        ->middleware('permission:editar propiedades');

    Route::delete('properties/{property}', [AdminPropertyController::class, 'destroy'])
        ->name('properties.destroy')
        ->middleware('permission:eliminar propiedades');

    // Clientes
    Route::resource('clients', AdminClientController::class)
        ->middleware('permission:gestionar clientes');

    // Características
    Route::resource('caracteristics', AdminCaracteristicController::class)
        ->middleware('permission:gestionar características');

    // Gestión de usuarios
    Route::get('users', [UserController::class, 'index'])
    ->name('users.index')
    ->middleware('permission:gestionar usuarios');

    Route::get('users/{user}/edit', [UserController::class, 'edit'])
    ->name('users.edit')
    ->middleware('permission:gestionar usuarios');

    Route::put('users/{user}', [UserController::class, 'update'])
    ->name('users.update')
    ->middleware('permission:gestionar usuarios');

    Route::delete('users/{user}', [UserController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('permission:gestionar usuarios');

    // Papelera de usuarios
    Route::get('users/trash', [UserController::class, 'trash'])
    ->name('users.trash')
    ->middleware('permission:gestionar usuarios');

    Route::post('users/{id}/restore', [UserController::class, 'restore'])
    ->name('users.restore')
    ->middleware('permission:gestionar usuarios');

    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])
    ->name('users.forceDelete')
    ->middleware('permission:gestionar usuarios');

    // Sincronización Inmovilla (solo para admins)
    Route::middleware('permission:gestionar usuarios')->group(function () {
        Route::get('inmovilla/sync', [App\Http\Controllers\Admin\InmovillaSyncController::class, 'index'])
            ->name('inmovilla.sync.index');
        
        Route::post('inmovilla/check-services', [App\Http\Controllers\Admin\InmovillaSyncController::class, 'checkServices'])
            ->name('inmovilla.sync.check-services');
        
        Route::post('inmovilla/sync', [App\Http\Controllers\Admin\InmovillaSyncController::class, 'sync'])
            ->name('inmovilla.sync.execute');
        
        Route::get('inmovilla/progress', [App\Http\Controllers\Admin\InmovillaSyncController::class, 'progress'])
            ->name('inmovilla.sync.progress');
        
        Route::post('inmovilla/translate', [App\Http\Controllers\Admin\InmovillaSyncController::class, 'translate'])
            ->name('inmovilla.sync.translate');
    });
});

