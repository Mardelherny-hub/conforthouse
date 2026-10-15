<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/inmovilla-proxy', [App\Http\Controllers\Api\InmovillaProxyController::class, 'proxy']);
Route::get('/inmovilla-proxy-test', function() {
    return response()->json(['message' => 'Proxy endpoint disponible']);
});
// Private monthly evidence snapshot. Disabled unless REDBYTE_EVIDENCE_ENABLED=1 and a strong token are set.
Route::get('/internal/maintenance-evidence/v1', [App\Http\Controllers\Api\ConfortHouseEvidenceController::class, 'show'])
    ->middleware('throttle:6,1');
