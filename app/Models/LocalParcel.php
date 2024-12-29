<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalParcel extends Model
{
    use HasFactory;
    protected $fillable = [ 'price', 'status', 'state', 'company_id', 'delivery_id', 'city', 'company_name','totale_d','delivery_date'];
    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id', 'id');
    }
    public function company(){
       return $this->hasOne(Company::class,"id","company_id");
    }
}
