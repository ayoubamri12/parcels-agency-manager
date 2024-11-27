<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Delivery;
use App\Models\User;
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
    public function indexapi()
    {
        $dvs = Delivery::with("user")->get();
        return response()->json($dvs);
    }
    public function deleteDeliveryman(Request $request){
        $ids = $request->input("ids");

        $res = Delivery::whereIn('id', $ids)->delete();
    
        if ($res) {
            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'error'], 411);
        }

    }
}
