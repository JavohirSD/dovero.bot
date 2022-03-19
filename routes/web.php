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

Route::get('/', [\App\Http\Controllers\WebhookController::class, 'test']);
Route::get('/status', [\App\Http\Controllers\StatusController::class, 'check']);

Route::post('/telegram/{bot}', 'WebhookController@store');
