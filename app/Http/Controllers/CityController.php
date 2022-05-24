<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Area;
use App\Models\Myfunction;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    function addCity(Request $req){


        $result =  City::Where('name',$req->name)->first();

        if($result == null){

            $unit = new City();
      
            $unit->name = Myfunction::customReplace($req->name);
        
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


    function fetchAllCity(Request $request){

        $totalData =  City::count();
        $rows = City::orderBy('id', 'DESC')->get();


        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'name'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = City::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = City::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  City::Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered =City::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $cat) {
     


            $data[] = array(
             
             '<p>'.$cat->name.'</p>',
             '<a href="" data-toggle="modal" id="'.$cat->id.'" data-id="'.$cat->name.'" data-target="#editCityModel" class="btn btn-primary  editcity"><i class="fas fa-edit"></i></a>',
             '<a href = ""  rel = "'.$cat->id.'" class = "btn btn-danger deletecity text-white" > <i class="fas fa-trash-alt"></i> </a>',
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

    function updateCity(Request $req){

        $result =   City::where('name',$req->name)->whereNotIn('id',[$req->id])->first();

        if($result == null){


            City::where('id', $req->id)->update(['name' => Myfunction::customReplace($req->name)]);
        

        $data['status'] = true;
        $data['message'] = "update successfull";

        echo json_encode($data);

      } else{

        $data['status'] = false;
        $data['message'] = "city Allready exist";

       echo json_encode($data);

     }

    }

    function deleteCity($id){
        
        $data =  City::where('id',$id);
        $data->delete();
        
        $data1['status'] = true;
        $data1['message'] = "delete successfull";

        echo json_encode($data1);
    }

    function getCity(){
        $rows = City::orderBy('id','DESC')->get();
    
        
        $data['citys'] = $rows;
        $data['status'] = true;
        $data['message'] = "all data fetch successfull";
        echo json_encode($data);
    }

    // =================================== api =====================================

    function getAddressList(){

        $data  = City::orderBy('id', 'DESC')->with('areas')->get();

        return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);

    }
    function getAreaByCity(Request $req){
     
        $rules = [
            'city_id' => 'required',
            
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

        $data  = Area::where('city_id',$req->city_id)->orderBy('id', 'DESC')->get();

        return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);

    }

    function getCityList(){

        $data  = City::orderBy('id', 'DESC')->get();

        return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);

    }

}
