<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Myfunction extends Model
{
    use HasFactory;

 public static   function stringReplace($string){
        $cleaned_name = strip_tags( $string);
            
       return preg_replace('/[^A-Za-z0-9\-]/', '', $cleaned_name);
    }


    public static   function customReplace($string){
        
       return  str_replace( array('<', '>','{','}','[',']','`'), '', $string);
    }
}
