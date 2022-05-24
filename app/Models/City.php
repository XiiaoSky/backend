<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class City extends Model
{
    use HasFactory;
    public $table = 'city';

    
    public function areas()
    {
        return $this->hasMany('App\Models\Area','city_id','id');
    }

    public function getNameAttribute($value){
     return ucfirst($value); 
    }

   
}
