<?php

namespace App\Http\Controllers;

use App\Models\customid;
use App\Models\Myfunction;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    
    function setting(){

       $data = Setting::first();
       $idsdata = customid::first();

       return view('setting.setting',['data'=>$data,'idsdata'=>$idsdata]);

        
    }

    function updateCharg(Request $req){

        $item =   Setting::find(1);
        $item->shippingcharge = Myfunction::customReplace($req->shippingcharge);
        $item->currencies	 = Myfunction::customReplace($req->currencies)	;
        $item->terms = Myfunction::customReplace($req->terms);
        $item->privacy_policy = Myfunction::customReplace($req->privacy_policy);
        $item->number = Myfunction::customReplace($req->number);
        $item->about = Myfunction::customReplace($req->about);
        $item->contact = Myfunction::customReplace($req->contact);
        $item->app_name = Myfunction::customReplace($req->app_name);
        $item->email = Myfunction::customReplace($req->email);
        $item->quantity = Myfunction::customReplace($req->quantity);
        $item->facebook = Myfunction::customReplace($req->facebook);
        $item->instagram = Myfunction::customReplace($req->instagram);
        $item->twitter = Myfunction::customReplace($req->twitter);
        $item->linkedin = Myfunction::customReplace($req->linkedin);
        $item->appstore = Myfunction::customReplace($req->appstore);
        $item->playstore = Myfunction::customReplace($req->playstore);
        $item->short_des = Myfunction::customReplace($req->short_des);
        $item->long_des = Myfunction::customReplace($req->long_des);
        $item->slogan  = Myfunction::customReplace($req->slogan) ;
        $result = $item->save();

        if($result){

        return json_encode(['status'=>true,'meassage'=>'Upadte successfull']);

        }else{
            return json_encode(['status'=>false,'meassage'=>'somthing wrong']);
        }

    }

    function updateIds(Request $req){

        $item =   customid::find(1);
        $item->of = Myfunction::customReplace($req->of);
        $item->cf	 = Myfunction::customReplace($req->cf);
        $result = $item->save();

        if($result){

        return json_encode(['status'=>true,'meassage'=>'Upadte successfull']);

        }else{
            return json_encode(['status'=>false,'meassage'=>'somthing wrong']);
        }

    }


    function getShipingCharg(){
        
        $data = Setting::first();
        
        return json_encode(['status'=>true,'meassage'=>'fetch successfull','data'=>$data]);
    }


 

}
