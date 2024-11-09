<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function cities()
    {
        return $this->belongsToMany(City::class, 'deliveryman_cities', 'city_id', 'id');
    }
    
    public function parcels()
    {
        return $this->hasMany(Parcel::class, 'parcels', 'parcel_id', 'id');
    }
}
