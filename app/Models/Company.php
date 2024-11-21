<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name','revenue_per_comp'];
    public function magasins(){
       return $this->belongsToMany(Magasin::class , "company_id","id");
    }
    public function parcels(){
       return $this->belongsToMany(Parcel::class,"company_id","id");
    }
    public function deliveriyman_cities(){
      return $this->hasMany(DeliverymanCity::class,"company_id","id");
   }
   public function commissions(){
      return $this->hasMany(Commission::class,"company_id","id");
  }
}
