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


Route::get('/login', [AuthController::class, "create"])->name('login');
Route::post('/login/store', [AuthController::class, "store"])->name('auth');
Route::get("/Parcels/deliverymen/index", [DeliveryController::class, "index"])->name("deliverymen");

Route::middleware("adminOrOwner")->group(function () {
    Route::get('/', function () {
        return view('common.dashboard');
    })->name('home');
    // login
    Route::get('/login/destroy', [AuthController::class, "destroy"])->name('logout');
    // excel handeling
    Route::get('/insertdata', [ParcelsController::class, "createExcel"])->name('insertion');
    // Parcels handeling
    Route::get("/Parcels/index", [ParcelsController::class, "index"])->name("parcels");
    Route::get("/Parcels/to_return", [ParcelsController::class, "toBeRetruned"])->name("parcels.return");
    Route::get("/parcels/payement/to_pay", [ParcelsController::class, "notPayed"])->name("parcels.notPayed");
    Route::get("/parcels/payement/payed", [ParcelsController::class, "payedIndex"])->name("parcels.payed");
    Route::get("/Parcels/deliverymen/deliverymen_parcels/{id}", [DeliveryController::class, "parcels"])->name("deliverymen.parcels");
    Route::get("/Parcels/deliverymen/deliverymen_local_parcels/{id}", [DeliveryController::class, "localParcels"])->name("deliverymen.local_parcels");
    Route::get("/Parcels/companies/index", [CompanyController::class, "index"])->name("companies");
    Route::get("/Parcels/companies/index/companies_parcels/{id}", [CompanyController::class, "parcels"])->name("companies.parcels");
    Route::get('/Parcels/add/{id?}', [ParcelsController::class, "create"])->name("admin.addParcel");
    Route::post('/Parcels/store/{id?}', [ParcelsController::class, "store"])->name("parcel.store");
    Route::post('/parcelsAdd/{id}', [ParcelsController::class, "storeLocalParcels"])->name("parcel_local.store");
    Route::put('/Parcels/update/{id}', [ParcelsController::class, "update"])->name("parcel.update");
    Route::get("/parcels/delete/{id}", [ParcelsController::class, "destroy"])->name("parcel.delete");
    Route::get("/parcels/delete_local/{id}", [ParcelsController::class, "destroy_local"])->name("parcel_local.delete");
    // Settings
    Route::get("/Settings", [SettingsController::class, "index"])->name("settings");
    Route::post('/settings/deliveryman/store', [SettingsController::class, 'storeDeliveryman'])->name('settings.storeDeliveryman');
    Route::post('/settings/magasin/store', [SettingsController::class, 'storeMagasin'])->name('settings.storeMagasin');
    Route::post('/settings/company/store', [SettingsController::class, 'storeCompany'])->name('settings.storeCompany');
    Route::post('/settings/city/store', [SettingsController::class, 'storeCity'])->name('settings.storeCity');
    Route::patch("/deliverymencity/merge/{id}", [DeliverymanCityController::class, "merge"]);
});
