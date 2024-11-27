<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CitiiesController extends Controller
{
    public function cities(){
        $cities = City::with("deliveriyman_cities")->get();
        return response()->json($cities);
        
    }
    public function deleteCity(Request $request){
        $ids = $request->input("ids");

        $res = City::whereIn('id', $ids)->delete();
    
        if ($res) {
            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'error'], 411);
        }

    }
}
