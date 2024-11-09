<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\DeliverymanCity;
use App\Models\Magasin;
use App\Models\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(){
       $deliverymen = Delivery :: all();
       $companies = Company :: all();
        return view('settings',compact(["deliverymen","companies"]));
    }
    public function storeDeliveryman(Request $request)
    {
       $d = Delivery::create(['name' => strtoupper($request->name),"comission"=>$request->comission]);
        $user = new User();
        $user->email =strtoupper($request->input('name'));
        $user->name =strtoupper($request->input('name'));
        $user->type = 'deliverymen';
        $user->password = bcrypt($request->input('password'));
        $user->delivery_id = $d->id;
        $user->save();

        return back()->with('success', 'New deliveryman has been added successfully.');
    }
    public function storeCity(Request $request)
    {
        $city = City::create(['city' => strtoupper($request->location)]);
        DeliverymanCity::create(['delivery_id' =>$request->input("livreur"),'city_id'=>$city->id]);
        return back()->with('success', 'New location has been added successfully.');
    }
    public function storeCompany(Request $request)
    {
       
        Company::create(['name' => strtoupper($request->name),'revenue_per_comp'=>$request->revenue]);

        return back()->with('success', 'New Company has been added successfully.');
    }
    public function storeMagasin(Request $request)
    {
       
        Magasin::create(['magasin' => strtoupper($request->magasin),'company_id'=>$request->company_id]);

        return back()->with('success', 'New Company has been added successfully.');
    }
}
