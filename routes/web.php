<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\DB;
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

    // Página Aviso Legal
    Route::get('/legal', [PropertyController::class, 'legal'])->name('legal');


    // Rutas para consultas unificadas con middleware de throttling
    Route::post('/consultation', [App\Http\Controllers\ConsultationController::class, 'store'])
        ->name('consultation.store')
        ->middleware(['antispam', 'throttle:5,1']);

    Route::post('/contact', [App\Http\Controllers\ConsultationController::class, 'storeContact'])
        ->name('contact.store')
        ->middleware(['antispam', 'throttle:3,1']);

    Route::post('/home-contact', [App\Http\Controllers\ConsultationController::class, 'storeHomeContact'])
        ->name('home.contact.store')
        ->middleware(['antispam', 'throttle:3,1']);

    Route::post('/property-contact', [App\Http\Controllers\ConsultationController::class, 'storePropertyContact'])
        ->name('property.contact.store')
        ->middleware(['antispam', 'throttle:3,1']);

    });

   // Ruta para Cron Job de IONOS
    // Ruta para Cron Job de IONOS - Sin guiones ni caracteres especiales
    Route::get('/cronrun', function () {
        Artisan::call('inmovilla:update');
        return response()->json([
            'success' => true,
            'message' => 'Scheduler ejecutado',
            'output' => Artisan::output()
        ]);
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

// ============================================
// HEALTH CHECK - Monitoreo básico del sitio
// ============================================
Route::get('/health', function () {
    $checks = [
        'status' => 'ok',
        'timestamp' => now()->toIso8601String(),
        'app' => config('app.name'),
        'environment' => config('app.env'),
    ];

    // Verificar conexión a base de datos
    try {
        DB::connection()->getPdo();
        $checks['database'] = 'ok';
        $checks['properties_count'] = \App\Models\Property::count();
    } catch (\Exception $e) {
        $checks['database'] = 'error';
        $checks['database_error'] = $e->getMessage();
        $checks['status'] = 'degraded';
    }

    // Verificar última sincronización Inmovilla
    $lastSync = \Illuminate\Support\Facades\Cache::get('inmovilla_sync_last_run');
    $checks['last_sync'] = $lastSync ? $lastSync->toIso8601String() : 'never';

    // Verificar espacio en storage/logs
    $logPath = storage_path('logs/laravel.log');
    if (file_exists($logPath)) {
        $checks['log_size_mb'] = round(filesize($logPath) / 1024 / 1024, 2);
    }

    $httpStatus = $checks['status'] === 'ok' ? 200 : 503;

    return response()->json($checks, $httpStatus);
});

// Incluye las rutas de autenticación
require __DIR__.'/auth.php';
