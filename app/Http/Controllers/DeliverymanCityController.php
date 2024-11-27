<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Delivery;
use App\Models\DeliverymanCity;
use Illuminate\Http\Request;

class DeliverymanCityController extends Controller
{
    public function merge(Request $req,$id){
        $i=0;
        foreach ($req->input("cps") as $c) {
            $dc =  DeliverymanCity::create(['delivery_id' => $req->input("dlvm"), "city_id" => $id, "company_id" => $c, "commission" => $req->input("commission")[$i]]);
            $i++;
        }
        return back()->with('success', 'New deliveryman has been added successfully.');
    }
}
