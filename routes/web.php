<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DeliveryController;
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
    return view('dashboard');
})->name('home');
Route::get('/login', [AuthController::class,"create"])->name('login');
Route::post('/login/store', [AuthController::class,"store"])->name('auth');
Route::get('/login/destroy', [AuthController::class,"destroy"])->name('logout');
Route::get('/insertdata',[ParcelsController::class,"create"])->name('insertion');
Route::get("/Settings",[SettingsController::class,"index"])->name("settings");
Route::get("/Parcels/index",[ParcelsController::class,"index"])->name("parcels");
Route::get("/Parcels/deliverymen/index",[DeliveryController::class,"index"])->name("deliverymen");
Route::get("/Parcels/companies/index",[CompanyController::class,"index"])->name("companies");
Route::post('/settings/deliveryman/store', [SettingsController::class, 'storeDeliveryman'])->name('settings.storeDeliveryman');
Route::post('/settings/magasin/store', [SettingsController::class, 'storeMagasin'])->name('settings.storeMagasin');
Route::post('/settings/company/store', [SettingsController::class, 'storeCompany'])->name('settings.storeCompany');
Route::post('/settings/city/store', [SettingsController::class, 'storeCity'])->name('settings.storeCity');