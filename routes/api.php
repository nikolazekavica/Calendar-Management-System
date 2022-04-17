<?php

use App\Http\Controllers\Calendar\v1\AvailabilityController;
use App\Http\Controllers\Calendar\v1\LoginController;
use App\Http\Controllers\Calendar\v1\RegistrationController;
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
//admin
Route::get("availabilities", [AvailabilityController::class, "all"])->middleware(['auth:api','scopes:admin']);
Route::get("/users/filter/availabilities", [AvailabilityController::class, "allByUser"])->middleware(['auth:api','scopes:admin']);
Route::get("availabilities/filter", [AvailabilityController::class, "allByDateRange"])->middleware(['auth:api','scopes:admin']);

//regular
Route::get("users/{id}/availabilities", [AvailabilityController::class, "allByUserId"])->middleware(['auth:api','scopes:regular','id.verified']);
Route::post("availabilities", [AvailabilityController::class, "store"])->middleware(['auth:api','scopes:regular']);

//all
Route::post("users/register", [RegistrationController::class, "register"])->middleware('db.transaction');
Route::post("users/login", [LoginController::class, "login"]);
Route::post("users/logout", [LoginController::class, "logout"])->middleware(['auth:api']);;
Route::get("users/verify", [RegistrationController::class, "verify"]);



