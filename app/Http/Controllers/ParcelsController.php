<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\Parcel;
use App\Models\Parcels;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParcelsController extends Controller

{
    public function index()
    {
        $delmens = Delivery::all();
        $companies = Company::all();
        return view("parcels", compact(["delmens",'companies']));
    }
    public function create()
    {
        $deliverymen = Delivery::all();
        return view('insertData', compact(["deliverymen"]));
    }
    public function store(Request $request)
    {
        foreach ($request->input('data') as $d){
            $d['parcel_date'] = Carbon::createFromFormat('Y-m-d', $d['parcel_date']);
            $parcel = Parcel::create($d);

        }
      
        return response()->json(["message"=>"success"],200);
            
        
    }
    public function filteredData(Request $request)
    {
        $parcels = Parcel::query();

        if (!empty($request->input('delivery'))) {
            $parcels->where('delivery_id', $request->input('delivery'));
        }

        if (!empty($request->input('created_at'))) {
            $parcels->whereBetween('created_at', [$request->input('created_at')[0], $request->input('created_at')[1]]);
        }

        if (!empty($request->input('state'))) {
            $parcels->where('state', $request->input('state'));
        }
        if (!empty($request->input('company_id'))) {
            $parcels->where('company_id', $request->input('company_id'));
        }
        if (!empty($request->input('status'))) {
            $parcels->where('status', $request->input('status'));
        }

        if (!empty($request->input('magasin'))) {
            $parcels->where('company_name', 'like', '%' . $request->input('magasin') . '%');
        }
        if (!empty($request->input('code'))) {
            $parcels->where('city', 'like', '%' . $request->input('code') . '%');
        }
        return response()->json($parcels->with("delivery")->get());
    }
}
