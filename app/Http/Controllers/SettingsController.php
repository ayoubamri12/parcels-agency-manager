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
        $companies = Company::all();
        $cities = City::all();
        return view('admin.settings', compact(["deliverymen", "companies", "cities"]));
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
        $company = Company::create(['name' => strtoupper($request->name)]);
        foreach ($request->input("city") as $c) {
            $city = City::find($c);
            $commission = $request->input("reg_commission");
            if ($city->reg_local === "LOCAL")
                $commission = $request->input("local_commission");
            Commission::create(["city_id" => $c, "company_id" => $company->id, "commission" => $commission]);
        }
        return back()->with('success', 'New Company has been added successfully.');
    }

    public function storeMagasin(Request $request)
    {

        Magasin::create(['magasin' => strtoupper($request->magasin), 'company_id' => $request->company_id]);

        return back()->with('success', 'New Company has been added successfully.');
    }
}
