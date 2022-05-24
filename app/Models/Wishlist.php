<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    public $table = 'wishlist';

    public $timestamps = false;

    public function category()
    {
        return $this->hasOne('App\Models\Category', "id",'category_id');
    }

    public function Prices()
    {
        return $this->hasMany('App\Models\Price','product_id','id');
    }

    public function Units()
    {
        return $this->hasMany('App\Models\Unit','id','unit_id');
    }

    public function Images()
    {
        return $this->hasMany('App\Models\Images','product_id','id');
    }

    public function Products()
    {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
}
