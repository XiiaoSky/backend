<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Myfunction;

class AreaController extends Controller
{
    function addArea(Request $req){


        $result =  Area::Where('name',$req->name)->first();

        if($result == null){

            $unit = new Area();
      
            $unit->name = Myfunction::customReplace($req->name);
            $unit->city_id = $req->city_id;
        
            $unit->save();
            $data['status'] = true;
            $data['message'] = "add successfull";
   
            echo json_encode($data);
           

        } else{

            $data['status'] = false;
            $data['message'] = "unit Allready exist";
 
          echo json_encode($data);

        }

    
    }


    function fetchAllArea(Request $request){

        $totalData =  Area::count();
        $rows = Area::orderBy('id', 'DESC')->with('city')->get();


        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'name'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Area::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
        $result = Area::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)->with('city')
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Area::Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)->with('city')
                ->get();
            $totalFiltered =Area::where('id', 'LIKE', "%{$search}%")->with('city')
                ->orWhere('name', 'LIKE', "%{$search}%")->with('city')
                ->count();
        }
        $data = array();
        foreach ($result as $cat) {
     


            $data[] = array(
             
             '<p>'.$cat->name.'</p>',
             '<p>'.$cat->city->name.'</p>',
             '<a href="" data-toggle="modal" id="'.$cat->id.'" data-pos="'.$cat->city_id.'" data-id="'.$cat->name.'" data-target="#editAreaModel" class="btn btn-primary  editarea"><i class="fas fa-edit"></i></a>',
             '<a href = ""  rel = "'.$cat->id.'" class = "btn btn-danger deletearea text-white" > <i class="fas fa-trash-alt"></i> </a>',
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

    function updateArea(Request $req){

        $result =   Area::where('name',$req->name)->whereNotIn('id',[$req->id])->first();

        if($result == null){


            Area::where('id', $req->id)->update(['name' => Myfunction::customReplace($req->name),
                                                 'city_id' => $req->city_id  ]);
        

        $data['status'] = true;
        $data['message'] = "update successfull";

        echo json_encode($data);

      } else{

        $data['status'] = false;
        $data['message'] = "Area Allready exist";

       echo json_encode($data);

     }

    }

    function deleteArea($id){
        
        $data =  Area::where('id',$id);
        $data->delete();
        
        $data1['status'] = true;
        $data1['message'] = "delete successfull";

        echo json_encode($data1);
    }

    // =================================== api =====================================

    function getAreaList(Request $req){

        $data  = Area::where('city_id',$req->city_id)->orderBy('id', 'DESC')->get();

        return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);

    }

    function getWebAeraList( ){

        $data  = Area::orderBy('id', 'DESC')->get();

        return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);

    }
}
