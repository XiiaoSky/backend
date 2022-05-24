<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\customid;
use App\Models\Myfunction;
use App\Models\Order;
use App\Models\Users;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;


class ComplaintController extends Controller
{
    function raiseComplaint(Request $req){

        $rules = [
            'order_id'=> 'required',
            'mobile_no'=> 'required',
            'title'=> 'required',
            'description'=> 'required',
        ];
        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

       $count = Complaint::where('order_id',$req->order_id)->count();

       if($count != 0){
        return json_encode(['status'=>false ,'message'=>'you Allready submited complaint']);
       }else{
      

        $user_id = $_SERVER['HTTP_USERID'];
        $customids =   customid::find(1);
        $item =  new Complaint();

       $token =  rand(100000,999999);
       $first =$customids['cf'];
       $first .= $token;
   
       $count = Complaint::where('complaints_id',$first)->count();

       while ($count >= 1) {
           $token = rand(100000,999999);
           $first = $customids['cf'];
           $first .=  $token;
           $count = Complaint::where('complaints_id',$first)->count();

         }
       $item->complaints_id = $first;
       $item->user_id = $user_id;
       $item->title = Myfunction::customReplace($req->title);
       $item->description = Myfunction::customReplace($req->description);
       $item->mobile_no = Myfunction::customReplace($req->mobile_no);
        $item->order_id = Myfunction::customReplace($req->order_id);
       $result = $item->save();

       Order::where('order_id', $req->order_id)->update(['has_complaint' => 1]);

      if($result){
        return json_encode(['status'=>true ,'message'=>'raiseComplaint successfull']);
       }else{
        return json_encode(['status'=>false ,'message'=>'something wrong']);
       }
       }

      
    }

    function fetchAllComplaint(Request $request){


        $totalData =  Complaint::where('status',0)->count();
        $rows = Complaint::where('status',0)->orderBy('id', 'DESC')->with("user")->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'title'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Complaint::where('status',0)->count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Complaint::where('status',0)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Complaint::where('status',0)->Where('title', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Complaint::where('status',0)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
             
    
             
               if($item->status == 1){
    
    
                $status =  '<p class="badge badge-success text-white">'.__('app.Close').'</p>';
                 
                 }
                 else{
       
                   $status = '<p class="badge badge-danger text-white">'.__('app.Open').'</p>';
       
                 }
                 $action = '<td><a href="'.route('viewComplaint',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
                 
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger deleteComplaint "><i class="fas fa-trash-alt"></i></a></td>';
          
    
            $data[] = array(
    
              
                '<p>'.$item->complaints_id.'</p>',
                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                $status,
                '<p>'.  $item->created_at->format('d M Y g:i A') .'</p>',
                '<a href=""  data-toggle="modal" rel="'.$item->id.'" data-target="#ansModel"  class="btn btn-primary move "><i class="fas fa-share-square "></i></a>',
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


       function fetchAllCloseComplaint(Request $request){


        $totalData =  Complaint::where('status',1)->count();
        $rows = Complaint::where('status',1)->orderBy('id', 'DESC')->with("user")->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'title'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Complaint::where('status',1)->count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Complaint::where('status',1)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Complaint::where('status',1)->Where('title', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Complaint::where('status',1)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
             
    
             
               if($item->status == 1){
    
    
                $status =  '<p class="badge badge-success text-white">'.__('app.Close').'</p>';
                 
                 }
                 else{
       
                   $status = '<p class="badge badge-danger text-white">'.__('app.Open').'</p>';
       
                 }
                 $action = '<td><a href="'.route('viewComplaint',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
                 
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger deleteComplaint  "><i class="fas fa-trash-alt"></i></a></td>';
          
    
            $data[] = array(
    
              
                '<p>'.$item->complaints_id.'</p>',
                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                $status,
                '<p>'.  $item->created_at->format('d M Y g:i A') .'</p>',
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

    function moveToClose(Request $req){

 
    return Complaint::where('id', $req->id)->update(['status' => 1,'answer'=> Myfunction::customReplace($req->answer)]);

    }

    function deleteComplaint($id){
        

        
    $data =  Complaint::where('id',$id);
    $data->delete();
    
    $data1['status'] = true;
    $data1['message'] = "delete successfull";

    echo json_encode($data1);

    }

    
    function viewComplaint($id){


        $data = Complaint::where('id',$id)->with('user')->first();
  
        return view('order.viewcomplaint',["data"=>$data]);
  
      }

      function getComplaintForWeb($id){
        $data = Complaint::where('id',$id)->first();
    
        
        
        echo json_encode($data);
      }
 
function deleteWebComplaint(Request $req){
    $data =  Complaint::where('id',$req->id)->first();

    Order::where('order_id', $data->order_id)->update(['has_complaint' => 0]);
    $data->delete();
    return json_encode(['status'=>true ,'message'=>'Delete successfull']);
}
    
    function getAllComplaint(Request $req){

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


        if($req->type == 0){
            $data = Complaint::where('user_id',$user_id)->where('status',0)->skip($req->start)->take($req->count)->orderBy('id', 'DESC')->with("user")->get();

            return json_encode(['status'=>true ,'message'=>'Fetch All Data successfull','data'=>$data]);
        }elseif($req->type == 1){
            $data = Complaint::where('user_id',$user_id)->where('status',1)->skip($req->start)->take($req->count)->orderBy('id', 'DESC')->with("user")->get();

            return json_encode(['status'=>true ,'message'=>'Fetch All Data successfull','data'=>$data]);

        }else{
            $data = Complaint::where('user_id',$user_id)->orderBy('id', 'DESC')->get();

            return json_encode(['status'=>true ,'message'=>'Fetch All Data successfull','data'=>$data]);
        }

       

      }
}
