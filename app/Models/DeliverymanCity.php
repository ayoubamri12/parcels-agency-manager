<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverymanCity extends Model
{
    use HasFactory;
    protected $fillable = ["delivery_id", "city_id"];
    public function deliveries()
    {
        return $this->hasToMany(Delivery::class, 'delivery_id', 'id');
    }
    public function cities()
    {
        return $this->hasToMany(City::class, 'city_id', 'id');
    }
}
