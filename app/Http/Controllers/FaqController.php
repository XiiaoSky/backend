<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Myfunction;

class FaqController extends Controller
{


    function addfaq(Request $req){



            $faq = new Faq();
      
            $faq->question = Myfunction::customReplace($req->question);
            $faq->answer = Myfunction::customReplace($req->answer);
        
            $faq->save();
            $data['status'] = true;
            $data['message'] = "add successfull";
   
            echo json_encode($data);
           

       
    
    }


    function fetchAllFaq(Request $request){

        $totalData =  Faq::count();
        $rows = Faq::orderBy('id', 'DESC')->get();


        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'question'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Faq::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Faq::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Faq::Where('question', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered =Faq::where('id', 'LIKE', "%{$search}%")
                ->orWhere('question', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($result as $cat) {
     

            $action = '<td >
            <a href="" class="editfaq btn btn-primary  "    data-toggle="modal" data-target="#edit_cat_modal"  data-id="'.$cat->id.'" ><i class="fas fa-edit"></i></a>
            <a href="" rel = "'.$cat->id.'" class="btn btn-danger deletefaq "><i class="fas fa-trash-alt"></i></a></td>';


            $data[] = array(
             
             '<p>'.$cat->question.'</p>',
             '<p>'.$cat->answer.'</p>',
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


    function getFaqid($id){

        $rows = Faq::where('id',$id)->first();
        $data['faqs'] = $rows;
        $data['status'] = true;
        $data['message'] = "all data fetch successfull";
        echo json_encode($data);
    }

    function updateFaq(Request $req){


    
     Faq::where('id', $req->id)->update(['question' => Myfunction::customReplace($req->question),
                                                'answer' => Myfunction::customReplace($req->answer )]);
        

        $data['status'] = true;
        $data['message'] = "update successfull";

        echo json_encode($data);

    
    }

    function deleteFaq($id){
        
        $data =  Faq::where('id',$id);
        $data->delete();
        
        $data1['status'] = true;
        $data1['message'] = "delete successfull";

        echo json_encode($data1);
    }

  // =================================== api =====================================

  function getFaqList(){

    $data  = Faq::orderBy('id', 'DESC')->get();

    return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);

}

function getWebFaqList(Request $req){
    



    $data  = Faq::where('question','LIKE',"%{$req->search_keyword}%")->orWhere('answer', 'LIKE', "%{$req->search_keyword}%")->orderBy('id', 'DESC')->get();


    if($data == '[]'){
        return json_encode(['status'=>false ,'message'=>'No Data Found']);
    }else{
    return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);
    }
}
    
}
