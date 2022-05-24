<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Price;
use App\Models\Images;
use App\Models\Unit;

class Product extends Model
{
    use HasFactory;

    public $table = "product";

    public function category()
    {
        return $this->hasOne('App\Models\Category', "id",'category_id');
    }

    public function Prices()
    {
        return $this->hasMany('App\Models\Price','product_id','id')->with('Units');
        }



    public function Units()
    {
        return $this->hasMany('App\Models\Unit','id','unit_id');
    }

    public function Images()
    {
        return $this->hasMany('App\Models\Images','product_id','id');
    }
}
