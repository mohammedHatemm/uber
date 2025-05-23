<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TripController;
use Illuminate\Contracts\Concurrency\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/login', [LoginController::class, 'submit']);
Route::post('/login/verfiy', [LoginController::class, 'verify']);


Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('/driver', [DriverController::class, 'show']);
  Route::post('/driver', [DriverController::class, 'update']);
  Route::post('/trip', [TripController::class, 'store']);
  Route::get('/trip/{trip}', [TripController::class, 'show']);
  Route::post('/trip/{trip}/accept', [TripController::class, 'accept']);
  Route::post('/trip/{trip}/start', [TripController::class, 'start']);
  Route::post('/trip/{trip}/end', [TripController::class, 'end']);
  Route::post('/trip/{trip}/location', [TripController::class, 'location']);
  Route::get('/user', function (Request $request) {
    return $request->user();
  });
});
