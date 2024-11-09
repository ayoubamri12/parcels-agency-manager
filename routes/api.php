<?php

use App\Http\Controllers\CitiiesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ParcelsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("/companies",[CompanyController::class,'CompList']);
Route::get("/cities",[CitiiesController::class,'cities']);
Route::get("/parcels", [ParcelsController::class, "filteredData"]);
Route::post("/parcels/store", [ParcelsController::class, "store"]);
