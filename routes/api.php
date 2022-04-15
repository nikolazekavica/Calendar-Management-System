<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\LoginController;
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


Route::get("availabilities", [AvailabilityController::class, "all"]);

//user
Route::post("availabilities", [AvailabilityController::class, "store"]);

//admin
Route::get("users/{id}/availabilities", [AvailabilityController::class, "allByUserId"]);
Route::get("availabilities/search", [AvailabilityController::class, "allByDateRange"]);

Route::post("users/registration", [LoginController::class, "registrationUser"])->middleware('db.transaction');
Route::post("users/account/verification", [LoginController::class, "verification"]);
Route::post("users/login", [LoginController::class, "login"]);
Route::get("/users/verificationUser", [LoginController::class, "verificationUser"]);

