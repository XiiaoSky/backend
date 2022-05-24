@extends('include.app')


@section('content')

<script src="{{asset('asset/script/product.js')}}"></script> 
<?php 

use Illuminate\Support\Facades\DB;

$allproduct = DB::table('product')->count();
$ofsproduct = DB::table('product')->where('stock',0)->count();


?>


    <div class="text-right mb-3">

        <a href="{{ route('addProduct') }}" class="btn btn-primary">{{__('app.Add')}} {{__('app.Product')}} </a>
    </div>


    <div class="card mt-3">

        <div class="card-header">
            <h4>{{__('app.Products')}}  ( {{$allproduct}} )</h4>
        </div>

        <div class="card-body">


            <div class="tab  " role="tabpanel">
                <ul class="nav nav-pills border-b mb-3  ml-0">

                    <li role="presentation" class="nav-item bg-light "><a class="nav-link pointer active" href="#Section1"
                            aria-controls="home" role="tab" data-toggle="tab">{{__('app.All')}} {{__('app.Products')}} <span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>

                    <li role="presentation" class="nav-item bg-light "><a class="nav-link pointer" href="#Section3" role="tab"
                            data-toggle="tab">{{__('app.Out_of_Stock_Products')}}<span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>
                </ul>

                <hr>

                <div class="tab-content tabs" id="home">

                    <div role="tabpanel" class="tab-pane active" id="Section1">

                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="allProductTable" >
                                <thead>
                                    <tr>
                                        <th>{{__('app.Image')}}</th>
                                        <th>{{__('app.Title')}}</th>
                                        <th>{{__('app.Unit')}} {{__('app.Price')}}</th>
                                        <th>{{__('app.In_Stock')}} </th>
                                        <th width='150'>{{__('app.Category')}} </th>
                                        <th >{{__('app.Action')}} </th>
                                    </tr>
                                </thead>
                                <tbody id="">

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div role="tabpanel" class="tab-pane " id="Section3">
                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="outofstocktable" >
                                <thead>
                                    <tr>
                                        <th>{{__('app.Image')}}</th>
                                        <th>{{__('app.Title')}}</th>
                                        <th>{{__('app.Unit')}} {{__('app.Price')}}</th>
                                        <th>{{__('app.In_Stock')}} </th>
                                        <th width='150'>{{__('app.Category')}} </th>
                                        <th >{{__('app.Action')}} </th>
                                    </tr>
                                </thead>
                                <tbody id="">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
