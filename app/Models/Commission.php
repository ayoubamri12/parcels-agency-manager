<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;
    protected $fillable = ["city_id","company_id","commission"];
    public function company(){
        return $this->belongsTo(Company::class,"company_id","id");
    }
}
