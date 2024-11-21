<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ["city",'reg_local'];

    public function deliveriyman_cities()
    {
        return $this->hasMany(DeliverymanCity::class,'city_id','id');
    }
}
