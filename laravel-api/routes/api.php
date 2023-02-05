<?php

use App\Http\Controllers\FcaCredsController;
use App\Http\Controllers\FcaRegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//* DEBUG ROUTES *//
// HARMLESS DEBUG ROUTE USED TO DEBUG CONNECTION ISSUES (DOCKER)
Route::get('/debug/test', function(Request $request) {
    return 'PASS';
});

/*
| FCA CREDS ROUTES
*/
Route::prefix('/fca-creds')->group(function() {
    Route::get('', [FcaCredsController::class, 'index']);
    Route::get('/{fca_creds}', [FcaCredsController::class, 'show']);
    Route::post('', [FcaCredsController::class, 'store']);
    Route::post('/{fca_creds}', [FcaCredsController::class, 'update']);
    Route::delete('/{fca_creds}', [FcaCredsController::class, 'destroy']);
});

/*
| FCA REGISTER ROUTES
*/
Route::prefix('/fca-register')->group(function() {
    Route::post('/check-exists', [FcaRegisterController::class, 'checkFirmExists']);
});

