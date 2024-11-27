<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = ['name','comission'];

    public function user(){
        return $this->hasOne(User::class,'delivery_id','id');
    }
    public function deliveriyman_cities()
    {
        return $this->hasMany(DeliverymanCity::class, 'delivery_id', 'id');
    }
    
    public function parcels()
    {
        return $this->hasMany(Parcel::class, 'parcels', 'parcel_id', 'id');
    }
   
}
