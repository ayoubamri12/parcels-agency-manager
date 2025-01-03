<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;
    protected $fillable = ["client_name",'parcel_date', 'phone', 'price', 'status', 'state', 'company_id', 'delivery_id', 'city', 'company_name','comment','delivery_date','returned','returning_date'];
    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id', 'id');
    }
    public function company(){
       return $this->hasOne(Company::class,"id","company_id");
    }
}
