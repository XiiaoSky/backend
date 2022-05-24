<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Users;
use App\Models\Address;
use App\Models\Area;
use App\Models\City;
use App\Models\Myfunction;

class AddressController extends Controller
{

  function getAddressDateile(Request $req){

    $data =  Address::where('id',$req->id)->with('area')->with('city')->first();

    $area =  Area::where('city_id',$data['city_id'])->get();
    return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data,'area'=>$area ]);
  }

    function addAddress(Request $req){

        $rules = [
            'fullname' => 'required',
            'address_type'=> 'required',
            'is_default'=> 'required',
            'pincode'=> 'required',
            'address'=> 'required',
            'user_id'=> 'required',
            'area_id'=> 'required',
            'city_id'=> 'required',
            'landmark'=> 'required',
            'number'=> 'required',

        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

    $addressCount = Address::where('user_id',$req->user_id)->count();
    
        if($addressCount >= 4){

             return json_encode(['status'=>false,"message" =>"minimum address only 4"]);
        }else{

        
          $is_default = $req->is_default;

          if($is_default == 0){

           $isdefaultcount = Address::where('is_default',1)->where('user_id',$req->user_id)->count();
              
            if($isdefaultcount == 0){

                return json_encode(['status'=>false ,'message'=>'User dont  have any is default address']);

            }else{
                $isdefault = 0;
            }

                  
          }else{
              Address::where('is_default',1)->where('user_id',$req->user_id)->update(['is_default'=>0]);
              $isdefault = 1;
          }

          $item = new Address();

          $item->fullname = Myfunction::customReplace($req->fullname);
          $item->is_default = Myfunction::customReplace($isdefault); 
          $item->address_type =  Myfunction::customReplace($req->address_type);
          $item->pincode = Myfunction::customReplace($req->pincode);
          $item->address = Myfunction::customReplace($req->address);
          $item->landmark = Myfunction::customReplace($req->landmark);
          $item->number = Myfunction::customReplace($req->number);
          $item->alt_number = Myfunction::customReplace($req->alt_number);
          $item->area_id = Myfunction::customReplace($req->area_id) ;
          $item->user_id = Myfunction::customReplace($req->user_id);
          $item->city_id = Myfunction::customReplace($req->city_id);
          $item->latitude = Myfunction::customReplace($req->latitude);
          $item->longitude = Myfunction::customReplace($req->longitude);
         $result =  $item->save();  
         $data =  Address::latest()->first();
         if($result){

             return json_encode(['status'=>true ,'message'=>'Address Add Successfull','data'=> $data ]);
         }else{
            return json_encode(['status'=>false ,'message'=>'something wrong']);
         }
    

        }

    }

   function getAllDeliveryAddress(Request $req){


    
    $id = $_SERVER['HTTP_USERID'];

   $data = Address::where('user_id',$id)->with('area')->with('city')->orderBy('id', 'DESC')->get();
   if($data == '[]'){

    return json_encode(['status'=>false ,'message'=>'No data Found']);
   }else{
    return json_encode(['status'=>true ,'message'=>'Address fetch Successfull','data'=> $data ]);

   }

  

   }


  function updateAddress(Request $req){

    
    $user_id =  $_SERVER['HTTP_USERID'];;


    $rules = [
        'fullname' => 'required',
        'id' => 'required',
        'address_type'=> 'required',
        'is_default'=> 'required',
        'pincode'=> 'required',
        'area_id'=> 'required',
        'city_id'=> 'required',
        'landmark'=> 'required',
        'address'=> 'required',
        'number'=> 'required',
        'alt_number'=> 'required',

    ];
    $validator = Validator::make($req->all(), $rules);
    if ($validator->fails()) {
        $messages = $validator->errors()->all();
        $msg = $messages[0];
        return response()->json(['status' => false, 'message' => $msg]);

    }
      $id = $req->id;


      $is_default = $req->is_default;

      if($is_default == 0){

       $isdefaultcount = Address::where('is_default',1)->where('user_id',$user_id)->whereNotIn('id',[$req->id])->count();
          
        if($isdefaultcount == 0){

            return json_encode(['status'=>false ,'message'=>'User dont  have any is default address']);

        }else{
            $isdefault = 0;
        }

              
      }else{
        Address::where('is_default',1)->where('user_id',$user_id)->update(['is_default'=>0]);
        $isdefault = 1;
      }


       

      $item = Address::find($id);

      $item->fullname = Myfunction::customReplace($req->fullname);
      $item->is_default = Myfunction::customReplace($isdefault);
      $item->address_type = Myfunction::customReplace($req->address_type);
      $item->pincode = Myfunction::customReplace($req->pincode);
      $item->address = Myfunction::customReplace($req->address);
      $item->landmark = Myfunction::customReplace($req->landmark);
    
      $item->number = Myfunction::customReplace($req->number);
      $item->alt_number = Myfunction::customReplace($req->alt_number);
      $item->area_id = Myfunction::customReplace($req->area_id) ;
      $item->city_id = Myfunction::customReplace($req->city_id);
      if($req->has('latitude')){

        $item->latitude = Myfunction::customReplace($req->latitude);
      }

      if($req->has('longitude')){

        $item->longitude = Myfunction::customReplace($req->longitude);
      }
  

     $result =  $item->save();  
     $data =  Address::where('id',$id)->first();
     if($result){

         return json_encode(['status'=>true ,'message'=>'Address Update Successfull','data'=> $data ]);
     }else{
        return json_encode(['status'=>false ,'message'=>'something wrong']);
     }


  }

  function deleteAddress(Request $req){


    $rules = [
        'address_id' => 'required',
    ];

    $validator = Validator::make($req->all(), $rules);
    if ($validator->fails()) {
        $messages = $validator->errors()->all();
        $msg = $messages[0];
        return response()->json(['status' => false, 'message' => $msg]);
    }

       $d1 = Address::find($req->address_id);
       $result =  $d1->delete();

    if($result){

        return json_encode(['status'=>true ,'message'=>'delete Successfull']);
    }else{
       return json_encode(['status'=>false ,'message'=>'something wrong']);
    }
  }

  function getDefaultDeliveryAddress(Request $req){

    $user_id =   $_SERVER['HTTP_USERID'];

    $data =  Address::where('user_id',$user_id)->where('is_default',1)->with('area')->with('city')->first();

    

    return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);
  }
}
