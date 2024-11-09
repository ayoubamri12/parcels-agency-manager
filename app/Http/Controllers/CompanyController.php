<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Magasin;
use Illuminate\Http\Request;



class CompanyController extends Controller
{
    public function index(){
        $cmps = Company::all();
        return view("companies",compact("cmps"));
    }


    public function CompList(){
        $companies = Magasin::all();
        return response()->json($companies);
    }
}
