<?php

namespace App\Http\Controllers;

use App\Models\Myfunction;
use App\Models\Review;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ReviewController extends Controller
{
    function productReviewRating(Request $req){

        $rules = [
            'order_id'=> 'required',
            'review'=> 'required',
            'rating'=> 'required',

           
        ];
        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

      

        $user_id = $_SERVER['HTTP_USERID'];

       $item =  new Review();

       $item->user_id = $user_id;
       $item->review = Myfunction::customReplace($req->review);
       $item->rating = $req->rating;
       $item->order_id = $req->order_id;
       $result = $item->save();

      if($result){
        return json_encode(['status'=>true ,'message'=>'Review Add successfull']);
       }else{
        return json_encode(['status'=>false ,'message'=>'something wrong']);
       }
    }


    function fetchAllReview(Request $request){


        $totalData =  Review::count();
        $rows = Review::orderBy('id', 'DESC')->with("user")->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'review'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Review::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Review::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Review::Where('review', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Review::where('id', 'LIKE', "%{$search}%")
                ->orWhere('review', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
             
            if($item->feacherd == 1){


                $feacherd = ' <label class="switch ml-3">
                                   <input type="checkbox" name="feacherd" rel="'.$item->id.'" value="1" id="feacherd" class="feacherd" checked>
                                   <span class="slider round" ></span>
                               </label>';
                 
                 }
                 else{
       
                   $feacherd = ' <label class="switch ml-3">
                                
                                   <input type="checkbox" name="feacherd"  rel="'.$item->id.'" value="1" id="feacherd" class="feacherd">
                                   <span class="slider round" ></span>
                               </label>';
       
                 }
             
                 $action = '<td>
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger deleteitem "><i class="fas fa-trash-alt"></i></a></td>';
          
    
            $data[] = array(

                '<p>'.$item->order_id.'</p>',
                '<p>'.$item->user->firstname.'</p>',
                '<p>'.$item->review.'</p>',
                '<p> <i class="fas fa-star" style="color: #FFCD0F !important;"></i> '.$item->rating.'</p>',
                $feacherd,
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

       function updateReview(Request $req){

        $id = $req->id;
     
        return Review::where('id', $id)->update(['feacherd' => $req->feacherd]);
       }
       
    function deleteReview($id){
        

        
        $data =  Review::where('id',$id);
        $data->delete();
        
        $data1['status'] = true;
        $data1['message'] = "delete successfull";
    
        echo json_encode($data1);
    
        }

        function getAllOrderRating(Request $req){
        
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
    
        
 
            $data = Review::skip($req->start)->take($req->count)->orderBy('id', 'DESC')->with("user")->get();
    
            return json_encode(['status'=>true ,'message'=>'Fetch All Data successfull','data'=>$data]);
    
          }

          function getAllWebRating(){

            $data = Review::orderBy('id', 'DESC')->with("user")->get();
    
            return json_encode(['status'=>true ,'message'=>'Fetch All Data successfull','data'=>$data]);

          }

          
}
