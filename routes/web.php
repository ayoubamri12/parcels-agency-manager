<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DeliverymanCityController;
use App\Http\Controllers\ParcelsController;
use App\Http\Controllers\SettingsController;
use App\Models\Parcels;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('common.dashboard');
})->name('home');
Route::get('/login', [AuthController::class,"create"])->name('login');
Route::post('/login/store', [AuthController::class,"store"])->name('auth');
Route::get('/login/destroy', [AuthController::class,"destroy"])->name('logout');
Route::get('/insertdata',[ParcelsController::class,"createExcel"])->name('insertion');
Route::get('/Parcels/add',[ParcelsController::class,"create"])->name("admin.addParcel");
Route::post('/Parcels/store',[ParcelsController::class,"store"])->name("parcel.store");
Route::put('/Parcels/update/{id}',[ParcelsController::class,"update"])->name("parcel.update");
Route::get("/Settings",[SettingsController::class,"index"])->name("settings");
Route::get("/Parcels/index",[ParcelsController::class,"index"])->name("parcels");
Route::get("/Parcels/deliverymen/deliverymen_parcels/index/{id}",[DeliveryController::class,"parcels"])->name("deliverymen.parcels");
Route::get("/Parcels/deliverymen/index",[DeliveryController::class,"index"])->name("deliverymen");
Route::get("/Parcels/companies/index",[CompanyController::class,"index"])->name("companies");
Route::get("/Parcels/companies/index/companies_parcels/{id}",[CompanyController::class,"parcels"])->name("companies.parcels");
Route::post('/settings/deliveryman/store', [SettingsController::class, 'storeDeliveryman'])->name('settings.storeDeliveryman');
Route::post('/settings/magasin/store', [SettingsController::class, 'storeMagasin'])->name('settings.storeMagasin');
Route::post('/settings/company/store', [SettingsController::class, 'storeCompany'])->name('settings.storeCompany');
Route::post('/settings/city/store', [SettingsController::class, 'storeCity'])->name('settings.storeCity');
Route::patch("/deliverymencity/merge/{id}", [DeliverymanCityController::class, "merge"]);
Route::get("/parcels/delete/{id}", [ParcelsController::class, "destroy"])->name("parcel.delete");
