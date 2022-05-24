<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public $table = 'review';

    public function user()
    {
        return $this->hasOne('App\Models\Users', "id",'user_id');
    }
}
