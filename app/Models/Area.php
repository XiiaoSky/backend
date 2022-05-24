<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    public $table = 'area';

    public function city()
    {
        return $this->hasOne('App\Models\City', "id",'city_id');
    }

    
    public function getNameAttribute($value){
        return ucfirst($value);
       }
}
