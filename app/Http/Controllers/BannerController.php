<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    function fetchAllBanner(Request $request){

        $totalData =  Banner::count();
        $rows = Banner::orderBy('id', 'DESC')->get();


        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'image'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Banner::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Banner::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Banner::Where('image', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered =Banner::where('id', 'LIKE', "%{$search}%")
                ->orWhere('image', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $cat) {
     


            $data[] = array(
             
             '<img src="public/storage/'.$cat->image.'" width="400" height="150">',
             '<a href="" data-toggle="modal" rel="'.$cat->id.'" data-id="'.$cat->image.'" data-target="#edit_unit_modal" class="btn btn-primary  edit_banner"><i class="fas fa-edit"></i></a>',
             '<a href = ""  rel = "'.$cat->id.'" class = "btn btn-danger delete-Banner text-white" > <i class="fas fa-trash-alt"></i> </a>',
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

    function addBanner(Request $req){

        $cat = new Banner();
       
        $path = $req->file('image')->store('uploads');
        $cat->image = $path;
        $cat->save();
        $data['status'] = true;
        $data['message'] = "add successfull";

        echo json_encode($data);
    }

    function updateBanner(Request $req){
      

        if($req->image == ""){
           $d1 =2;
        }else{
            $path = $req->file('image')->store('uploads');
            Banner::where('id', $req->id)->update(['image' => $path]);
            
                $data['status'] = true;
                $data['message'] = "update successfull";

                echo json_encode($data);
          
        }

    
    }

    function deleteBanner($id){
        $data =  Banner::where('id',$id);
        $data->delete();
        
        $data1['status'] = true;
        $data1['message'] = "delete successfull";

        echo json_encode($data1);

    }

    // =================================== api =====================================

    function getBannerList(){

        $data  = Banner::orderBy('id', 'DESC')->get();

        return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);

    }

    

}
