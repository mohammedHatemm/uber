<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/login', [LoginController::class, 'submit']);
Route::post('/login/verfiy', [LoginController::class, 'verify']);


Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('/user', function (Request $request) {
    return $request->user();
  });
});
