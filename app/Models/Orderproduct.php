<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;

class Orderproduct extends Model
{
    use HasFactory;
    public $table ='orderproduct';

    public function product()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public function price()
    {
        return $this->hasOne('App\Models\Price','id','price_id');
    }

    public function unit()
    {
        return $this->hasOne('App\Models\Unit','id','unit_id');
    }
}
