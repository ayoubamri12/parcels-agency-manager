<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ["city"];

    public function deliveries()
    {
        return $this->belongsToMany(Delivery::class,'deliveryman_cities','delivery_id','id');
    }
}
