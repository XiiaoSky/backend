<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderproduct;
use App\Models\UsedCoupon;
use App\Models\Coupon;
use App\Models\customid;
use App\Models\Delivery;
use App\Models\Images;

use App\Models\Product;
use App\Models\Setting;
use App\Models\Usernotification;
use App\Models\Users;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Stripe;


class OrderController extends Controller
{


    function onlineOrder(Request $req){


        require 'vendor/autoload.php';
        header('Access-Control-Allow-Origin: *');
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
        
        function calculateOrderAmount(array $items): int {
        
          return 1400;
        }
        
        header('Content-Type: application/json');
        
        try {
         
          $json_str = file_get_contents('php://input');
          $json_obj = json_decode($json_str);
        
          $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => calculateOrderAmount($json_obj->items),
            'description' => 'Vegi Online Payment',
  'shipping' => [
    'name' =>  $json_obj->username,
    'address' => [
      'line1' => '510 Townsend St',
      'postal_code' => '98140',
      'city' => 'San Francisco',
      'state' => 'CA',
      'country' => 'US',
    ],
  ],
  'amount' => $json_obj->amount * 100,
  'currency' => 'usd',
  'payment_method_types' => ['card'],
          ]);
        
          $output = [
            'clientSecret' => $paymentIntent->client_secret,
          ];
        
