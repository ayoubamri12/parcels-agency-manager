<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    use HasFactory;
   protected $fillable = ['magasin','company_id'];
   public function company(){
    return $this->hasOne(Company::class,"company_id","id");
   }

}
