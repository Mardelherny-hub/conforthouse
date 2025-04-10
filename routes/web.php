<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
//Artisan
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TestPropertyController;

//controladores para el panel de control
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPropertyController;


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


    // Página home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Páginas properties
    Route::get('/properties', [PropertyController::class, 'index'])->name('prop.index');
    Route::get('/properties/{slug}', [PropertyController::class, 'show'])->name('prop.show');


    //Página Servicios
    Route::get('/services', [PropertyController::class, 'services'])->name('services');

    // Página sobre nosotros
    Route::get('/about', [PropertyController::class, 'about'])->name('about');

    // Página contact
    Route::get('/contact', [PropertyController::class, 'contact'])->name('contact');

    // Página Privacy
        Route::get('/privacy', [PropertyController::class, 'privacy'])->name('privacy');


    });


// Rutas protegidas para usuarios autenticados (No admin)
Route::middleware(['auth', 'verified'])->group(function () {
    // Perfil de usuario (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Limpieza
Route::get('/clear', function() {
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('event:clear');
    Artisan::call('clear-compiled');
    Artisan::call('optimize:clear');
    return "Cache is cleared";
});

Route::get('/symlink', function () {
    Artisan::call('storage:link');
    return 'The storage link has been created!';
});


// Incluye las rutas de autenticación
require __DIR__.'/auth.php';