          echo json_encode($output);
        } catch (Error $e) {
          http_response_code(500);
          echo json_encode(['error' => $e->getMessage()]);
        }
   

    }


    function onlinePlaceOrder(Request $req){
  
        $rules = [
            'payment_id'=> 'required',
            'address_id'=> 'required',
            'payment_type'=> 'required',
            'payment_name'=> 'required',
            'total_amount'=> 'required',
            'shipping_charge'=> 'required',
            'quantity'=> 'required',
            'product_id'=> 'required',
            'product_name'=> 'required',
            'price_unit_name'=> 'required',
            'price_unit'=> 'required',
            'image'=> 'required',
            'price'=> 'required',
            'subtotal'=> 'required',
            'total_price'=> 'required',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }



           $data =   Http::withHeaders([
            'Authorization' => 'Bearer sk_test_51InzNxSHjnacs33DJSVREeP65xvWb3aImRvsv0LVDmK3GfJmWWbkGmMVABEVk3vjcUO2lHpq9dHHFKcMlx89Jmh0009CHtYUXf'
        ])->get('https://api.stripe.com/v1/payment_intents/'.$req->payment_id.'');
   


     $cretedDate = date('Y-m-d H:s:i', $data['created']); 
     $nowDate = date('Y-m-d H:s:i',Carbon::now()->timestamp) ;

     $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $cretedDate);
     $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i',$nowDate );
     
     
     $diff_in_minutes = $to->diffInMinutes($from);

  

     
        if($diff_in_minutes  <= 5){
            if($data['status'] === "succeeded"){


                $user_id =   $_SERVER['HTTP_USERID'];
                $paymentCount = Order::where('payment_id',$req->payment_id)->count();
                if( $paymentCount == 0){

                    $customids =   customid::find(1);
        
                    $order = new Order();
            
                    if($req->has('coupon_discount')){
                        $order->coupon_discount = $req->coupon_discount;
                    }
                    
            
                    $token =  rand(10000000,99999999);
                    $first = $customids['of'];
                    $first .= $token;
                
                    $count = Order::where('order_id',$first)->count();
            
                    while ($count >= 1) {
                        $token = rand(10000000,99999999);
                        $first = $customids['of'];
                        $first .=  $token;
                        $count = Order::where('order_id',$first)->count();
            
                      }
                    
            
                    $order->order_id = $first;
                    $order->user_id = $user_id;
                    $order->address_id = $req->address_id;
                    $order->payment_type = $req->payment_type;
                    $order->payment_name = $req->payment_name;
                    $order->payment_id = $req->payment_id;
                    $order->total_amount = $req->total_amount;
                    $order->subtotal = $req->subtotal;
                    $order->shipping_charge = $req->shipping_charge;
                   
                    $order->date =  Carbon::now();
                    $order->save();
            
                    
                    $orders =  Order::latest()->first();
                    $order_id = $orders['id'];
                    $mainOrderId =  $orders['order_id'];
                
                      $product_name = $req->product_name;
                      $image = $req->image;
                      $price = $req->price;
                      $total_price = $req->total_price;
                      $price_unit_name = $req->price_unit_name;
                      $price_unit = $req->price_unit;
                      $quantity = $req->quantity;
                       $n =  count($product_name);
                       for ($i=0; $i < $n; $i++) {
            
                        $orderproduct  = new Orderproduct();
            
                        $orderproduct->product_name = $product_name[$i];
                        $orderproduct->image = $image[$i];
                        $orderproduct->price = $price[$i];
                        $orderproduct->total_price = $total_price[$i];
                        $orderproduct->price_unit_name = $price_unit_name[$i];
                        $orderproduct->price_unit = $price_unit[$i];
                        $orderproduct->quantity = $quantity[$i];
                        $orderproduct->order_id = $order_id;
                        $orderproduct->save();
                           
                       }
                        
            
                    $address = Address::where('id',$req->address_id)->with('city')->with('area')->first();
            
                    $orderAdd = new OrderAddress;
            
                    $orderAdd->order_id = $order_id;
                    $orderAdd->city = $address['city']['name'];
                    $orderAdd->area = $address['area']['name'];
                    $orderAdd->fullname = $address['fullname'];
                    $orderAdd->number = $address['number'];
                    $orderAdd->alt_number = $address['alt_number'];
                    $orderAdd->landmark = $address['landmark'];
                    $orderAdd->address = $address['address'];
                    $orderAdd->is_default	 = $address['is_default'];
                    $orderAdd->address_type = $address['address_type'];
                    $orderAdd->pincode = $address['pincode'];
                    $orderAdd->latitude = $address['latitude'];
                    $orderAdd->longitude = $address['longitude'];
            
                   $result = $orderAdd->save();
            
                   $user = new Usernotification();
                   $user->user_id = $user_id;
                   $user->order_id =   $order_id;
                   $user->status = 1;
                   $user->save();
            
                   if($result){
                    return json_encode(['status'=>true ,'message'=>'Place order successfull','order_id'=>$mainOrderId ]);
                   }else{
                    return json_encode(['status'=>false ,'message'=>'something wrong']);
                   }

                }else{
                    return json_encode(['status'=>false,'message'=>"fake payment method"]);
                }
           

                 
               
                
            }else{
                return json_encode(['status'=>false,'message'=>"fake payment method "]); 
            }
        }else{
            return json_encode(['status'=>false,'message'=>"fake payment method "]);
        }

      
    }

    function viewOrder($id){


      $data = Order::where('id',$id)->with('user')->with('orderaddress')->with('deliveryboy')->with('orderproducts')->first();

 

      return view('order.vieworder',["data"=>$data]);

    }

    function deleteOrder($id){

        $data =  Order::where('id',$id);
           $data->delete();
           
           $data1['status'] = true;
           $data1['message'] = "delete successfull";
  
           echo json_encode($data1);

    }

    function confirmOrder(Request $req){

       

        $db = Delivery::where('id', $req->deliveryBoy_id)->first();

       $result =  Order::where('id', $req->id)->update(['deliveryBoy_id' => $req->deliveryBoy_id,'status'=> 2,'dbname'=>$db['fullname'],'dbnumber'=>$db['number']]);

       $data = Order::where('id', $req->id)->first();


      $user = new Usernotification();
      $user->user_id = $data->user_id;
      $user->order_id = $req->id;
      $user->status = 2;
      $user->save();

      $userData = Users::where('id', $data->user_id)->first();

      Users::send_push($userData->device_token,$data->order_id,"Your order is Confirmed",1);

        if($result){
            $data['status'] = true;
            $data['message'] = "Confirm Successfull";
   
            echo json_encode($data);
           }else{
            $data['status'] = false;
            $data['message'] = "Something worng";
 
              echo json_encode($data);
           }


    }

    function fetchAllProcessingOrder(Request $request){

        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;

        $totalData =  Order::where('status',1)->count();
        $rows = Order::where('status',1)->orderBy('id', 'DESC')->with("user")->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'order_id'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Order::where('status',1)->count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Order::where('status',1)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Order::where('status',1)->Where('order_id', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Order::where('status',1)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('order_id', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
          
                if($item->payment_type == 1){
    
    
                   $payment_type = '<p >'.__('app.CashonDelivery').'</p>';
                 
                 }else{
    
    
                    $payment_type = '<p >'.__('app.CardPayment').'</p>';
                     
                 }
             
             
                if($item->status == 1){
    
    
                $status = '<p class="badge badge-info text-uppercase text-white">'.__('app.Processing').'</p>';
                 
                 }
                

                 $action = '<td><a href="'.route('viewOrder',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger  deleteOrder"><i class="fas fa-trash-alt"></i></a></td>';

                 if($item->status  == 1 || $item->status == 3){

                    $deliery = '<a href="" data-toggle="modal" rel="'.$item->id.'" data-target="#deliveryBoyModal" class="btn btn-primary  confirmOrder"><i class="fas fa-truck"></i></a>';

                 }else{
                    $deliery = '';
                 }
          
    
            $data[] = array(
    
                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                '<p>'.$currencies.' '.$item->total_amount.' </p>',
                $status,
                $payment_type,
                '<p>'.  $item->created_at->format('d M Y g:i A') .'</p>',
                $action,
                $deliery
              
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


    function fetchAllConfirmedOrder(Request $request){


        
        $settingData = Db::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;
        $totalData =  Order::where('status',2)->count();
        $rows = Order::where('status',2)->orderBy('id', 'DESC')->with("user")->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'order_id'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Order::where('status',2)->count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Order::where('status',2)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Order::where('status',2)->Where('order_id', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Order::where('status',2)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('order_id', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
          
                if($item->payment_type == 1){
    
    
                   $payment_type = '<p >'.__('app.CashonDelivery').'</p>';
                 
                 }else{
    
    
                    $payment_type = '<p >'.__('app.CardPayment').'</p>';
                     
                 }
             
             
                  if($item->status == 2){
    
    
                    $status = '<p class="badge badge-primary text-uppercase text-white ">'.__('app.Confirmed').'</p>';
                     
                 }

                 

                 $action = '<td><a href="'.route('viewOrder',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger  deleteOrder"><i class="fas fa-trash-alt"></i></a></td>';

                 if($item->status  == 1 || $item->status == 3){

                    $deliery = '<a href="" data-toggle="modal" rel="'.$item->id.'" data-target="#deliveryBoyModal" class="btn btn-primary  confirmOrder"><i class="fas fa-truck"></i></a>';

                 }else{
                    $deliery = '';
                 }
          
    
            $data[] = array(
    
                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                '<p>'.$currencies.' '.$item->total_amount.' </p>',
                $status,
                $payment_type,
                '<p>'.  $item->created_at->format('d M Y g:i A') .'</p>',
                $action,
                $deliery
              
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

    function fetchAllHoldOrder(Request $request){

        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;

        $totalData =  Order::where('status',3)->count();
        $rows = Order::where('status',3)->orderBy('id', 'DESC')->with("user")->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'order_id'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Order::where('status',3)->count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Order::where('status',3)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Order::where('status',3)->Where('order_id', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Order::where('status',3)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('order_id', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
          
                if($item->payment_type == 1){
    
    
                   $payment_type = '<p >'.__('app.CashonDelivery').'</p>';
                 
                 }else{
    
    
                    $payment_type = '<p >'.__('app.CardPayment').'</p>';
                     
                 }
             
             
                if($item->status == 3){
    
    
    $status = '<p class="badge badge-dark text-white text-uppercase">'.__('app.OnHold').'</p>';
                     
                 }

                 

                 $action = '<td><a href="'.route('viewOrder',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger  deleteOrder"><i class="fas fa-trash-alt"></i></a></td>';

                 if($item->status  == 1 || $item->status == 3){

                    $deliery = '<a href="" data-toggle="modal" rel="'.$item->id.'" data-target="#deliveryBoyModal" class="btn btn-primary  confirmOrder"><i class="fas fa-truck"></i></a>';

                 }else{
                    $deliery = '';
                 }
          
    
            $data[] = array(
    
                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                '<p>'.$currencies.' '.$item->total_amount.' </p>',
                $status,
                '<p>'.$item->reason.' </p>',
                '<p>'.  $item->created_at->format('d M Y g:i A') .'</p>',
                $action,
                $deliery
              
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


    function fetchAllCompletedOrder(Request $request){


        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;
        $totalData =  Order::where('status',4)->count();
        $rows = Order::where('status',4)->orderBy('id', 'DESC')->with("user")->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'order_id'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Order::where('status',4)->count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Order::where('status',4)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Order::where('status',4)->Where('order_id', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Order::where('status',4)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('order_id', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
          
                if($item->payment_type == 1){
    
    
                   $payment_type = '<p >'.__('app.CashonDelivery').'</p>';
                 
                 }else{
    
    
                    $payment_type = '<p >'.__('app.CardPayment').'</p>';
                     
                 }
             
             
               if($item->status == 4){
    
    
                    $status = '<p class="badge badge-success text-uppercase text-white">'.__('app.Completed').'</p>';
                     
                 }

                 $action = '<td><a href="'.route('viewOrder',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger  deleteOrder"><i class="fas fa-trash-alt"></i></a></td>';

                 if($item->status  == 1 || $item->status == 3){

                    $deliery = '<a href="" data-toggle="modal" rel="'.$item->id.'" data-target="#deliveryBoyModal" class="btn btn-primary  confirmOrder"><i class="fas fa-truck"></i></a>';

                 }else{
                    $deliery = '';
                 }
          
    
            $data[] = array(
    
                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                '<p>'.$currencies.' '.$item->total_amount.' </p>',
                $status,
                $payment_type,
                '<p>'.  $item->created_at->format('d M Y g:i A') .'</p>',
                $action,
                $deliery
              
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


    function fetchAllCancelledOrder(Request $request){

        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;
        $totalData =  Order::where('status',5)->count();
        $rows = Order::where('status',5)->orderBy('id', 'DESC')->with("user")->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'order_id'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Order::where('status',5)->count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Order::where('status',5)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Order::where('status',5)->Where('order_id', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Order::where('status',5)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('order_id', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
          
                if($item->payment_type == 1){
    
    
                   $payment_type = '<p >'.__('app.CashonDelivery').'</p>';
                 
                 }else{
    
    
                    $payment_type = '<p >'.__('app.CardPayment').'</p>';
                     
                 }
             
             
             
    
                    $status = '<p class="badge badge-danger text-uppercase text-white">'.__('app.Cancelled').'</p>';
        

                 $action = '<td><a href="'.route('viewOrder',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger  deleteOrder"><i class="fas fa-trash-alt"></i></a></td>';

                 if($item->status  == 1 || $item->status == 3){

                    $deliery = '<a href="" data-toggle="modal" rel="'.$item->id.'" data-target="#deliveryBoyModal" class="btn btn-primary  confirmOrder"><i class="fas fa-truck"></i></a>';

                 }else{
                    $deliery = '';
                 }
          
    
            $data[] = array(
    
                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                '<p>'.$currencies.' '.$item->total_amount.' </p>',
                $status,
                $payment_type,
                '<p>'.  $item->created_at->format('d M Y g:i A') .'</p>',
                $action,
                $deliery
              
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

    function fetchAllOrder(Request $request){

        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;

        $totalData =  Order::count();
        $rows = Order::orderBy('id', 'DESC')->with("user")->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'order_id'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Order::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Order::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Order::Where('order_id', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Order::where('id', 'LIKE', "%{$search}%")
                ->orWhere('order_id', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
          
                if($item->payment_type == 1){
    
    
                   $payment_type = '<p >'.__('app.CashonDelivery').'</p>';
                 
                 }else{
    
    
                    $payment_type = '<p >'.__('app.CardPayment').'</p>';
                     
                 }
             
             
                if($item->status == 1){
    
    
                $status = '<p class="badge badge-info text-uppercase text-white">'.__('app.Processing').'</p>';
                 
                 }
                 elseif($item->status == 2){
    
    
                    $status = '<p class="badge badge-primary text-uppercase text-white">'.__('app.Confirmed').'</p>';
                     
                 }

                 elseif($item->status == 3){
    
    
                    $status = '<p class="badge badge-dark text-uppercase text-white">'.__('app.OnHold').'</p>';
                     
                 }

                 elseif($item->status == 4){
    
    
                    $status = '<p class="badge badge-success text-uppercase text-white">'.__('app.Completed').'</p>';
                     
                 }else{
    
    
                    $status = '<p class="badge badge-danger text-uppercase text-white">'.__('app.Cancelled').'</p>';
                     
                 }

                 $action = '<td><a href="'.route('viewOrder',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger  deleteOrder"><i class="fas fa-trash-alt"></i></a></td>';

                 if($item->status  == 1 || $item->status == 3){

                    $deliery = '<a href="" data-toggle="modal" rel="'.$item->id.'" data-target="#deliveryBoyModal" class="btn btn-primary  confirmOrder"><i class="fas fa-truck"></i></a>';

                 }else{
                    $deliery = '';
                 }
          
    
            $data[] = array(
    
                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                '<p>'.$currencies.''.$item->total_amount.' </p>',
                $status,
                $payment_type,
                '<p>'.  $item->created_at->format('d M Y g:i A') .'</p>',
                $action,
                $deliery
              
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

    //  ====================================================api  ====================
    function getCoupon(){


        $user_id =  $_SERVER['HTTP_USERID'];

        $usedcouponList =   UsedCoupon::where('user_id',$user_id)->pluck('coupon_id')->toArray();
 
        $data = Coupon::whereNotIn('id',$usedcouponList)->orderBy('id', 'DESC')->get();

        return json_encode(['status'=>true ,'message'=>'Fetch Data successfull','data'=>$data]);


    }


    function getMyOrderList(Request $req){

        $rules = [
            'start'=> 'required',
            'count'=> 'required',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

    

        $user_id =  $_SERVER['HTTP_USERID'];

        $data =   Order::where('user_id',$user_id)->skip($req->start)->take($req->count)->with('orderaddress')->with('deliveryboy')->with('orderproducts')->with('rating')->orderBy('id', 'DESC')->get();

        $setting = Setting::first();
      

        return json_encode(['status'=>true ,'message'=>'Fetch Data successfull','data'=>$data,'setting'=>$setting]);


    }

    function getOrderDetailsById(Request $req){

  

        $user_id = $_SERVER['HTTP_USERID'];

        $rules = [
            'order_id'=> 'required',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

    $data =   Order::where('user_id',$user_id)->where('order_id',$req->order_id)->with('orderaddress')->with('deliveryboy')->with('orderproducts')->with('rating')->first();
 
        if($data == null){
            return json_encode(['status'=>false ,'message'=>'data not fouund']);
        }else{

        return json_encode(['status'=>true ,'message'=>'Fetch Data successfull','data'=>$data]);
        }

    }


    function applyCoupan(Request $req){


        $rules = [
            'coupon_id' => 'required',
            'totalamount'=> 'required',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

        $totalamount = $req->totalamount;
        $data = Coupon::where('id',$req->coupon_id)->first();

        $minamount =  $data['minamount'];


       
        $user_id =    $_SERVER['HTTP_USERID'];

        if($minamount > $totalamount  ){


            return json_encode(['status'=>false ,'message'=>'minamount Not vailed']);


        }else{

            
            $discount = $data['discount'];
            $type = $data['type'];

          $item = new UsedCoupon;
          $item->user_id = $user_id;
          $item->coupon_id =$req->coupon_id;
          $item->save();

         if($type == 1){
                    
             
                   $discount_percent = $discount;
                  $coupon_discount =  $discount ;
                  $subtotal =  $totalamount - $coupon_discount;

         }else{

           $discount = rand(0,$discount);
            $discount_percent = $discount;

            $coupon_discount =  $totalamount * $discount / 100;
            $subtotal =  $totalamount - $coupon_discount;
         }

        
          

          return json_encode(['status'=>true ,'message'=>'data fetch successfull','coupan_discount'=>$coupon_discount,'subtotal'=> $subtotal,'discount_percent'=> $discount_percent]);

          

        }


    }

    function checkProduct(Request $req){


        $user_id =    $_SERVER['HTTP_USERID'];
        
        $orderCount = Order::where("user_id",$user_id)->whereIn('status',[1,2,3])->count();
        if($orderCount >= 3){

            return json_encode(["status"=>false,"message"=>"You reached the maximum order"]);
        }else{
   
        foreach($req->product_id as $oneid){
         
            $idsdata  = Product::where('id',$oneid)->first();
   
            if($idsdata == ""){
     return json_encode(['status'=>false,'message'=>"not available","product_id"=>$oneid,"code"=>"itemDeleted"]); 
            }else{
                if($idsdata['stock'] == 0){
   
                    $messages = $idsdata['name'];
                    $messages .= " is out of stock";

                return json_encode(['status'=>false,'message'=>$messages,"code"=>"itemOutOfStock"]); 
            }
               
            }
           
   
           }
           return json_encode(['status'=>true,"message"=>"all item Avalible"]);
        }
    }


    function placeOrder(Request $req){


        
        $rules = [
            'address_id'=> 'required',
            'payment_type'=> 'required',
            'payment_id'=> 'required',
            'payment_name'=> 'required',
            'total_amount'=> 'required',
            'shipping_charge'=> 'required',
            'quantity'=> 'required',
            'product_id'=> 'required',
            'product_name'=> 'required',
            'price_unit_name'=> 'required',
            'price_unit'=> 'required',
            'image'=> 'required',
            'price'=> 'required',
            'subtotal'=> 'required',
            'total_price'=> 'required',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }




    
        $user_id =   $_SERVER['HTTP_USERID'];


         $orderCount = Order::where("user_id",$user_id)->whereIn('status',[1,2,3])->count();


         
            $customids =   customid::find(1);

        $order = new Order();

        if($req->has('coupon_discount')){
            $order->coupon_discount = $req->coupon_discount;
        }
        

        $token =  rand(10000000,99999999);
        $first = $customids['of'];
        $first .= $token;
    
        $count = Order::where('order_id',$first)->count();

        while ($count >= 1) {
            $token = rand(10000000,99999999);
            $first = $customids['of'];
            $first .=  $token;
            $count = Order::where('order_id',$first)->count();

          }
        

        $order->order_id = $first;
        $order->user_id = $user_id;
        $order->address_id = $req->address_id;
        $order->payment_type = $req->payment_type;
        $order->payment_name = $req->payment_name;
        $order->payment_id = $req->payment_id;
        $order->total_amount = $req->total_amount;
        $order->subtotal = $req->subtotal;
        $order->shipping_charge = $req->shipping_charge;
       
        $order->date =  Carbon::now();
        $order->save();

        
        $orders =  Order::latest()->first();
        $order_id = $orders['id'];
$mainOrderId =  $orders['order_id'];
    
          $product_name = $req->product_name;
     
          $image = $req->image;


          
          $price = $req->price;
      
          
          $total_price = $req->total_price;
      


          $price_unit_name = $req->price_unit_name;
    

          
          $price_unit = $req->price_unit;
        

          $quantity = $req->quantity;
        
           $n =  count($product_name);
           for ($i=0; $i < $n; $i++) {

            $orderproduct  = new Orderproduct();

            $orderproduct->product_name = $product_name[$i];
            $orderproduct->image = $image[$i];
            $orderproduct->price = $price[$i];
            $orderproduct->total_price = $total_price[$i];
            $orderproduct->price_unit_name = $price_unit_name[$i];
            $orderproduct->price_unit = $price_unit[$i];
            $orderproduct->quantity = $quantity[$i];
            $orderproduct->order_id = $order_id;
            $orderproduct->save();
               
           }
            

        $address = Address::where('id',$req->address_id)->with('city')->with('area')->first();

        $orderAdd = new OrderAddress;

        $orderAdd->order_id = $order_id;
        $orderAdd->city = $address['city']['name'];
        $orderAdd->area = $address['area']['name'];
        $orderAdd->fullname = $address['fullname'];
        $orderAdd->number = $address['number'];
        $orderAdd->alt_number = $address['alt_number'];
        $orderAdd->landmark = $address['landmark'];
        $orderAdd->address = $address['address'];
        $orderAdd->is_default	 = $address['is_default	'];
        $orderAdd->address_type = $address['address_type'];
        $orderAdd->pincode = $address['pincode'];
        $orderAdd->latitude = $address['latitude'];
        $orderAdd->longitude = $address['longitude'];

       $result = $orderAdd->save();

       $user = new Usernotification();
       $user->user_id = $user_id;
       $user->order_id =   $order_id;
       $user->status = 1;
       $user->save();

       if($result){
        return json_encode(['status'=>true ,'message'=>'Place order successfull','order_id'=>$mainOrderId ]);
       }else{
        return json_encode(['status'=>false ,'message'=>'something wrong']);
       }
        
    

    }

    function cancelledOrder(Request $req){

        $rules = [
            'order_id'=> 'required',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }
       $result = Order::where('order_id', $req->order_id)->update(['status' => 5]);

       $data = Order::where('order_id', $req->order_id)->first();

       $user = new Usernotification();
       $user->user_id = $data->user_id;
       $user->order_id = $data->id;
       $user->status = 5;
       $user->save();

       if($result){
        return json_encode(['status'=>true ,'message'=>'Canceled successfull']);
       }else{
        return json_encode(['status'=>false ,'message'=>'something wrong']);
       }


    }

    
}
