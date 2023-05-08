<?php

use App\Http\Controllers\General\QrDetectorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
|
| Here is where you can register general api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group.
| Enjoy building your API!
|
*/

Route::post('detect', QrDetectorController::class);
