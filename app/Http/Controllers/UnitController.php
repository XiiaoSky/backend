<?php

namespace App\Http\Controllers;

use App\Models\Myfunction;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    function addUnit(Request $req){


        $result =  Unit::Where('title',$req->title)->first();

        if($result == null){

            $unit = new Unit();
      
            $unit->title = Myfunction::customReplace($req->title);
        
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


    function fetchAllUnits(Request $request){

        $totalData =  Unit::count();
        $rows = Unit::orderBy('id', 'DESC')->get();


        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'title'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Unit::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Unit::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Unit::Where('title', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered =Unit::where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $cat) {
     


            $data[] = array(
             
             '<p>'.$cat->title.'</p>',
             '<a href="" data-toggle="modal" id="'.$cat->id.'" data-id="'.$cat->title.'" data-target="#edit_unit_modal" class="btn btn-primary  edit_units"><i class="fas fa-edit"></i></a>',
             
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

    function updateUnit(Request $req){

        $result =   Unit::where('title',$req->title)->whereNotIn('id',[$req->id])->first();

        if($result == null){


         Unit::where('id', $req->id)->update(['title' => Myfunction::customReplace($req->title)]);
        

        $data['status'] = true;
        $data['message'] = "update successfull";

        echo json_encode($data);

      } else{

        $data['status'] = false;
        $data['message'] = "Unit Allready exist";

       echo json_encode($data);

     }

    }

    function deleteUnit($id){
        
        $data =  Unit::where('id',$id);
        $data->delete();
        
        $data1['status'] = true;
        $data1['message'] = "delete successfull";

        echo json_encode($data1);
    }

    function getUnit(){
        $rows = Unit::orderBy('id','DESC')->get();
    
        
        $data['units'] = $rows;
        $data['status'] = true;
        $data['message'] = "all data fetch successfull";
        echo json_encode($data);
    }

}
