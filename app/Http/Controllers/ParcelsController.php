<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\DeliverymanCity;
use App\Models\LocalParcel;
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
        $companies = Company::where('other',0)->get();
        return view("admin.parcels", compact(["delmens", 'companies']));
    }
    public function toBeRetruned()
    {
        $delmens = Delivery::all();
         $companies = Company::where('other',0)->get();
        return view("admin.toBeRetruned", compact(["delmens", 'companies']));
    }
    public function notPayed()
    {
        $delmens = Delivery::all();
        $companies = Company::where('other',0)->get();
        return view("admin.notPayed", compact(["delmens", 'companies']));
    }
    public function payedIndex()
    {
        $delmens = Delivery::all();
          $companies = Company::where('other',0)->get();
        return view("admin.payed", compact(["delmens", 'companies']));
    }
    public function createExcel()
    {
        $deliverymen = Delivery::all();
        return view('admin.insertData', compact(["deliverymen"]));
    }
  public function create(Request $request)
{
    // Fetch all cities
    $cities = City::all();

    // Check if an ID is provided in the request
    $dc = $request->id ? DeliverymanCity::where('delivery_id', $request->id)->get() : null;

    // Fetch companies based on `dc` or fetch all if `dc` is null
    $companies = $dc&&$request->id  ? 
        Company::whereIn("id", $dc->pluck('company_id'))->orderBy('name', 'asc')->get() : 
        Company::orderBy('name', 'asc')->get();
        $other =Company::where('other',1)->with("deliveriyman_cities")->get();
        // $other = $other->where("deliveriyman_cities.delivery_id",$request->id);
        // dd($other);
    // Fetch all deliveries with their related `deliveryman_cities`
    $devs = Delivery::with("deliveriyman_cities")->get();

    // Fetch the deliveryman if an ID is provided, otherwise set to null
    $deliverymen = $request->id ? Delivery::find($request->id) : null;

    // Fetch all magasins
    $mgs = Magasin::all();

    // Return the view with compacted data
    return view("admin.parcelsForm", compact('cities', 'companies', 'devs', 'mgs', 'deliverymen','other'));
}

    public function destroy(Parcel $id, Request $request){
        $id->delete();
        return back()->with("updated","uod");
    }
    public function destroy_local(LocalParcel $id, Request $request){
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
                $id->update(['comment' => $cmnt, 'returning_date'=>$request->input("date")]);
            }else
            $id->update(['comment' =>" ( date :" . $request->input("date") . " )", 'returning_date'=>$request->input("date")]);

            if ($request->input("status") === "Livré")
                $id->update(['delivery_date' => Carbon::today()]);
        }else if (!empty($request->input("state"))) {
            $id->update(['state' => $request->input("state"),]);
        } else if (!empty($request->input("data"))) {
           !empty($request->input("data")['status'])? $id->update(['status' => $request->input("data")['status'],'returning_date'=>null]):$id->update(['state' => $request->input("data")['state']]);
            return response()->json(200);
        }
        
        return response()->json(200);
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
        $cmp = Company::find($req->cps);
        $city='';
        if($req->id){
        $dc=DeliverymanCity::where('delivery_id',$req->id)->get();
        $city = City::find($dc[0]->city_id)->city;
        }
        // Ensure uniqueness if needed, for example in a loop
        while (Parcel::where('id', $uniqueCode)->exists()) {
            $uniqueCode = 'aloo-salhi-' . Str::random(10);
        }

        $parcel = new Parcel();
        $parcel->code = $uniqueCode;
        $parcel->city = $city ?? $req->city;
        $parcel->parcel_date = Carbon::today();
        $parcel->phone = $req->phone_number;
        $parcel->client_name = $req->Name;
        $parcel->state = "Non payé";
        $parcel->status = "en cours de livraison";
        $parcel->price = $req->price;
        $parcel->company_id = $req->cps;
        $parcel->delivery_id = $req->id ?? $req->dev;
        $parcel->company_name = strtoupper($cmp->name);
        // $parcel->qr_code = $qrCodePath;
        // $parcel->adress = $req->adress;
        // $parcel->accessibility = $req->accessable ?? "accessible";
        // $parcel->changable = $req->changeable ?? "unchangeable";

        $parcel->save();
        return back()->with("created", 'item');
    }
    public function storeLocalParcels(Request $req)
    {
        $cmp = Company::find($req->company_name);
        $city='';
        $dc=DeliverymanCity::where('delivery_id',$req->id)->get();
        $city = City::find($dc[0]->city_id)->city;
        

        $parcel = new LocalParcel();
        $parcel->city = $city ;
        $parcel->delivery_date = Carbon::today();
        $parcel->state = "Payé";
        $parcel->status = "Livré";
        $parcel->price = $req->price;
        $parcel->company_id = $req->company_name;
        $parcel->delivery_id = $req->id;
        $parcel->totale_d = $req->totaleLivre;
        $parcel->company_name = strtoupper($cmp->name);
        // $parcel->qr_code = $qrCodePath;
        // $parcel->adress = $req->adress;
        // $parcel->accessibility = $req->accessable ?? "accessible";
        // $parcel->changable = $req->changeable ?? "unchangeable";

        $parcel->save();
        return back()->with("created", 'item');
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
        if (!empty($request->input('delivery_date'))) {
            // $today = Carbon::today()->toString();
            $parcels->where('status',"Livré")->whereDate('delivery_date',$request->input('delivery_date'));

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
        $parcels = $parcels->where("company_id", $request->id);

        if (!empty($request->input('delivery'))) {
            $parcels->where('delivery_id', $request->input('delivery'));
        }

        if (!empty($request->input('created_at'))) {
            $dStart = Carbon::parse($request->input('created_at')[0])->startOfDay();
            $dEnd = Carbon::parse($request->input('created_at')[1])->endOfDay();
            $parcels->whereBetween('created_at', [$dStart, $dEnd]);
        }
        if (!empty($request->input('delivery_date'))) {
            // $today = Carbon::today()->toString();
            $parcels->where('status',"Livré")->whereDate('delivery_date',$request->input('delivery_date'));

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
        $parcels = $parcels->where("delivery_id", $request->id)->where('returned',null);


        if (!empty($request->input('created_at'))) {
            $dStart = Carbon::parse($request->input('created_at')[0])->startOfDay();
            $dEnd = Carbon::parse($request->input('created_at')[1])->endOfDay();
            $parcels->whereBetween('created_at', [$dStart, $dEnd]);
        }
        if (!empty($request->input('delivery_date'))) {
            // $today = Carbon::today()->toString();
            $parcels->where('status',"Livré")->whereDate('delivery_date',$request->input('delivery_date'));
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
    public function filteredDataDmLocal(Request $request)
    {
        $parcels = LocalParcel::query();
        $parcels = $parcels->where("delivery_id", $request->id);


        if (!empty($request->input('created_at'))) {
            $dStart = Carbon::parse($request->input('created_at')[0])->startOfDay();
            $dEnd = Carbon::parse($request->input('created_at')[1])->endOfDay();
            $parcels->whereBetween('created_at', [$dStart, $dEnd]);
        }
        if (!empty($request->input('delivery_date'))) {
            // $today = Carbon::today()->toString();
            $parcels->where('status',"Livré")->whereDate('delivery_date',$request->input('delivery_date'));
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

        
       
        return response()->json($parcels->with(["delivery", "company"])->get());
    }
    public function filteredDataLocal(Request $request)
    {
        $parcels = LocalParcel::query();


        if (!empty($request->input('created_at'))) {
            $dStart = Carbon::parse($request->input('created_at')[0])->startOfDay();
            $dEnd = Carbon::parse($request->input('created_at')[1])->endOfDay();
            $parcels->whereBetween('created_at', [$dStart, $dEnd]);
        }
         if (!empty($request->input('delivery'))) {
            $parcels->where('delivery_id', $request->input('delivery'));
        }
        if (!empty($request->input('delivery_date'))) {
            // $today = Carbon::today()->toString();
            $parcels->where('status',"Livré")->whereDate('delivery_date',$request->input('delivery_date'));
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

        
       
        return response()->json($parcels->with(["delivery", "company"])->get());
    }
    public function neededParcels(Request $request)
    {
        $parcels = Parcel::with(["delivery", "company"])->where("delivery_id", $request->id)->whereNull('returned')->where(function ($query) {
            $query->whereDate("returning_date", Carbon::today())->orWhere('status', 'Pas de reponse')->where('created_at', '>=', now()->subDays(7))->whereDate("updated_at",'!=', Carbon::today())->orWhere('status', 'Injoignable')->where('created_at', '>=', now()->subDays(7))->whereDate("updated_at",'!=', Carbon::today()); // Add your "OR" condition here
        })
        ->get();

    return response()->json($parcels);

    }
    public function toReturn(Request $request)
    {
        $parcels = Parcel::query();
        $parcels->where(function ($query) {
        $query->whereIn('status', ['Annulé', 'Refusé'])
              ->orWhere(function ($query) {
                  $query->where('created_at', '<', now()->subDays(3))
                        ->where('status', '!=', 'Livré');
                       
              });
    }) ->whereNull('returned')->get();
        if (!empty($request->input('delivery'))) {
            $parcels->where('delivery_id', $request->input('delivery'));
        }

        if (!empty($request->input('created_at'))) {
            $dStart = Carbon::parse($request->input('created_at')[0])->startOfDay();
            $dEnd = Carbon::parse($request->input('created_at')[1])->endOfDay();
            $parcels->whereBetween('created_at', [$dStart, $dEnd]);
        }
        if (!empty($request->input('delivery_date'))) {
            // $today = Carbon::today()->toString();
            $parcels->where('status',"Livré")->whereDate('delivery_date',$request->input('delivery_date'));

        }
         if (!empty($request->input('status'))) {
            $parcels->where('status', $request->input('status'));
        }
        if (!empty($request->input('company_id'))) {
            $parcels->where('company_id', $request->input('company_id'));
        }
        if (!empty($request->input('magasin'))) {
            $parcels->where('company_name', 'like', '%' . $request->input('magasin') . '%');
        }
        if (!empty($request->input('code'))) {
            $parcels->where('city', 'like', '%' . $request->input('code') . '%');
        }
        return response()->json($parcels->with(["delivery", "company"])->get());
    }
    public function toPay(Request $request)
    {
        $parcels = Parcel::query();
        $parcels->where('status','=','Livré') ->where('state','!=','Payé')->get();
        if (!empty($request->input('delivery'))) {
            $parcels->where('delivery_id', $request->input('delivery'));
        }

        if (!empty($request->input('created_at'))) {
            $dStart = Carbon::parse($request->input('created_at')[0])->startOfDay();
            $dEnd = Carbon::parse($request->input('created_at')[1])->endOfDay();
            $parcels->whereBetween('created_at', [$dStart, $dEnd]);
        }
        if (!empty($request->input('delivery_date'))) {
            // $today = Carbon::today()->toString();
            $parcels->where('status',"Livré")->whereDate('delivery_date',$request->input('delivery_date'));

        }
        if (!empty($request->input('company_id'))) {
            $parcels->where('company_id', $request->input('company_id'));
        }
        if (!empty($request->input('magasin'))) {
            $parcels->where('company_name', 'like', '%' . $request->input('magasin') . '%');
        }
        if (!empty($request->input('code'))) {
            $parcels->where('city', 'like', '%' . $request->input('code') . '%');
        }
        return response()->json($parcels->with(["delivery", "company"])->get());
    }
    public function payed(Request $request)
    {
        $parcels = Parcel::query();
        $parcels->where('status','=','Livré') ->where('state','=','Payé')->get();
        if (!empty($request->input('delivery'))) {
            $parcels->where('delivery_id', $request->input('delivery'));
        }

        if (!empty($request->input('created_at'))) {
            $dStart = Carbon::parse($request->input('created_at')[0])->startOfDay();
            $dEnd = Carbon::parse($request->input('created_at')[1])->endOfDay();
            $parcels->whereBetween('updated_at', [$dStart, $dEnd]);
        }
        if (!empty($request->input('delivery_date'))) {
            // $today = Carbon::today()->toString();
            $parcels->where('status',"Livré")->whereDate('delivery_date',$request->input('delivery_date'));

        }
        if (!empty($request->input('company_id'))) {
            $parcels->where('company_id', $request->input('company_id'));
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
