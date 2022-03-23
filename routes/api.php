<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentTypeController;
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

Route::apiResource('equipment/type', EquipmentTypeController::class, [
    'only' => ['index']
]);

Route::apiResource('equipment', EquipmentController::class, [
    'only' => ['store', 'index', 'show', 'update', 'destroy']
]);
