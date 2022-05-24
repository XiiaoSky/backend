<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Myfunction;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    function addCoupon(Request $req){
        $result =  Coupon::Where('coupon_code',$req->coupon_code)->first();

        if($result == null){

            $unit = new Coupon();
      
            $unit->coupon_code = Myfunction::customReplace($req->coupon_code);
            $unit->description = Myfunction::customReplace($req->description);
            $unit->type = $req->type;
            $unit->discount = Myfunction::customReplace($req->discount);
            $unit->minamount = Myfunction::customReplace($req->minamount);
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


    function fetchAllCoupon(Request $request){


        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;
        $totalData =  Coupon::count();
        $rows = Coupon::orderBy('id', 'DESC')->get();


        $result = $rows;

        $columns = array(
            0 => 'id',
            1 => 'coupon_code'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Coupon::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $result = Coupon::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $result =  Coupon::Where('coupon_code', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered =Coupon::where('id', 'LIKE', "%{$search}%")
                ->orWhere('coupon_code', 'LIKE', "%{$search}%")
                ->count();

        }
        $data = array();
        foreach ($result as $cat) {

               if($cat->type == 1){


               $type = "<p  class='badge bg-yellow' >".__('app.FlatDiscount')."</p>";
                 
                 }
                 else{
       
                    $type = "<p class='badge badge-success'>".__('app.UptoDiscount')."</p>";
       
                 }


            $action = '<td>
            <a href=""  rel = "'.$cat->id.'"  data-toggle="modal" data-target="#edit_unit_modal"  class="btn btn-primary  editcoupan"><i class="fas fa-edit"></i></a>
            <a href="" rel = "'.$cat->id.'" class="btn btn-danger deleteCoupon "><i class="fas fa-trash-alt"></i></a></td>';

     


            $data[] = array(
             
             '<p>'.$cat->coupon_code.'</p>',
             $type,
             '<p>'.$cat->discount.' %</p>',
             '<p>'.$currencies.' '.$cat->minamount.' </p>',
             $cat->description,
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

    function getCoupanbyid($id){

        $rows = Coupon::where('id',$id)->first();
        $data['coupons'] = $rows;
        $data['status'] = true;
        $data['message'] = "all data fetch successfull";
        echo json_encode($data);
    }

    function updateCoupon(Request $req){

        $result =   Coupon::where('coupon_code',$req->coupon_code)->whereNotIn('id',[$req->id])->first();

        if($result == null){


         Coupon::where('id', $req->id)->update(['coupon_code' => Myfunction::customReplace($req->coupon_code),
                                                'description' => Myfunction::customReplace($req->description),
                                                'minamount' => Myfunction::customReplace($req->minamount),
                                                'type' => $req->type,
                                                'discount' => Myfunction::customReplace($req->discount)
                                               ]);
        

        $data['status'] = true;
        $data['message'] = "update successfull";

        echo json_encode($data);

      } else{

        $data['status'] = false;
        $data['message'] = "Coupon Allready exist";

       echo json_encode($data);

     }

    }

    function deleteCoupan($id){
        
        $data =  Coupon::where('id',$id);
        $data->delete();
        
        $data1['status'] = true;
        $data1['message'] = "delete successfull";

        echo json_encode($data1);
    }

}
