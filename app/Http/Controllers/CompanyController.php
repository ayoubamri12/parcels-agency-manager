<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\Magasin;
use Illuminate\Http\Request;



class CompanyController extends Controller
{
    public function index(){
        $cmps = Company::all();
        return view("common.companies",compact("cmps"));
    }

    public function companies(){
        $companies = Commission::all();
        return response()->json($companies);

    }
    public function CompList(){
        $companies = Magasin::all();
        
        return response()->json($companies);
    }
    public function parcels(){
        $delmens = Delivery::all();
        return view("common.companies.parcels", compact("delmens"));
    }
}
