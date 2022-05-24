<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Images;
use App\Models\Myfunction;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CategoryCotroller extends Controller
{


    

    
    function fetchAllCategory(Request $request){
   



        $totalData =  Category::count();
        $rows = Category::orderBy('id', 'DESC')->get();


        $categories = $rows;

        $columns = array(
            0 => 'id',
            1 => 'title'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Category::count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $categories = Category::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $categories =  Category::Where('title', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered =Category::where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($categories as $cat) {
     

        $id =$cat->id;
        $view = '<a href = "'.route('viewProductByCat',$cat->id).'" class="btn btn-success"  > '.__('app.View').' '.__('app.Products').' </a>';

            $news_count = 5;

            $data[] = array(
             
                '<img src="public/storage/'.$cat->image.'" width="100" height="100">',
             '<p>'.$cat->title.'</p>',
             $view,
             '<a href="" data-toggle="modal" id="'.$cat->id.'" rel="'.$cat->image.'"  data-id="'.$cat->title.'" data-target="#edit_cat_modal" class="btn btn-primary  edit_cats"><i class="fas fa-edit"></i></a>',
             '<a href = ""  rel = "'.$cat->id.'" class = "btn btn-danger delete-cat text-white" > <i class="fas fa-trash-alt"></i> </a>',
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

    
    function getcategory(){
        
          $rows = Category::orderBy('id','DESC')->get();
    
        
          $data['cats'] = $rows;
          $data['status'] = true;
          $data['message'] = "all data fetch successfull";
          echo json_encode($data);
       
    }


    function deleteCat($id){

           $data =  Category::where('id',$id);
           $data->delete();
           
           $data1['status'] = true;
           $data1['message'] = "delete successfull";
  
           echo json_encode($data1);

    }

    function addCat(Request $req){

        $result =  Category::Where('title',$req->title)->first();

        if($result == null){

            $cat = new Category();
          
            $cat->title =   Myfunction::customReplace($req->title);
           
            $path = $req->file('image')->store('uploads');
            $cat->image = $path;
            $cat->save();
            $data['status'] = true;
            $data['message'] = "add successfull";
   
            echo json_encode($data);
           

        } else{

            $data['status'] = false;
            $data['message'] = "Category Allready exist";
 
          echo json_encode($data);

        }

    }

    function updateCat(Request $req){

       
        $result =   Category::where('title',$req->title)->whereNotIn('id',[$req->id])->first();

        if($result == null){


        if($req->image == ""){
            Category::where('id', $req->id)->update(['title' => Myfunction::customReplace($req->title)]);
        }else{
            $path = $req->file('image')->store('uploads');
            Category::where('id', $req->id)->update(['title' => Myfunction::customReplace($req->title),'image' => $path ]);
          
        }

        $data['status'] = true;
        $data['message'] = "update successfull";

        echo json_encode($data);

    } else{

        $data['status'] = false;
        $data['message'] = "Category Allready exist";

      echo json_encode($data);

    }

    }
 

    function getAllCategory(){

        $row1 = Category::orderBy('id','DESC')->get();
        return json_encode(['status'=>true,'message'=>'all data fetch successfull','data'=>$row1]);


    }

    function viewProductByCat($id){


        return view('category.viewproduct',['id'=>$id]);


    }


    function fetchAllCatProduct(Request $request){

        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;

        $totalData =  Product::where('category_id',$request->id)->count();
        $rows = Product::where('category_id',$request->id)->orderBy('id', 'DESC')->with("category")->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'title'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Product::where('category_id',$request->id)->count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Product::where('category_id',$request->id)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Product::where('category_id',$request->id)->Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Product::where('category_id',$request->id)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
              $id =$item->id;
              $image = Images::where('product_id',$item->id)->first();
    
              $price = Price::where('product_id',$item->id)->with('units')->get();
    
              $arr = []; 
              foreach($price as $price){
               $arr[] =  ''.$price->unit.' '.$price->units->title.' - '.$currencies.''.$price->sale_price.' <br>';
              }
    
             $pricefinal = implode(" ",$arr);
    
             
             if($item->stock == 1){
    
    
                $stock = ' <label class="switch ml-3">
                                   <input type="checkbox" name="stock" rel="'.$item->id.'" value="1" id="stock" class="stock" checked>
                                   <span class="slider round" ></span>
                               </label>';
                 
                 }
                 else{
       
                   $stock = ' <label class="switch ml-3">
                                
                                   <input type="checkbox" name="stock"  rel="'.$item->id.'" value="1" id="stock" class="stock">
                                   <span class="slider round" ></span>
                               </label>';
       
                 }
                 $action = '<td><a href="'.route('viewProduct',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
                 <a href="'.route('editProduct',$item->id).'" class="btn btn-primary  "><i class="fas fa-edit"></i></a>
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger  deleteproduct"><i class="fas fa-trash-alt"></i></a></td>';
          
    
            $data[] = array(
    
                
                '<img src="'.env('image').'public/storage/'.$image->image.'" width="70" height="70">',
                '<p>'.$item->name.'</p>',
                '<td>'.$pricefinal.'</td>',
                 $stock,
                '<p>'.$item->category->title.'</p>',
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
    
    
       function fetchAllOfsCatProduct(Request $request){
    
        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;
        
        $totalData =  Product::where('category_id',$request->id)->count();
        $rows = Product::where('category_id',$request->id)->where('stock',0)->orderBy('id', 'DESC')->with("category")->get();
    
    
        $items = $rows;
        
       
    
        $columns = array(
            0 => 'id',
            1 => 'title'
        );
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $totalData = Product::where('category_id',$request->id)->where('stock',0)->count();
        $totalFiltered = $totalData;
        if (empty($request->input('search.value'))) {
            $items = Product::where('category_id',$request->id)->where('stock',0)->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $items =  Product::where('category_id',$request->id)->where('stock',0)->Where('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)->with("category")
                ->get();
            $totalFiltered = Product::where('category_id',$request->id)->where('stock',0)->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")->with("category")
                ->count();
        }
        $data = array();
        foreach ($items as $item) {
     
    
              $id =$item->id;
              $image = Images::where('product_id',$item->id)->first();
    
              $price = Price::where('product_id',$item->id)->with('units')->get();
    
              $arr = []; 
              foreach($price as $price){
                  
               $arr[] =  ''.$price->unit.' '.$price->units->title.' -'.$currencies.''.$price->sale_price.' <br>';
              }
    
             $pricefinal = implode(" ",$arr);
    
             
             if($item->stock == 1){
    
    
                $stock = ' <label class="switch ml-3">
                                   <input type="checkbox" name="stock" rel="'.$item->id.'" value="1" id="stock" class="stock" checked>
                                   <span class="slider round" ></span>
                               </label>';
                 
                 }
                 else{
       
                   $stock = ' <label class="switch ml-3">
                                
                                   <input type="checkbox" name="stock"  rel="'.$item->id.'" value="1" id="stock" class="stock">
                                   <span class="slider round" ></span>
                               </label>';
       
                 }
                 
                 $action = '<td><a href="'.route('viewProduct',$item->id).'" class="btn btn-info  "><i class="fas fa-eye"></i></a>
                 <a href="'.route('editProduct',$item->id).'" class="btn btn-primary  "><i class="fas fa-edit"></i></a>
                 <a href="" rel = "'.$item->id.'" class="btn btn-danger deleteproduct "><i class="fas fa-trash-alt"></i></a></td>';
    
    
            $data[] = array(
    
    
             '<img src="'.env('image').'public/storage/'.$image->image.'" width="70" height="70">',
             '<p>'.$item->name.'</p>',
             '<td>'.$pricefinal.'</td>',
              $stock,
             '<p>'.$item->category->title.'</p>',
             $action
             ,
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

    
}
