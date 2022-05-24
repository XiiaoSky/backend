<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    
    public $table = "price";

    public function units()
    {
        return $this->hasOne('App\Models\Unit', "id",'unit_id');
    }

}
