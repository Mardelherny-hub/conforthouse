<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Define los idiomas permitidos
$languages = ['en', 'es', 'fr', 'de'];

// Redirige la ruta raíz al idioma por defecto
Route::get('/', function () {
    return redirect(app()->getLocale());
});

// Rutas públicas con prefijo de idioma
Route::group([
    'prefix' => '{locale}',
    'middleware' => ['web', 'setLocale'],
    'where' => ['locale' => 'en|es|fr|de']
], function () {
    // Página de inicio
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    // Página home
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});

// Rutas administrativas (sin multilenguaje)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Incluye las rutas de autenticación
require __DIR__.'/auth.php';