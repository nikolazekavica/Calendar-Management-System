<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\UserController;
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

Route::post("users", [UserController::class, "store"]);
Route::get("availabilities", [AvailabilityController::class, "all"]);

//user
Route::post("availabilities", [AvailabilityController::class, "store"]);

//admin
Route::get("users/{id}/availabilities", [AvailabilityController::class, "allByUserId"]);
Route::get("availabilities/search", [AvailabilityController::class, "allByDateRange"]);
