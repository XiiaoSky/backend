<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Myfunction;
use App\Models\Order;
use App\Models\Review;
use App\Models\Usernotification;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    function fetchAllDbList(Request $request){

    
        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;

        $totalData =  Delivery::count();
        $rows = Delivery::orderBy('id', 'DESC')->get();


        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'username'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Delivery::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Delivery::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Delivery::Where('username', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered =Delivery::where('id', 'LIKE', "%{$search}%")
                ->orWhere('username', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $item) {
     
            $action = '<td><a href="'.route('viewDbDetails',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
            <a href="" data-toggle="modal" rel="'.$item->id.'"  data-target="#editdbmodal" class="btn btn-primary  edititem"><i class="fas fa-edit"></i></a>
            <a href="" rel = "'.$item->id.'" class="btn btn-danger  delete-item"><i class="fas fa-trash-alt"></i></a></td>';
     

            $data[] = array(
             '<img src="public/storage/'.$item->image.'" width="70" height="70">',
             '<p>'.$item->username.'</p>',
             '<p>'.$item->fullname.'</p>',
             '<p>'.$item->number.'</p>',
             '<p>'.$currencies.' '.$item->payment.' </p>',
             $action
         
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


    function fetchAllDeliveryBoyConfirmOrder(Request $request){


        $totalData =  Order::where('deliveryBoy_id',$request->dbid)->where('status',2)->count();
        $rows = Order::where('deliveryBoy_id',$request->dbid)->where('status',2)->orderBy('id', 'DESC')->with("user")->with('orderaddress')->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'order_id'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Order::where('deliveryBoy_id',$request->dbid)->where('status',2)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)->with('orderaddress')
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Order::where('deliveryBoy_id',$request->dbid)->where('status',2)->Where('order_id', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)->with('orderaddress')
                ->get();
            $totalFiltered = Order::where('deliveryBoy_id',$request->dbid)->where('status',2)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('order_id', 'LIKE', "%{$search}%")->with('orderaddress')
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
          
            if($item->payment_type == 1){
    
    
                $payment_type = '<p >'.__('app.CashonDelivery').'</p>';
              
              }else{
 
 
                 $payment_type = '<p >'.__('app.CardPayment').'</p>';
                  
              }
             
                
              $status = '<p class="badge badge-primary">'.__('app.Confirmed').'</p>';
          
    
            $data[] = array(
    
                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                '<p>'.$item->orderaddress->area.'</p>',
                '<p>'.$item->total_amount.' ₹</p>',
                $payment_type,
                $status,
                '<p>'.$item->created_at.'</p>'
              
              
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

    function fetchAllDeliveryBoyHoldOrder(Request $request){


        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;

        $totalData =  Order::where('deliveryBoy_id',$request->dbid)->where('status',3)->count();
        $rows = Order::where('deliveryBoy_id',$request->dbid)->where('status',3)->orderBy('id', 'DESC')->with("user")->with('orderaddress')->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'order_id'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Order::where('deliveryBoy_id',$request->dbid)->where('status',3)->count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Order::where('deliveryBoy_id',$request->dbid)->where('status',3)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)->with('orderaddress')
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Order::where('deliveryBoy_id',$request->dbid)->where('status',3)->Where('order_id', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)->with('orderaddress')
                ->get();
            $totalFiltered = Order::where('deliveryBoy_id',$request->dbid)->where('status',3)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('order_id', 'LIKE', "%{$search}%")->with('orderaddress')
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
            if($item->payment_type == 1){
    
    
                $payment_type = '<p >'.__('app.CashonDelivery').'</p>';
              
              }else{
 
 
                 $payment_type = '<p >'.__('app.CardPayment').'</p>';
                  
              }
             
                
    
                 $status = '<p class="badge badge-dark text-white">'.__('app.OnHold').'</p>';
        
          
    
            $data[] = array(
    
                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                '<p>'.$item->orderaddress->area.'</p>',
                '<p>'.$currencies.''.$item->total_amount.' </p>',
               '<p>'.$item->reason.' </p>',
                $status,
                '<p>'.$item->created_at.'</p>',
                '<p>'.$item->updated_at.' </p>',
              
              
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

    

    function fetchAllDeliveryBoyCompletedOrder(Request $request){


        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;

        $totalData =  Order::where('deliveryBoy_id',$request->dbid)->where('status',4)->count();
        $rows = Order::where('deliveryBoy_id',$request->dbid)->where('status',4)->orderBy('id', 'DESC')->with("user")->with('orderaddress')->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'order_id'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Order::where('deliveryBoy_id',$request->dbid)->where('status',4)->count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Order::where('deliveryBoy_id',$request->dbid)->where('status',4)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)->with('orderaddress')
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Order::where('deliveryBoy_id',$request->dbid)->where('status',4)->Where('order_id', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)->with('orderaddress')
                ->get();
            $totalFiltered = Order::where('deliveryBoy_id',$request->dbid)->where('status',4)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('order_id', 'LIKE', "%{$search}%")->with('orderaddress')
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
          
            if($item->payment_type == 1){
    
    
                $payment_type = '<p >'.__('app.CashonDelivery').'</p>';
              
              }else{
 
 
                 $payment_type = '<p >'.__('app.CardPayment').'</p>';
                  
              }
             
             
                
    
                    $status = '<p class="badge badge-success">'.__('app.Completed').'</p>';
          

                 $action = '<td><a href="'.route('viewOrder',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger  deleteproduct"><i class="fas fa-trash-alt"></i></a></td>';

                 if($item->status  == 1 || $item->status == 3){

                    $deliery = '<a href="" data-toggle="modal" rel="'.$item->id.'" data-target="#deliveryBoyModal" class="btn btn-primary  confirmOrder"><i class="fas fa-truck"></i></a>';

                 }else{
                    $deliery = '';
                 }
          
    
            $data[] = array(
    
                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                '<p>'.$item->orderaddress->area.'</p>',
                '<p>'.$currencies.''.$item->total_amount.' </p>',
                $payment_type,
                $status,
                '<p>'.$item->created_at.'</p>',
                '<p>'.$item->updated_at.' </p>',
              
              
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

    function addDeliveryBoy(Request $req){

        $result =  Delivery::Where('username',$req->username)->first();

        if($result == null){

            $cat = new Delivery();
      
            $cat->username = Myfunction::customReplace($req->username);
            $cat->password = Myfunction::customReplace($req->password);
            $cat->number = Myfunction::customReplace($req->number);

            $cat->fullname = Myfunction::customReplace($req->fullname);
            $result = $cat->save();

            if($result){
                $data['status'] = true;
                $data['message'] = "add successfull";
       
                echo json_encode($data);
            }else{
                $data['status'] = false;
                $data['message'] = "wrong";
   
            echo json_encode($data);
            }
            
           

        } else{

            $data['status'] = false;
            $data['message'] = "Delivery Boy Allready exist";
 
          echo json_encode($data);

        }

    }

    function getDelivryBoy()
    {
        
        $rows = Delivery::where('is_avialable',1)->orderBy('id','DESC')->get();
    
        
        $data['boys'] = $rows;
        $data['status'] = true;
        $data['message'] = "all data fetch successfull";
        echo json_encode($data);
    }
    function getDbById($id){

        $rows = Delivery::where('id',$id)->first();
        $data['datas'] = $rows;
        $data['status'] = true;
        $data['message'] = "all data fetch successfull";
        echo json_encode($data);
    }
    function editDeliveryBoy(Request $req){


        
        $result =  Delivery::Where('username',$req->username)->whereNotIn('id',[$req->id])->first();

        if($result == null){

                        $id = $req->id ;

                    $item = Delivery::find($id);
                    $item->username = Myfunction::customReplace($req->username);
                    $item->password = Myfunction::customReplace($req->password);
                    $item->number = Myfunction::customReplace($req->number);

                    $item->fullname = Myfunction::customReplace($req->fullname);
                    $result = $item->save();

                    if($result){
                        $data['status'] = true;
                        $data['message'] = "add successfull";

                        echo json_encode($data);
                    }else{
                        $data['status'] = false;
                        $data['message'] = "wrong";

                    echo json_encode($data);
                    }

            } else{

                $data['status'] = false;
                $data['message'] = "Delivery Boy Allready exist";

            echo json_encode($data);

            }
    } 

    function deleteDeliveryBoy($id){

        
        $data =  Delivery::where('id',$id);
        $data->delete();
        
        $data1['status'] = true;
        $data1['message'] = "delete successfull";

        echo json_encode($data1);

    }


    function viewDbDetails($id){


        $data =  Delivery::where('id',$id)->first();


        return view('deliveryboy.viewdbdetails',['data'=>$data]);


    }

    function updatePayment($id){

     

        $item = Delivery::find($id);
        $item->payment = 0;
        $result = $item->save();

        if($result){
            $data['status'] = true;
            $data['message'] = "add successfull";

            echo json_encode($data);
        }else{
            $data['status'] = false;
            $data['message'] = "wrong";

        echo json_encode($data);
        }

    }

    function addUserDetails(Request $req){

        $rules = [
            'username' => 'required',
            'password'=> 'required',
            'device_type'=> 'required',
            'device_token'=> 'required',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

     $data = Delivery::where('username',$req->username)->first();
       
    if($data != null){

    
        
        if($req->username == $data['username'] && $req->password == $data['password']  ){

            $user =  Delivery::find($data['id']);

            $token = random_bytes(200);
            $first = 'Bearer';
            $first .=  bin2hex($token);
        
            $count = Delivery::where('token',$first)->count();
            

              while ($count >= 1) {
                $token = random_bytes(200);
                $first = 'Bearer';
                $first .=  bin2hex($token);
                $count = Delivery::where('token',$first)->count();
              }
              $user->device_token = $req->device_token;
              $user->device_type = $req->device_type;
              $user->token = $first; 
              $user->save();


              $result = Delivery::find($data['id']);
          
            return json_encode(['status'=>true ,'message'=>'login Successfull','data'=> $result ]);
            
        }else{
            return json_encode(['status'=>false ,'message'=>'Password Not Match']);

        }
    
 
      
        
    }else{
        return json_encode(['status'=>false ,'message'=>'User Not Found']);
    }
}

   function logout(){
        
    $token = $_SERVER['HTTP_TOKEN'];
    $result = Delivery::where('token',$token)->first();
    $user_id =   $result['id'];

    $user = Delivery::find( $user_id);

    $user->token = null; 
    $result2 = $user->save();

    if($result2){
    

        return json_encode(['status'=>true ,'message'=>'Logout successfull']);
 
     }else{
        return json_encode(['status'=>false ,'message'=>'something wrong']);

     }
  
    }


    function updateProfile(Request $req){

        $token = $_SERVER['HTTP_TOKEN'];

        $data = Delivery::where('token',$token)->first();
         $id =  $data['id'];

      

        $data = Delivery::where('id',$id)->first();
       
        if($data == null){
    

       return json_encode(['status'=>false ,'message'=>'user id Not vailed']);

    }else{
      
        $user = Delivery::find($id);

        if($req->has('fullname')){
        $user->fullname = Myfunction::customReplace($req->fullname); 
        }

        if($req->has('image')){
        $path = $req->file('image')->store('uploads');
        $user->image = $path;
        }

      
       
       $result = $user->save();
       $userdata = Delivery::where('id',$id)->first();
       if($result){
        return json_encode(['status'=>true ,'message'=>'Upadte successfull','data'=>$userdata]);
       }else{
        return json_encode(['status'=>false ,'message'=>'something wrong']);
       }
    }
    }


    function changeAvialableStatus(Request $req){

        $rules = [
            'is_avialable' => 'required',
            
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

        $token = $_SERVER['HTTP_TOKEN'];

        $data = Delivery::where('token',$token)->first();
         $id =  $data['id'];

      

        $data = Delivery::where('id',$id)->first();
       
        if($data == null){
    

       return json_encode(['status'=>false ,'message'=>'user id Not vailed']);

    }else{
      
        $user = Delivery::find($id);

   
        $user->is_avialable = $req->is_avialable; 
       
       
       $result = $user->save();
       
       $userdata = Delivery::where('id',$id)->first();
       if($result){
        return json_encode(['status'=>true ,'message'=>'Upadte successfull','data'=>$userdata]);
       }else{
        return json_encode(['status'=>false ,'message'=>'something wrong']);
       }
    }
    }

    
    function getProfile(){

    
        $token = $_SERVER['HTTP_TOKEN'];

        $data = Delivery::where('token',$token)->first();

        $data['totalDelivery'] =  Order::where("deliveryBoy_id",$data->id)->where("status",4)->count();

        
        if($data == null){
    

            return json_encode(['status'=>false ,'message'=>'something went wrong']);
     
         }else{
            return json_encode(['status'=>true ,'message'=>'Fetch Data successfull','data'=>$data]);

         }
    }

    function getPendingOrders(Request $req){

        $rules = [
            'start' => 'required',
            'count' => 'required',
            
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

        $token = $_SERVER['HTTP_TOKEN'];

        $users = Delivery::where('token',$token)->first();
        $dbid = $users['id'];

        $data = Order::where('deliveryBoy_id',$dbid)->where('status',2)->skip($req->start)->take($req->count)->with('orderaddress')->with('orderproducts')->with('user')->get();

        return json_encode(['status'=>true ,'message'=>'Fetch Data successfull','data'=>$data]);


        

    }

    function getCompletedOrders(Request $req){

        $rules = [
            'start' => 'required',
            'count' => 'required',
            
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

        $token = $_SERVER['HTTP_TOKEN'];

        $users = Delivery::where('token',$token)->first();
        $dbid = $users['id'];

        $data = Order::where('deliveryBoy_id',$dbid)->where('status',4)->skip($req->start)->take($req->count)->with('orderaddress')->with('orderproducts')->with('user')->get();


        if($data == "[]"){
    

            return json_encode(['status'=>true ,'message'=>'data not found']);
     
         }else{
            return json_encode(['status'=>true ,'message'=>'Fetch Data successfull','data'=>$data]);


         }
       

        

    }


    function getOrderDetails(Request $req){

        $rules = [
            'order_id' => 'required',   
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }


        
        $token = $_SERVER['HTTP_TOKEN'];

        $users = Delivery::where('token',$token)->first();
        $dbid = $users['id'];

        $data = Order::where('order_id',$req->order_id)->with('orderaddress')->with('orderproducts')->first();

        if($data == null){

            return json_encode(['status'=>false ,'message'=>'data not found']);
        }else{
            return json_encode(['status'=>true ,'message'=>'Fetch Data successfull','data'=>$data]);
        }

      

    }

    function completeDelivery(Request $req){

        $rules = [
            'order_id' => 'required',   
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

        $token = $_SERVER['HTTP_TOKEN'];

        $users = Delivery::where('token',$token)->first();
        $dbid = $users['id'];


        if($req->has('payment')){

            Delivery::where('id', $dbid)->increment('payment', $req->payment);
            ;
        }


        $result =  Order::where('order_id', $req->order_id)->update(['status'=> 4]);

        $data = Order::where('order_id', $req->order_id)->first();

        $user = new Usernotification();
        $user->user_id = $data->user_id;
        $user->order_id = $data->id;
        $user->status = 4;
        $user->save();

        
        
        $userData = Users::where('id', $data->user_id)->first();

        Users::send_push($userData->device_token,$data->order_id,"Your order is completed",1);

        if($result){
            return json_encode(['status'=>true ,'message'=>'Completed successfull']);
           }else{
            return json_encode(['status'=>false ,'message'=>'something Went Worng']);
           }


    }

    function onHoldDelivery(Request $req){

        $rules = [
            'order_id' => 'required',   
            'reason' => 'required',   
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }


        $result =  Order::where('order_id', $req->order_id)->update(['deliveryBoy_id' => null,'status'=> 3,'reason'=>Myfunction::customReplace($req->reason),'dbname'=>null,'dbnumber'=>null,'start_delivery'=>0]);

        
        $data = Order::where('order_id', $req->order_id)->first();

        $user = new Usernotification();
        $user->user_id = $data->user_id;
        $user->order_id = $data->id;
        $user->status = 3;
        $user->save();

        
        $userData = Users::where('id', $data->user_id)->first();

        Users::send_push($userData->device_token,$data->order_id,"Your order is on hold",1);

        if($result){
            return json_encode(['status'=>true ,'message'=>'On Hold successfull']);
           }else{
            return json_encode(['status'=>false ,'message'=>'something Went Worng']);
           }


    }


    function startDelivery(Request $req){


        $rules = [
            'order_id' => 'required',   
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }


        $result =  Order::where('order_id', $req->order_id)->update(['start_delivery' => 6]);

        
        $data = Order::where('order_id', $req->order_id)->first();

        $user = new Usernotification();
        $user->user_id = $data->user_id;
        $user->order_id = $data->id;
        $user->status = 6;
        $user->save();

        $userData = Users::where('id', $data->user_id)->first();

        Users::send_push($userData->device_token,$data->order_id,"Your order is out for delivery",1);

        if($result){
            return json_encode(['status'=>true ,'message'=>'Update  successfull']);
           }else{
            return json_encode(['status'=>false ,'message'=>'something Went Worng']);
           }
    }

}
