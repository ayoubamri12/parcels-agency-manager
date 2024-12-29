<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Commission;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\DeliverymanCity;
use App\Models\Magasin;
use App\Models\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $deliverymen = Delivery::all();
        $companies = Company::where('name','!=','OTHER')->get();
        $cities = City::all();
        return view('admin.SettingsContainer', compact(["deliverymen", "companies", "cities"]));
    }
    public function storeDeliveryman(Request $request)
    {
        $d = Delivery::create(['name' => strtoupper($request->name)]);
        $user = new User();
        $user->email = strtoupper($request->input('name'));
        $user->name = strtoupper($request->input('name'));
        $user->type = 'deliverymen';
        $user->password = bcrypt($request->input('password'));
        $user->delivery_id = $d->id;
        $user->save();
        $i = 0;
        foreach ($request->input("cps") as $c) {
            $dc =  DeliverymanCity::create(['delivery_id' => $d->id, "city_id" => $request->input("city")[0], "company_id" => $c, "commission" => $request->input("commission")[$i]]);
            $i++;
        }
        return back()->with('success', 'New deliveryman has been added successfully.');
    }
    public function storeCity(Request $request)
    {
        $city = City::create(['city' => strtoupper($request->location), 'reg_local' => strtoupper($request->local_reg)]);
        return back()->with('success', 'New location has been added successfully.');
    }
    public function storeCompany(Request $request)
    {
        $cities = $request->input('city') ?? $request->input('data.city');
    $name = $request->input('name') ?? $request->input('data.name');
    $isOther = $request->query('other') ? 1 : 0;
$company="";
    // Create the company
   if(!is_numeric($name)){
        $company = Company::create([
        'name' => strtoupper($name),
        'other' => $isOther
    ]);
   }else{
       $company = Company::find($name);
   }

    // Loop through cities and add commissions
    foreach ($cities as $cityId) {
        $city = City::find($cityId);
         if(!is_numeric($name)){
        // Determine commission
        $commission = $request->input('reg_commission') ?? $request->input('data.commission');
        if ($city->reg_local === "LOCAL") {
            $commission = $request->input('local_commission') ?? $request->input('data.commission');
        }
        
        // Create commission record
        Commission::create([
            'city_id' => $cityId,
            'company_id' => $company->id,
            'commission' => $commission
        ]);
         }
    }

    // If 'other' is set, create DeliverymanCity record
    if ($isOther) {
        DeliverymanCity::create([
            'delivery_id' => $request->input('data.id'),
            'city_id' => $request->input('data.city')[0],
            'company_id' => $company->id,
            'commission' => $request->input('data.commissionlv')
        ]);
        $com =  Commission::where("'city_id", $request->input('data.city')[0])->where("company_id",$company->id)->get();
        if(!$com){
            Commission::create([
            'city_id' =>  $request->input('data.city')[0],
            'company_id' => $company->id,
            'commission' => $request->input('data.commission')
        ]);

        }
        return response()->json($company);
    }

    // Return back with success message
    return back()->with('success', 'New Company has been added successfully.');
    }

    public function storeMagasin(Request $request)
    {

        Magasin::create(['magasin' => strtoupper($request->magasin), 'company_id' => $request->company_id]);

        return back()->with('success', 'New Company has been added successfully.');
    }
}
