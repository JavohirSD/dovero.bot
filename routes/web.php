<?php

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

Route::any('/', [\App\Http\Controllers\WebhookController::class, 'index']);
Route::get('/status', [\App\Http\Controllers\StatusController::class, 'status']);

Route::get('/test', [\App\Http\Controllers\WebhookController::class, 'test']);

//Route::post('/telegram/{bot}', 'WebhookController@store');
