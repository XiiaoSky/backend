@extends('include.app')



@section('content')

<script src="{{asset('asset/script/addproduct.js')}}"></script>
<link rel="stylesheet" href="{{asset('asset/style/addproduct.css')}}">
<?php
use Illuminate\Support\Facades\DB;
$settingData = Db::table('shippingcharge')->where('id',1)->first();
    
    $currencies = $settingData->currencies;

?>

  



    <div class="card">
        <div class="">
            <div class="card-content p-3">
                <div class="card-header">
                    <h5 class="modal-title" id="myLargeModalLabel">{{__('app.Add')}} {{__('app.Product')}}</h5>

                </div>
                <div class="card-body">

                    <form action="" id="addProduct">
                        @csrf


                        <div id="photo_gallery2" class=" row ml-1">



                        </div>
                        <div class="form-group">
                            <label for="productimages"> <img src="{{ asset('asset/image/default.png') }}" alt=""
                                    width="150" height="150" id="addshowimg" class="rounded"></label>




                            <input type="file" class="form-control d-none" id="productimages" name="image"
                                accept="image/x-png,image/gif,image/jpeg" multiple  >
                        </div>

                                              
                                              <div class="info">
                                                  <p>{{__('app.categorySlogan')}}</p>
                                                </div>


                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label>{{__('app.Title')}}</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="{{__('app.Title')}}" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{__('app.Select')}} {{__('app.Category')}}</label>
                                <select class="form-control" id="select_cat" required>

                                    <option disabled selected value="">{{__('app.Select')}} {{__('app.Category')}}</option>

                                </select>
                            </div>

                        </div>

                        <div class="form-row">



                            <div class="form-group col-md-2 mr-0">
                                <label>{{__('app.Unit')}}</label>
                                <input type="number" name="unit" placeholder="{{__('app.Unit')}}" class="form-control unit" step="0.01" required>
                            </div>

                            <div class="form-group col-md-2 ml-0">
                                <label>&nbsp;</label>
                                <select class="form-control select_unit selectstoretag unit_id" required>

                                    <option disabled selected value="">{{__('app.Select')}} </option>

                                </select>
                            </div>


                            <div class="form-group col-md-4 d-none">
                                <label for="product_price">{{__('app.Origanal')}} {{__('app.Price')}}</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{$currencies}}</div>
                                    </div>
                                    <input type="number" name="price" placeholder="{{__('app.Origanal')}} {{__('app.Price')}}" class="form-control price"  step="0.01"
                                        value="0" required>
                                </div>
                            </div>

                            <div class="form-group col-md-7">
                                <label for="product_price">{{__('app.Sale')}} {{__('app.Price')}}</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text currencies ">{{$currencies}}</div>
                                    </div>
                                    <input type="number" name="sale_price" placeholder="{{__('app.Sale')}} {{__('app.Price')}}"
                                        class="form-control sale_price "  step="0.01" value="" required>
                                </div>
                            </div>

                            <div class="form-group col-md-1">
                                <label>{{__('app.Add')}} {{__('app.More')}} </label>
                                <p href="" id="addnewpricelist" class="btn btn-primary mt-1"><i class="fas fa-plus"></i></p>

                            </div>



                        </div>

                        <div id="afteraddlink"></div>

                        <div class="form-group mt-2">
                            <label>{{__('app.Description')}}</label>
                            <textarea class="form-control" id="discription" required></textarea>
                        </div>


                        <div class="">
                            <button class="btn btn-primary mr-1" type="submit">{{__('app.Add')}} {{__('app.Product')}} </button>
                        </div>



                    </form>


                </div>
            </div>
        </div>
    </div>



@endsection
