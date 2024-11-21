<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverymanCity extends Model
{
    use HasFactory;
    protected $fillable = ["delivery_id", "city_id","company_id","commission"];
    public function deliveries()
    {
        return $this->belongsToMany(Delivery::class,'deliveries', 'id', 'delivery_id');
    }
    public function cities()
    {
        return $this->belongsToMany(City::class,'cities','id', 'city_id');
    }
    public function companies()
    {
        return $this->belongsToMany(City::class, 'companies','id', 'company_id');
    }
}
