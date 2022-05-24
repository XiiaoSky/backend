<?php

namespace App\Http\Controllers;

use App\Models\Myfunction;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{

    function firebaseRegister(Request $req){

        $rules = [
            'identity' => 'required',
            'firstname'=> 'required',
            'login_type'=> 'required',
            'device_type'=> 'required',
            'device_token'=> 'required',
            'email'=>'required'
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }


        
     $data = Users::where('identity',$req->identity)->first();
       
        if($data == null){
 
         
         $user = new Users;
        $user->firstname = Myfunction::customReplace($req->firstname); 
        $user->email = Myfunction::customReplace($req->email); 
        $user->lastname = Myfunction::customReplace($req->lastname);
        $user->identity = $req->identity;
        $user->device_token = $req->device_token;
        $user->device_type = $req->device_type;
        $user->login_type = $req->login_type;
        $user->save();
        $data =  Users::latest()->first();
        return json_encode(['status'=>true ,'message'=>'User Add Success','data'=> $data ]);
       
        }else{
            $user = Users::find($data['id']);

            $user->device_type = $req->device_type;
            $user->login_type = $req->login_type; 
            $user->save();
            
            $data = Users::where('id',$data['id'])->first();
    
            return json_encode(['status'=>true ,'message'=>'User All Ready Exists','data'=> $data]);
        }
    }
    function addUserDetails(Request $req){

        $rules = [
            'identity' => 'required',
            'firstname'=> 'required',
            'login_type'=> 'required',
            'device_type'=> 'required',
            'device_token'=> 'required',

        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

     $data = Users::where('identity',$req->identity)->first();
       
    if($data == null){

        
        $user = new Users;

      
        $user->firstname = Myfunction::customReplace($req->firstname); 
        $user->email = Myfunction::customReplace($req->email); 
        $user->lastname = Myfunction::customReplace($req->lastname);
        $user->identity = $req->identity;
        $user->device_token = $req->device_token;
        $user->device_type = $req->device_type;
        $user->login_type = $req->login_type;
        $user->save();
        $data =  Users::latest()->first();
        return json_encode(['status'=>true ,'message'=>'User Add Success','data'=> $data ]);
        
 
      
        
    }else{


        $user = Users::find($data['id']);

     

        $user->device_token = $req->device_token;
        $user->device_type = $req->device_type;
        $user->login_type = $req->login_type; 
        $user->save();
        
        $data = Users::where('id',$data['id'])->first();

        return json_encode(['status'=>true ,'message'=>'User All Ready Exists','data'=> $data]);
    }
 


    }


    function updateProfile(Request $req){

        $rules = [
            'id' => 'required'
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

        $data = Users::where('id',$req->id)->first();
       
        if($data == null){
    

       return json_encode(['status'=>false ,'message'=>'user id Not vailed']);

    }else{
      
        $user = Users::find($req->id);

        if($req->has('firstname')){
        $user->firstname = Myfunction::customReplace($req->firstname); 
        }

        if($req->has('lastname')){
        $user->lastname = Myfunction::customReplace($req->lastname);
        }

        if($req->has('email')){
            $user->email = Myfunction::customReplace($req->email);
            }

        if($req->has('image')){
        $path = $req->file('image')->store('uploads');
        $user->image = $path;
        }
       
       $result = $user->save();
       
       $data = Users::where('id',$req->id)->first();
       if($result){
        return json_encode(['status'=>true ,'message'=>'Upadte successfull','data'=>$data]);
       }else{
        return json_encode(['status'=>false ,'message'=>'something wrong']);
       }
    }
    }

    function getProfile(){

    
        $token = $_SERVER['HTTP_USERID'];

        $data = Users::where('id',$token)->first();

        
        if($data == null){
    

            return json_encode(['status'=>false ,'message'=>'something went wrong']);
     
         }else{
            return json_encode(['status'=>true ,'message'=>'Fetch Data successfull','data'=>$data]);

         }
    }

    function fetchAllUsers(Request $request){

        $totalData =  Users::count();
        $rows = Users::orderBy('id', 'DESC')->get();


        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'firstname'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Users::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Users::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Users::Where('firstname', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered =Users::where('id', 'LIKE', "%{$search}%")
                ->orWhere('firstname', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {
     

            $data[] = array(
             
             
          
             '<p>'.$item->identity.' </p>',
             '<p>'.$item->firstname.'</p>',
 
             '<p class="badge badge-success">'.__('app.Active').'</p>',

          
            );
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
        );
        echo json_encode($json_data);
        exit();


    }


    function logout(){
        

    $user_id =   $_SERVER['HTTP_USERID'];

    $user = Users::find( $user_id);
    $user->device_token = "";
    $result2 =    $user->save();

    if($result2){
        return json_encode(['status'=>true ,'message'=>'Logout successfull']);
 
     }else{
        return json_encode(['status'=>false ,'message'=>'something wrong']);

     }
  
    }

    function sendNotification(){
return Users::send_push("dB0UY3gZgEp1hMaBXJiUov:APA91bEmVaz40Vk9UXeE8G98j-e_E951n-NKOHQV7U3hF8j_pSQF1pn5VpCP3Lk5p-_Bs7qa5TBDXD2x1q5w5bdu9dD6OKIVKyFYL1ZLUMw6wepb_EaiMp6wgK8N_CR0QWOfxbdnFap5","title","test demo ",0);


    }
}
