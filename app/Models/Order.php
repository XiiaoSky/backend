<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Delivery;


class Order extends Model
{
    use HasFactory;
    public $table= "orderdetails";

    public function user()
    {
        return $this->hasOne('App\Models\Users', "id",'user_id');
    }


    public function rating(){
        
        return $this->hasOne('App\Models\Review', "order_id",'order_id');
    }


    
    public function deliveryboy()
    {
        return $this->hasOne('App\Models\Delivery', "id",'deliveryBoy_id');
    }

    public function orderaddress()
    {
        return $this->belongsTo('App\Models\OrderAddress', "id",'order_id');
    }

    public function orderproducts()
    {
        return $this->hasMany(Orderproduct::class,'order_id','id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public function price()
    {
        return $this->hasOne('App\Models\Price;','id','price_id');
    }

  

}
