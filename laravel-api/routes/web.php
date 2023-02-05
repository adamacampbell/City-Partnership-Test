<?php

use App\Http\Controllers\FcaCredsController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// FORM ROUTES
Route::post('store-creds', [FcaCredsController::class, 'storeWeb']);
Route::post('store-form', [FormController::class, 'store']);