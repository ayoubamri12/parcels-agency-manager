<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\DeliverymanCity;
use App\Models\User;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function parcels(int $id)
    {
        $dc = DeliverymanCity::where('delivery_id', $id)->get();
        $companies = Company::whereIn("id", $dc->pluck('company_id'))->orderBy('name', 'asc')->get();

        $ids = $dc->pluck('city_id');
        $city = City::find($ids[0]);
        // dd($city->id);

        if ($city->reg_local == 'LOCAL') {
            // dd($id);
            return to_route('deliverymen.local_parcels', $id);
        } else {
            return view("common.deliverymen.parcels", compact(['companies']));
        }
    }
    public function localParcels(int $id)
    {
        $dc = DeliverymanCity::where('delivery_id', $id)->get();
        $companies = Company::whereIn("id", $dc->pluck('company_id'))->orderBy('name', 'asc')->get();
        $other = Company::where('other', 1)->with("deliveriyman_cities")->get();
        $deliverymen = Delivery::find($id);

        return view("common.deliverymen.local_parcels", compact(['companies', 'other', 'deliverymen']));
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
    public function deleteDeliveryman(Request $request)
    {
        $ids = $request->input("ids");

        $res = Delivery::whereIn('id', $ids)->delete();

        if ($res) {
            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'error'], 411);
        }
    }
}
