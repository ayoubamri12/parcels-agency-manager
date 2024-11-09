<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CitiiesController extends Controller
{
    public function cities(){
        $cities = City::with("deliveries")->get();
        return response()->json($cities);
        
    }
}
