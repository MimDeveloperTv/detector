<?php

use App\Http\Controllers\Admin\DetectorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group.
| Enjoy building your API!
|
*/
Route::post('detect', DetectorController::class);
