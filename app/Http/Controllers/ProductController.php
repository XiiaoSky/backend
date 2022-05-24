<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Price;
use App\Models\Images;
use App\Models\Category;
use App\Models\Myfunction;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    function addProductindb(Request $req){

  
 

        $name = Myfunction::customReplace($req->name);
    
        $sale_price = $req->sale_price;
        $category_id = Myfunction::customReplace($req->category_id);
        $description = Myfunction::customReplace($req->description);
        $unit_id =$req->unit_id;
        $units = $req->units;

        $item = new Product();

        $item->category_id = $category_id;
        $item->description = $description;
        $item->name = $name;
    
        $item->save();


         $id = $item->id;


         foreach($req->file('image') as $img){


          $it = new Images();  

       
          $path = $img->store('uploads');

          $it->image = $path ;
          $it->product_id = $id;
         
          $it->save();

      }

      $n =  count($sale_price);

      for ($i=0; $i < $n; $i++) {

          $ite = new Price();  
         
      
          $ite->product_id = $id;
          $ite->sale_price = Myfunction::customReplace($sale_price[$i]);
          $ite->unit =  Myfunction::customReplace($units[$i]);
          $ite->unit_id =  Myfunction::customReplace($unit_id[$i]);
         
          $ite->save();
      
          
       }

       return json_encode(['status'=>true,'message'=>'all data add susseccfull']);

  }


  function fetchAllProduct(Request $request){

    $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;
    $totalData =  Product::count();
    $rows = Product::orderBy('id', 'DESC')->with("category")->get();


    $items = $rows;
    
   

    $columns = array(
        0 => 'id',
        1 => 'title'
    );
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $totalData = Product::count();
    $totalFiltered = $totalData;
    if (empty($request->input('search.value'))) {
        $items = Product::offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    } else {
        $search = $request->input('search.value');
        $items =  Product::Where('name', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        $totalFiltered = Product::where('id', 'LIKE', "%{$search}%")
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
            
           $arr[] =  ''.$price->unit.' '.$price->units->title.' -'.$currencies.' '.$price->sale_price.'<br>';
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

            
            '<img src="public/storage/'.$image->image.'" width="70" height="70">',
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


   function fetchAllOfsProduct(Request $request){

    $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;
    $totalData =  Product::count();
    $rows = Product::where('stock',0)->orderBy('id', 'DESC')->with("category")->get();


    $items = $rows;
    
   

    $columns = array(
        0 => 'id',
        1 => 'title'
    );
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    $totalData = Product::count();
    $totalFiltered = $totalData;
    if (empty($request->input('search.value'))) {
        $items = Product::where('stock',0)->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    } else {
        $search = $request->input('search.value');
        $items =  Product::where('stock',0)->Where('name', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)->with("category")
            ->get();
        $totalFiltered = Product::where('stock',0)->where('id', 'LIKE', "%{$search}%")
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
              
           $arr[] =  ''.$price->unit.' '.$price->units->title.' - '.$currencies.' '.$price->sale_price.'<br>';
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


         '<img src="public/storage/'.$image->image.'" width="70" height="70">',
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


   function updateStock(Request $req ){

    $id = $req->id;
 
    return Product::where('id', $id)->update(['stock' => $req->stock]);
   }


   function viewProductByID($id){

    $product = Product::where('id',$id)->with("category")->first();
    $images = Images::where('product_id',$id)->get();
    $price = Price::where('product_id',$id)->with('units')->get();

    return  view('product.viewproduct',['product'=>$product,'images' => $images,'price'=>$price]);


   }

   function editProduct($id){

    $item = product::where('id',$id)->with("category")->first();
    $images = Images::where('product_id',$id)->get();
    $price = Price::where('product_id',$id)->with('units')->get();
    $unit = Unit::get();


    return  view('product.editProduct',['product'=>$item,'images' => $images,'price'=>$price,'unit'=>$unit]);


   }

   
   function addImages(Request $req){
 
    
    foreach($req->file('image') as $img){


        $it = new Images();  

     
        $path = $img->store('uploads');

        $it->image = $path ;
        $it->product_id = $req->id;
       
        $it->save();

       

    }

        return json_encode(['status'=>true,'message'=>'add successfull']);
    

  }

  function removeImage($id){

    $data =  Images::where('id',$id);
    $data->delete();
    
    $data1['status'] = true;
    $data1['message'] = "delete successfull";

    echo json_encode($data1);

  }

  function removePrice($id){

    $data =  Price::where('id',$id);
    $data->delete();
    
    $data1['status'] = true;
    $data1['message'] = "delete successfull";

    echo json_encode($data1);

  }

  
  function deleteProduct($id){

    $data =  Product::where('id',$id);
    $data->delete();
    
    $data1['status'] = true;
    $data1['message'] = "delete successfull";

    echo json_encode($data1);

  }
  


  function addprice(Request $req){

    
      $sale_price = $req->sale_price;
      $unit_id = $req->unit_id;
      $units = $req->units;
      $product_id = $req->id;



       $n =  count($sale_price);


        for ($i=0; $i < $n; $i++) {

        $ite = new Price();  
    

        $ite->product_id = $product_id;
    
        $ite->sale_price = Myfunction::customReplace($sale_price[$i]);
        $ite->unit =  Myfunction::customReplace($units[$i]);
        $ite->unit_id =  Myfunction::customReplace($unit_id[$i]);
    
        $ite->save();

        
    }

     return json_encode(['status'=>true,'message'=>'all data add susseccfull']);


  }

  function updateProduct(Request $req){


        $name = Myfunction::customReplace($req->name);
        $price = $req->price;
        $sale_price = $req->sale_price;
        $category_id = $req->category_id;
        $description = Myfunction::customReplace($req->description);
        $unit_id = $req->unit_id;
        $units = $req->unit;
        $id = $req->id;
        $price_id = $req->price_id;
   
        
        $item = Product::find($req->id);

        $item->category_id = $category_id;
        $item->description = $description;
        $item->name = $name;
    
        $item->save();

        $n =  count($price);

        for ($i=0; $i < $n; $i++) {
  
          $p_id = $price_id[$i];

         $ite = Price::find($p_id);
        $ite->price = $price[$i];
        $ite->sale_price = $sale_price[$i];
        $ite->unit =  $units[$i];
        $ite->unit_id =  $unit_id[$i];
    
        $ite->save();

  
           
          
            
         }
  
         return json_encode(['status'=>true,'message'=>'all data add susseccfull']);


  }


    // =================================== api =====================================

    function getProductList(Request $req){

        
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


        $data  = Product::skip($req->start)->take($req->count)->orderBy('id', 'DESC')->with('category')->with('Images')->with('Prices')->with('Prices.Units')->get();

        return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);

    }


    function searchProduct(Request $req){
      
        $search = $req->search_keyword;

        if($req->has('category_id')){

       
            if($req->has('sort_by')){

                if($req->sort_by == 1){
                 
                     $result  = Product::where('category_id',$req->category_id)->where('name', 'LIKE', "%{$search}%")->orWhere('category_id',$req->category_id)->where('stock',1)->where('description', 'LIKE', "%{$search}%")->skip($req->start)->take($req->count)->with('category')->with('Images')->with('Prices')->with('Prices.Units')->get()->sortBy(function ($item) {
                   $item2 =  $item->prices;
                   $item3 = [];
                   foreach($item2 as $item4){
                          $item3[] =  intval($item4->sale_price);
                   }
                      return min( $item3);
                    });


                    $data = [];
                    foreach($result as $result2){
                     $data[] =  $result2 ;
                    }
              
    
                    
                }elseif($req->sort_by == 2){
                    $result  = Product::where('category_id',$req->category_id)->where('name', 'LIKE', "%{$search}%")->orWhere('category_id',$req->category_id)->where('stock',1)->where('description', 'LIKE', "%{$search}%")->skip($req->start)->take($req->count)->with('category')->with('Images')->with('Prices')->with('Prices.Units')->get()->sortByDesc(function ($item) {
                        $item2 =  $item->prices;
                        $item3 = [];
                        foreach($item2 as $item4){
                               $item3[] =  intval($item4->sale_price);
                        }
                           return max($item3);
                         });

                         $data = [];
                         foreach($result as $result2){
                          $data[] =  $result2 ;
                         }
                   
                }else{
                    $data  = Product::where('category_id',$req->category_id)->where('name', 'LIKE', "%{$search}%")->orWhere('category_id',$req->category_id)->where('stock',1)->where('description', 'LIKE', "%{$search}%")->skip($req->start)->take($req->count)->orderBy('name', 'ASC')->with('category')->with('Images')->with('Prices')->with('Prices.Units')->get();
                }
    
            }else{
                $data  = Product::where('category_id',$req->category_id)->where('name', 'LIKE', "%{$search}%")->orWhere('category_id',$req->category_id)->where('stock',1)->where('description', 'LIKE', "%{$search}%")->skip($req->start)->take($req->count)->orderBy('id', 'DESC')->with('category')->with('Images')->with('Prices')->with('Prices.Units')->get();
            }
            
             if($data == []){
                 return json_encode(['status'=>false ,'message'=>'No Data Found' ]);
             }else{
             return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);
             }

        }else{

            if($req->has('sort_by')){

                if($req->sort_by == 1){
                       $result  = Product::where('stock',1)->where('name', 'LIKE', "%{$search}%")->orWhere('stock',1)->where('description', 'LIKE', "%{$search}%")->skip($req->start)->take($req->count)->with('category')->with('Images')->with('Prices')->get()->sortBy(function ($item) {
                        $item2 =  $item->prices;
                        foreach($item2 as $item4){
                                $item3[] =  $item4->sale_price;
                        }
                   $item5   =   min($item3);
                        return   $item5;
            });
  

                    $data = [];
                    foreach($result as $result2){
                        $result2->prices;
                     $data[] =  $result2 ;
                    }
              
      
                    
                }elseif($req->sort_by == 2){
                    $result  = Product::where('stock',1)->where('name', 'LIKE', "%{$search}%")->orWhere('stock',1)->where('description', 'LIKE', "%{$search}%")->skip($req->start)->take($req->count)->with('category')->with('Images')->with('Prices')->with('Prices.Units')->get()->sortByDesc(function ($item) {
                        $item2 =  $item->prices;
                        $item3 = [];
                        foreach($item2 as $item4){
                               $item3[] =  intval($item4->sale_price);
                        }
                           return max($item3);
                         });
                         
                         $data = [];
                         foreach($result as $result2){
                          $data[] =  $result2 ;
                         }
                   
                }else{
                    $data  = Product::where('stock',1)->where('name', 'LIKE', "%{$search}%")->orWhere('stock',1)->where('description', 'LIKE', "%{$search}%")->skip($req->start)->take($req->count)->orderBy('name', 'ASC')->with('category')->with('Images')->with('Prices')->with('Prices.Units')->get();

                }
    
            }else{
                $data  = Product::where('stock',1)->where('name', 'LIKE', "%{$search}%")->orWhere('stock',1)->where('description', 'LIKE', "%{$search}%")->skip($req->start)->take($req->count)->orderBy('id', 'DESC')->with('category')->with('Images')->with('Prices')->with('Prices.Units')->get();
            }
    
            $settingData= Setting::first();
            if($data == '[]'){
                return json_encode(['status'=>false ,'message'=>'No Data Found' ]);
            }else{
            return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ,'settingData'=>$settingData ]);
            }
        }
    }


    function searchProductByCategory(Request $req){

        
        $rules = [
           
            'category_id' => 'required',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }
        $search = $req->search_keyword;

        $data  =  Product::where('category_id',$req->category_id)->where('name', 'LIKE', "%{$search}%")->orWhere('category_id',$req->category_id)->where('stock',1)->where('description', 'LIKE', "%{$search}%")->orderBy('name', 'ASC')->with('category')->with('Images')->with('Prices')->with('Prices.Units')->get();
        
 
     $catdata = Category::where('id',$req->category_id)->withCount('product')->first();  

     $settingData= Setting::first();

        if($data == '[]'){
            return json_encode(['status'=>false ,'message'=>'No Data Found','catdata'=>$catdata]);
        }else{
        return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data,'catdata'=>$catdata,'settingData'=>$settingData ]);
        }

    }

    function getCategoryList(){

        $data  = Category::orderBy('id', 'DESC')->withCount('product')->get();

        return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);
    }

    function getProductById(Request $req){

             
        $rules = [
            'product_id' => 'required',

        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }

        

        $data  = Product::where('id',$req->product_id)->with('category')->with('Images')->with('Prices')->with('Prices.Units')->first();

        return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);

    }


    function getProductByCategoryId(Request $req){

        $rules = [
            'category_id' => 'required',
            'start' => 'required',
            'count' => 'required',

        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];
            return response()->json(['status' => false, 'message' => $msg]);
        }


        $data  = Product::where('category_id',$req->category_id)->skip($req->start)->take($req->count)->orderBy('id', 'DESC')->with('category')->with('Images')->with('Prices')->with('Prices.Units')->get();

        if($data == '[]'){
            return json_encode(['status'=>false ,'message'=>'No Data Found' ]);
        }else{
        return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data ]);
        }

    }

    function homePage(){

        $data['settingData'] = Setting::first();
        $data['category'] = Category::orderBy('id','DESC')->get(); 
       $data['banner']    =Banner::orderBy('id','DESC')->get(); 
       $data['reviews']    =Review::where('feacherd',1)->orderBy('id','DESC')->with('user')->get(); 

       $data4['cats']   = Category::get();

       $first = [];
  
       foreach($data4['cats'] as $data2){

           $category_id =  $data2['id'];

           

           $count =  Product::where('stock',1)->where('category_id',$category_id)->count();
        
        if($count != 0){
            $first[] = $data2;
        }
  
       }
     shuffle($first);


         $data['categoryWithProduct']   = [];
            $i =0 ;
     foreach($first as $single){
              

            if($i == 5){
            break;
             
             }

        $data['categoryWithProduct'][] = $single;
        $i++;
       }

       foreach( $data['categoryWithProduct']  as $d){
 
          $category_id = $d->id;

            $d['products'] = Product::where('stock',1)->where('category_id',$category_id)->take(8)->orderBy('id', 'DESC')->with('Images')->with('Prices')->with('Prices.Units')->get();

       }

  

       return json_encode(['status'=>true ,'message'=>'Data Fetch Successfull','data'=> $data]);

    }
}
