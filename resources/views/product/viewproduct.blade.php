@extends('include.app')


@section('content')
<script src="{{asset('asset/script/viewproduct.js')}}"></script> 
<?php
use Illuminate\Support\Facades\DB;
$settingData = Db::table('shippingcharge')->where('id',1)->first();
    
    $currencies = $settingData->currencies;

?>
<div class="text-right mb-3">

    <a href="{{route('editProduct', $product->id)}}" class="btn btn-primary">{{__('app.Edit')}} {{__('app.Product')}}</a>
</div>
    <div class="card">
        <div class="card-header">
            <h4>{{$product['name']}}</h4>
        </div>
        <div class="card-body">
            <form class="forms-sample" id="addUpdateProduct" onkeydown="return event.key != 'Enter';">
                <input type="hidden" name="_token" value="yTneVxfpavxO8BIIaJKS47TYJv3EBlA5jNLcacVc">
                <div class="row mb-3 ">
                    @foreach ($images as $image )
            
                  
                            
                                <img class="rounded m-1 " src="{{env('image')}}public/storage/{{$image->image}}"
                                        width="130" height="130" >
                      
                    
                    @endforeach
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="product_name">{{__('app.Product')}} {{__('app.Title')}}</label>
                        <input type="text" name="product_name" class="form-control" id="product_name" placeholder="{{__('app.Title')}}"
                            value="{{$product['name']}}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="product_category">{{__('app.Category')}}</label>
                        <input type="text" name="product_name" class="form-control" id="product_name"
                            value="{{$product['category']['title']}}" readonly="">
                    </div>
                </div>
                @foreach ($price as $p)

                
                <div class="form-row pricediv">
                    <div class="form-group col-md-6">
                        <label for="price_unit">{{__('app.Unit')}}</label>
                        <div class="form-group mb-2 mr-sm-2">
                            <input type="text" name="price_unit[0]"  class="form-control price_unit"
                                value="{{$p->unit}} {{$p->units->title}}" readonly>
                        </div>
                    </div>
                    <div class="form-group col-md-2 d-none">
                        <label for="product_price">{{__('app.Origanal')}} {{__('app.Price')}}</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <input type="text" name="product_price[0]" 
                                class="form-control product_price" readonly value="{{$p->price}}">
                            <div class="input-group-prepend">
                                <div class="input-group-text"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="product_price">{{__('app.Sale')}} {{__('app.Price')}}</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <input type="text" name="product_price[0]" placeholder=" {{__('app.Sale')}} {{__('app.Price')}}"
                                class="form-control product_price" readonly value="{{$p->sale_price}}" readonly>
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{$currencies}}</div>
                            </div>
                        </div>
                    </div>

                    <?php 
                         $op = $p->price;
                         $sp = $p->sale_price;
                         $dp= $op - $sp;

                         $finald ="d";
                    ?>
         
                   
                </div>
                    
                @endforeach


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="product_description">{{__('app.Description')}} </label>
                        <textarea name="" id="" cols="30" rows="10"  class="form-control" readonly>{{$product->description}}</textarea >

                    </div>
                </div>
            </form>
        </div>
    </div>





@endsection
