<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Address extends Model
{
    use HasFactory;
    public $table = 'address';

    public function city()
    {
        return $this->hasOne('App\Models\City', "id",'city_id');
    }

    public function area()
    {
        return $this->hasOne('App\Models\Area', "id",'area_id');
    }
}
