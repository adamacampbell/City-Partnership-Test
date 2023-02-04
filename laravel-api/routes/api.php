<?php

use App\Http\Controllers\FcaCredsController;
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

Route::apiResource('/fca-creds', FcaCredsController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

    //* FCA CREDENTIAL API CALLS *//
    Route::get('/fca-creds', [FcaCredsController::class, 'show']);
});