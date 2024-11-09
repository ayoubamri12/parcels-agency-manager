<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index(){
        $dvs = Delivery::all();
        return view("deliverymen",compact("dvs"));
    }
}
