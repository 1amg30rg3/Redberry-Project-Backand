<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\countryDataController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/register', [AuthController::class, 'registerUser']);


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/get-statistics',[countryDataController::class, 'getCountryDetails']);
    Route::get('/get-statistics-total',[countryDataController::class, 'getCountryDetailsTotal']);
});
