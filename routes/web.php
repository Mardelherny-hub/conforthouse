<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
//Artisan
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TestPropertyController;
use App\Http\Controllers\ComplexController;

//controladores para el panel de control
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPropertyController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Define los idiomas permitidos
$languages = ['en', 'es', 'fr', 'de', 'nl'];

// Redirige la ruta raíz al idioma por defecto
Route::get('/', function () {
    return redirect(app()->getLocale());
});

// Rutas públicas con prefijo de idioma
Route::group([
    'prefix' => '{locale}',
    'middleware' => ['web', 'setLocale'],
    'where' => ['locale' => 'en|es|fr|de|nl']
    ], function () {


    // Página home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Páginas properties
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/{slug}', [PropertyController::class, 'show'])->name('prop.show');

    // === RUTAS COMPLEJOS RESIDENCIALES ===
    Route::get('/complexes', [ComplexController::class, 'index'])->name('complexes.index');
    Route::get('/complexes/{keypromo}', [ComplexController::class, 'show'])->name('complexes.show');


    //Página Servicios
    Route::get('/services', [PropertyController::class, 'services'])->name('services');

    // Página sobre nosotros
    Route::get('/about', [PropertyController::class, 'about'])->name('about');

    // Página contact
    Route::get('/contact', [PropertyController::class, 'contact'])->name('contact');

    // Página Privacy
        Route::get('/privacy', [PropertyController::class, 'privacy'])->name('privacy');

    // Rutas para consultas unificadas con middleware de throttling
    Route::post('/consultation', [App\Http\Controllers\ConsultationController::class, 'store'])
         ->name('consultation.store')
         ->middleware('throttle:5,1'); // Modal flotante

    Route::post('/contact', [App\Http\Controllers\ConsultationController::class, 'storeContact'])
         ->name('contact.store')
         ->middleware('throttle:3,1'); // Página de contacto

    Route::post('/home-contact', [App\Http\Controllers\ConsultationController::class, 'storeHomeContact'])
         ->name('home.contact.store')
         ->middleware('throttle:3,1'); // Formulario del home


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

Route::post('/inmovilla-proxy', [App\Http\Controllers\Api\InmovillaProxyController::class, 'proxy']);
Route::get('/inmovilla-proxy-test', function() {
    return response()->json(['message' => 'Proxy endpoint disponible']);
});
Route::get('/debug-inmovilla', function() {
    return response()->json([
        'status' => 'ok',
        'server' => $_SERVER['SERVER_NAME'] ?? 'unknown',
        'laravel_version' => app()->version(),
        'api_file_exists' => file_exists(storage_path('app/inmovilla/apiinmovilla.php')),
        'api_file_path' => storage_path('app/inmovilla/apiinmovilla.php')
    ]);
});

// Incluye las rutas de autenticación
require __DIR__.'/auth.php';
