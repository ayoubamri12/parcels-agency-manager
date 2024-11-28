<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\Magasin;
use App\Models\Parcel;
use App\Models\Parcels;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParcelsController extends Controller

{

    public function index()
    {
        $delmens = Delivery::all();
        $companies = Company::all();
        return view("admin.parcels", compact(["delmens", 'companies']));
    }
    public function createExcel()
    {
        $deliverymen = Delivery::all();
        return view('admin.insertData', compact(["deliverymen"]));
    }
    public function create()
    {
        $cities = City::all();
        $companies = Company::all();
        $devs = Delivery::all();
        $mgs = Magasin::all();
        return view("admin.parcelsForm", compact(['cities', 'companies', 'devs', 'mgs']));
    }
    public function destroy(Parcel $id, Request $request){
        $id->delete();
        return back()->with("updated","uod");
    }
    public function update(Parcel $id, Request $request)
    {
        if (!empty($request->input("status"))) {
            $id->update(['status' => $request->input("status")]);
            if (!empty($request->input("comment"))) {
                $cmnt = $request->input("comment");
                if ($request->input("date"))
                    $cmnt = $request->input("comment") . " ( date :" . $request->input("date") . " )";
                $id->update(['comment' => $cmnt]);
            }
            if ($request->input("status") === "Livré")
                $id->update(['delivery_date' => Carbon::today()]);
        } else if (!empty($request->input("state"))) {
            $id->update(['state' => $request->input("state")]);
        }
        return back()->with("updated", "updated");
    }
    public function markAsReturned(Request $request){
        $ids = $request->input("ids");

        $res = Parcel::whereIn('id', $ids)->update(['returned' => true]);
    
        if ($res) {
            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'error'], 411);
        }

    }
    public function store(Request $req)
    {
        $uniqueCode = 'aloo-salhi' . Str::random(10);

        // Ensure uniqueness if needed, for example in a loop
        while (Parcel::where('id', $uniqueCode)->exists()) {
            $uniqueCode = 'aloo-salhi-' . Str::random(10);
        }
        $parcel = new Parcel();
        $parcel->code = $uniqueCode;
        $parcel->city = $req->city;
        $parcel->parcel_date = Carbon::today();
        $parcel->phone = $req->phone_number;
        $parcel->client_name = $req->Name;
        $parcel->state = "Non payé";
        $parcel->status = "en cours de livraison";
        $parcel->price = $req->price;
        $parcel->company_id = $req->cps;
        $parcel->delivery_id = $req->id ?? $req->dev;
        $parcel->company_name = strtoupper($req->magasin);
        // $parcel->qr_code = $qrCodePath;
        // $parcel->adress = $req->adress;
        // $parcel->accessibility = $req->accessable ?? "accessible";
        // $parcel->changable = $req->changeable ?? "unchangeable";

        $parcel->save();
        return to_route("admin.addParcel")->with("created", 'item');
    }
    public function storeExcel(Request $request)
    {
        foreach ($request->input('data') as $d) {
            $d['parcel_date'] = Carbon::createFromFormat('Y-m-d', $d['parcel_date']);
            $parcel = Parcel::create($d);
        }

        return response()->json(["message" => "success"], 200);
    }
    public function filteredData(Request $request)
    {
        $parcels = Parcel::query();

        if (!empty($request->input('delivery'))) {
            $parcels->where('delivery_id', $request->input('delivery'));
        }

        if (!empty($request->input('created_at'))) {
            $dStart = Carbon::parse($request->input('created_at')[0])->startOfDay();
            $dEnd = Carbon::parse($request->input('created_at')[1])->endOfDay();
            $parcels->whereBetween('created_at', [$dStart, $dEnd]);
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
        return response()->json($parcels->with(["delivery", "company"])->get());
    }
    public function filteredDataCm(Request $request)
    {
        $parcels = Parcel::query();

        if (!empty($request->input('delivery'))) {
            $parcels->where('delivery_id', $request->input('delivery'));
        }

        if (!empty($request->input('created_at'))) {
            $dStart = Carbon::parse($request->input('created_at')[0])->startOfDay();
            $dEnd = Carbon::parse($request->input('created_at')[1])->endOfDay();
            $parcels->whereBetween('created_at', [$dStart, $dEnd]);
        }

        if (!empty($request->input('state'))) {
            $parcels->where('state', $request->input('state'));
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
        return response()->json($parcels->with(["delivery", "company"])->get());
    }
    public function filteredDataDm(Request $request)
    {
        $parcels = Parcel::query();
        $parcels = $parcels->where("delivery_id", $request->id);


        if (!empty($request->input('created_at'))) {
            $dStart = Carbon::parse($request->input('created_at')[0])->startOfDay();
            $dEnd = Carbon::parse($request->input('created_at')[1])->endOfDay();
            $parcels->whereBetween('created_at', [$dStart, $dEnd]);
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
        return response()->json($parcels->with(["delivery", "company"])->get());
    }
}
