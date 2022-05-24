<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class LoginController extends Controller
{
    function login(){

        return  view('login.login');
      }
  
      function checklogin(Request $req){
  
          $data = Admin::where('user_name', $req->user_name)->first();
          
          if($req->user_name == $data['user_name'] && $req->user_password == $data['user_password']  ){
  
            
              $req->session()->put('user_name',$data['user_name']);
              $req->session()->put('user_password',$data['user_password']);
              $req->session()->put('user_type',$data['user_type']);
              return  json_encode(['status'=>true,"message"=>"login susseccfull"]);
              
          }else{
              return   json_encode(['status'=>false,"message"=>"somethig wrong"]);
          }
      }
  
      function logout(){
  
          session()->pull('user_name');
          session()->pull('user_password');
          session()->pull('user_type');
          return  redirect(url('/'));
      }

      function profile(){
         $data = Admin::first();
         return view('setting.profile',['data'=> $data ]);
      }

      function updateProflie(Request $req){

        $item = Admin::where('user_id',1)->update(['user_password'=> $req->user_password,
       'user_name'=> $req->user_name]);


        return  json_encode(['status'=>true,"message"=>"Update susseccfull"]);

      }
}
