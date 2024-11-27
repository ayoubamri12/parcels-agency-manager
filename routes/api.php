<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitiiesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DeliverymanCityController;
use App\Http\Controllers\ParcelsController;
use App\Models\Delivery;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get("/companies",[CompanyController::class,'CompList']);
Route::get("/Deliverymen",[DeliveryController::class,'indexapi']);
Route::get("/companies_commissions",[CompanyController::class,'companies']);
Route::get("/cities",[CitiiesController::class,'cities']);
Route::get("/parcels", [ParcelsController::class, "filteredData"]);
Route::get("/parcels_per_deliverymen/{id}", [ParcelsController::class, "filteredDataDm"])->name("deliveryapi");
Route::get("/parcels_per_companies/{id}", [ParcelsController::class, "filteredDataCm"])->name("companiesapi");
Route::patch("/parcels/markAsReturned", [ParcelsController::class, "markAsReturned"])->name("companiesapi");
Route::delete("/parcels/deleteCity", [CitiiesController::class, "deleteCity"])->name("Citiesapi");
Route::delete("/parcels/deleteDeliveryman", [DeliveryController::class, "deleteDeliveryman"])->name("Citiesapi");
Route::post("/parcels/store", [ParcelsController::class, "storeExcel"]);
Route::patch("/users/{id}/password", [AuthController::class, "updatePassword"]);
