<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = ['name','comission'];

    public function deliveriyman_cities()
    {
        return $this->hasMany(DeliverymanCity::class, 'delivery_id', 'id');
    }
    
    public function parcels()
    {
        return $this->hasMany(Parcel::class, 'parcels', 'parcel_id', 'id');
    }
}
