<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function parcels()
    {
        $companies = Company::all();
        return view("common.deliverymen.parcels", compact([ 'companies']));
    }
    public function index()
    {
        $dvs = Delivery::all();
        return view("common.deliverymen", compact("dvs"));
    }
}
