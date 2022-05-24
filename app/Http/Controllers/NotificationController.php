<?php

namespace App\Http\Controllers;

use App\Models\Myfunction;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Usernotification;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    function fetchAllNoti(Request $request){

        $totalData =  Notification::count();
        $rows = Notification::orderBy('id', 'DESC')->get();


        $categories = $rows;

        $columns = array(
            0 => 'id',
            1 => 'title'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Notification::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $categories = Notification::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $categories =  Notification::Where('title', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered =Notification::where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($categories as $cat) {
     

              $id =$cat->id;
           

            $news_count = 5;

            if($cat->image == null){
               $image = '<img src="'. asset('asset/image/default.png') .'" width="100" height="100">';
             }else{
               $image = '<img src="public/storage/'.$cat->image.'" width="100" height="100">';
            }

            $data[] = array(
             
                $image,
             '<p>'.$cat->title.'</p>',
             '<p >'.$cat->message.'</p>',

             '<a href="" data-toggle="modal" rel="'.$cat->id.'"  data-target="#edit_cat_modal" class="btn btn-primary  editnoti"><i class="fas fa-edit"></i></a>',
             '<a href = ""  rel = "'.$cat->id.'" class = "btn btn-danger delete-noti text-white" > <i class="fas fa-trash-alt"></i> </a>',
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

    
    function getNotiById($id){
        
          $rows = Notification::where('id',$id)->first();
    
        
          $data['notis'] = $rows;
          $data['status'] = true;
          $data['message'] = "all data fetch successfull";
          echo json_encode($data);
       
    }


    function deleteNoti($id){

           $data =  Notification::where('id',$id);
           $data->delete();
           
           $data1['status'] = true;
           $data1['message'] = "delete successfull";
  
           echo json_encode($data1);

    }

    function addNotification(Request $req){

      
            $cat = new Notification();
      
            $cat->title = Myfunction::customReplace($req->title);
            $cat->message = Myfunction::customReplace($req->message);

            if($req->has('image')){
                if($req->image != ""){
               $path = $req->file('image')->store('uploads','public');
        
               $cat->image = $path;
        
               }
             }
         
            $cat->save();



            $title =       $req->title;
            $descreption  = $req->message;
            $image  = env('image')."public/storage/" . $path;
        
            $url = 'https://fcm.googleapis.com/fcm/send';
            $api_key = env('FCM_TOKEN');
            $notificationArray = array('title' =>$title, 'body' => $descreption, 'sound' => 'default','image'=>$image, 'badge' => '1');
            $fields = array('to' => '/topics/Vegi', 'notification' => $notificationArray, 'priority' => 'high');
            $headers = array(
                'Content-Type:application/json',
                'Authorization:key=' . $api_key
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
      
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
                Log::debug(curl_error($ch));
            }
            curl_close($ch);
            $data['status'] = true;
            $data['message'] = "add successfull";

            echo json_encode($data);
           

        

    }

    function updateNoti(Request $req){

       
     

        if($req->image == ""){
            Notification::where('id', $req->id)->update(['title' => Myfunction::customReplace($req->title),
                                                         'message' => Myfunction::customReplace($req->message)
                                                           ]);
        }else{
            $path = $req->file('image')->store('uploads');
            Notification::where('id', $req->id)->update(['title' => $req->title,'image' => $path,'message' => $req->message ]);
          
        }

        $data['status'] = true;
        $data['message'] = "update successfull";

        echo json_encode($data);

  

    }


    function getAllUserNotification(Request $req){

        
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

        
        $user_id =  $_SERVER['HTTP_USERID'];

        $data = Usernotification::where('user_id',$user_id)->skip($req->start)->take($req->count)->orderBy('id', 'DESC')->with('order')->get();


        
    
        return json_encode(['status'=>true ,'message'=>'Fetch All Data successfull','data'=>$data]);
    }

    function getAllNotification(Request $req){

        
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



        $data = Notification::skip($req->start)->take($req->count)->orderBy('id', 'DESC')->get();

        
    
        return json_encode(['status'=>true ,'message'=>'Fetch All Data successfull','data'=>$data]);
    }
 


}
