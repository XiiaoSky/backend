@extends('include.app')

@section('content')

<script src="{{asset('asset/script/editproduct.js')}}"></script>
<link rel="stylesheet" href="{{asset('asset/style/editproduct.css')}}">
<?php
use Illuminate\Support\Facades\DB;
$settingData = Db::table('shippingcharge')->where('id',1)->first();
    
    $currencies = $settingData->currencies;

?>


    
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">{{__('app.Add')}} {{__('app.Images')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="addimage">

                        <div id="photo_gallery2" class=" row ml-1">




                        </div>
                        @csrf
                        <input type="hidden" id="itemidforimages" value="{{ $product->id }}">

                        <div class="custom-file mt-2 mb-3 ">


                            <label class="custom-file-label" for="productimages"> {{__('app.Images')}}</label>
                            <input type="file" class="form-control custom-file-input" id="productimages" name="productimages[]"
                                accept="image/*" multiple required>
                        </div>

                        <div class="">
                            <button class="btn btn-primary mr-1" type="submit">{{__('app.Save')}} </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade liknsaddlg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">{{__('app.Add')}} {{__('app.Price')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="addprice">


                        @csrf
                        <input type="hidden" id="itemid6" value="{{ $product->id }}">


                        <div class="form-row">



                            <div class="form-group col-md-2 mr-0">
                                <label>{{__('app.Unit')}}</label>
                                <input type="number" name="unit" placeholder="{{__('app.Unit')}}" class="form-control unit"  step="0.01" required>
                            </div>

                            <div class="form-group col-md-2 ml-0">
                                <label>&nbsp;</label>
                                <select class="form-control select_unit selectstoretag unit_id" required>

                                    <option disabled selected value="">{{__('app.Select')}}</option>
                                    @foreach ($unit as $st)
                                    <option value='{{ $st->id }}'>{{ $st->title }}</option>

                                   @endforeach

                                </select>
                            </div>

                           
                            <div class="form-group col-md-4 d-none">
                                <label for="product_price">{{__('app.Origanal')}} {{__('app.Price')}}</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"></div>
                                    </div>
                                    <input type="number" name="price" placeholder="{{__('app.Origanal')}} {{__('app.Price')}}"
                                        class="form-control price"  step="0.01" value="0" required>
                                </div>
                            </div>

                            <div class="form-group col-md-7">
                                <label for="product_price">{{__('app.Sale')}} {{__('app.Price')}}</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{ $currencies}}</div>
                                    </div>
                                    <input type="number" name="sale_price" placeholder="{{__('app.Sale')}} {{__('app.Price')}}"
                                        class="form-control sale_price "  step="0.01" value="" required>
                                </div>
                            </div>

                            <div class="form-group col-md-1">
                                <label>{{__('app.Add')}}</label>
                                <p href="" id="addnewpricelist" class="btn btn-primary mt-1"><i class="fas fa-plus"></i></p>

                            </div>
                        

                        
                        </div>

                        <div id="afteraddlink"></div>

                    



                        <div class="">
                            <button class="btn btn-primary mr-1" type="submit">{{__('app.Save')}} </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>





    <div class="card">
        <div class="">
            <div class="card-content p-3">
                <div class="card-header">
                    <h5 class="modal-title" id="myLargeModalLabel">{{$product->name}} {{__('app.Product')}}</h5>

                    <div class="ml-auto ">
                        <a href="" data-toggle="modal" data-target=".bd-example-modal-lg" id="addimagebtn"
                            class="btn btn-primary">{{__('app.Add')}} {{__('app.Images')}} </a>


                    </div>

                </div>
                <div class="card-body">

                    <form action="" id="editProduct">
                      @csrf


                     


                        @csrf
                        <input type="hidden" id="itemid2" value="{{ $product->id }}">

                        <div id="" class=" row ml-1">

                            @foreach ($images as $image)



                                <div class="borderwrap2 " data-href="">
                                    <div class="filenameupload2">
                                        <img class="rounded " src="{{ env('image') }}public/storage/{{ $image->image }}"
                                            width="130" height="130">
                                        <div data-pos="" data-imgid="" class="middle"><i
                                                class="material-icons remove_img5 removeimgf"
                                                rel="{{ $image->id }}">cancel</i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>








                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label>{{__('app.Title')}}</label>
                                <input type="text" id="name" value="{{$product->name}}" name="name" class="form-control" placeholder="{{__('app.Title')}}" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{__('app.Select')}} {{__('app.Category')}} </label>
                                <select class="form-control" id="select_cat" required>
                                   

                                </select>
                            </div>

                        </div>

                        <div class="text-right">
                            <a href="" data-toggle="modal" data-target=".liknsaddlg" id="addLinkbtn"
                                class="my-2  btn btn-primary "><i class="fas fa-plus"></i> {{__('app.Price')}}</a>
                        </div> 

                        @foreach ($price as $p)
                        <div class="form-row">



                            <div class="form-group col-md-2 mr-0">
                                <label>{{__('app.Unit')}}</label>
                                <input type="number" value="{{$p->unit}}" name="unit" placeholder="{{__('app.Unit')}}"  step="0.01" class="form-control editUnit" required>
                            </div>

                            <div class="form-group col-md-2 ml-0">
                                <label>&nbsp;</label>
                                <select class="form-control select_unit selectstoretag editunit_id" required>

                                    <?php foreach ($unit as $st) {
                                        if ($p->unit_id == $st->id) {
                                        echo "<option value='$st->id' selected>$st->title</option>";
                                        } else {
                                        echo "<option value='$st->id'>$st->title</option>";
                                        }
                                        } ?>
                                </select>
                            </div>

                           
                            <div class="form-group col-md-4 d-none">
                                <label for="product_price">{{__('app.Origanal')}} {{__('app.Price')}}</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text currencies">{{ $currencies}}</div>
                                    </div>
                                    <input type="number" name="price" placeholder="{{__('app.Origanal')}} {{__('app.Price')}}"
                                        class="form-control editprice" value="0"  step="0.01" required>
                                </div>
                            </div>

                            <div class="form-group col-md-7">
                                <label for="product_price">{{__('app.Sale')}} {{__('app.Price')}}</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">{{ $currencies}}</div>
                                    </div>
                                    <input type="number" name="editsale_price" placeholder="{{__('app.Sale')}} {{__('app.Price')}}"
                                        class="form-control editsale_price " value="{{$p->sale_price}}"  step="0.01" required>
                                </div>
                            </div>

                            <div class="form-group col-md-1">
                                <label>{{__('app.Remove')}}</label>
                                <p href="" id="" rel="{{ $p->id }}" class="
                                    editremoveprice btn btn-danger mt-1"><i class="fas fa-minus"></i></p>

                            </div>
                        

                        
                        </div>

                        @endforeach


                

                        <div class="form-group mt-2">
                            <label>{{__('app.Description')}}</label>
                            <textarea class="form-control" id="description" required>{{$product->description}}</textarea>
                        </div>

                        <div class="">
                            <button class="btn btn-primary mr-1" type="submit">{{__('app.Save')}}</button>
                        </div>

                    

                    </form>


                </div>
            </div>
        </div>
    </div>



@endsection