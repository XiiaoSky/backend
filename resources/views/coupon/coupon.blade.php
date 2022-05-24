@extends('include.app')

@section('content')

<script src="{{asset('asset/script/coupon.js')}}"></script>
<?php
use Illuminate\Support\Facades\DB;
$settingData = Db::table('shippingcharge')->where('id',1)->first();
    
    $currencies = $settingData->currencies;

?>

    <div class="text-right mb-3">
        <a class="btn btn-primary addcouponbtn" href="" data-toggle="modal" data-target="#couponModal" >{{__('app.Add')}} {{__('app.Coupon')}} 
        </a>
    </div>

    <div class="modal fade" id="couponModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">{{__('app.Add')}} {{__('app.Coupon')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="addCoupon" method="post" enctype="multipart" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="coupon_code">{{__('app.Coupon')}} {{__('app.Code')}}</label>
                            <input type="text" id="coupon_code" class="form-control coupon_code" name="coupon_code"
                                placeholder="{{__('app.Coupon')}} {{__('app.Code')}}"  value="" required>
                        </div>
                        <div class="form-group">
                            <label for="description">{{__('app.Coupon')}} {{__('app.Description')}} </label>
                            <input type="text" id="description" class="form-control description" name="description"
                                placeholder="{{__('app.Coupon')}} {{__('app.Description')}}" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="discount_type">{{__('app.DiscountType')}}</label>
                            <select class="form-control form-control-lg discount_type valid" id="discount_type" name="type"
                                aria-invalid="false" required>
                                <option value="" disabled>{{__('app.Select')}}</option>
                                <option value="1">{{__('app.FlatDiscount')}}</option>
                                <option value="2">{{__('app.UptoDiscount')}}</option>
                            </select>
                        </div>
                        <div class="form-group flat">
                            <label for="coupon_discount">{{__('app.DiscountAmount')}}</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input type="number" id="coupon_discount" name="discount" placeholder="{{__('app.DiscountAmount')}}"
                                    class="form-control coupon_discount"  value="" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{__('app.%')}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group upto">
                            <label for="min_amount">{{__('app.MinimumOrderAmount')}}</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{$currencies}}</div>
                                </div>
                                <input type="number" id="min_amount" name="minamount" placeholder="{{__('app.MinimumOrderAmount')}}"
                                    class="form-control min_amount" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="coupon_id" id="coupon_id" value="">
                        <button type="submit" class="btn btn-success">{{__('app.Save')}}</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{__('app.Close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h4>{{__('app.Coupons')}} </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="coupontable">
                    <thead>
                        <tr>
                            <th>{{__('app.Coupon')}} {{__('app.Code')}}</th>
                            <th>{{__('app.DiscountType')}}</th>
                            <th>{{__('app.Discount')}}</th>
                            <th>{{__('app.MinimumOrderAmount')}}</th>
                            <th>{{__('app.Description')}}</th>
                            <th>{{__('app.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_unit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">{{__('app.Edit')}} {{__('app.Coupon')}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="editCoupon" method="post" enctype="multipart" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="coupon_code">{{__('app.Coupon')}} {{__('app.Code')}}</label>
                            <input type="text" id="editcoupon_code" class="form-control coupon_code" name="coupon_code"
                                placeholder="{{__('app.Coupon')}} {{__('app.Code')}}"  value="" required>
                        </div>
                        <div class="form-group">
                            <label for="description">{{__('app.Coupon')}} {{__('app.Description')}}</label>
                            <input type="text" id="editdescription" class="form-control description" name="description"
                                placeholder="{{__('app.Coupon')}} {{__('app.Description')}}" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="discount_type">{{__('app.DiscountType')}}</label>
                            <select class="form-control form-control-lg discount_type valid" id="editdiscount_type" name="type"
                                aria-invalid="false" required>
                               
                                
                            </select>
                        </div>
                        <div class="form-group flat">
                            <label for="coupon_discount">{{__('app.DiscountAmount')}}</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input type="number" id="editcoupon_discount" name="discount" placeholder="{{__('app.DiscountAmount')}}"
                                    class="form-control "  value="" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{__('app.%')}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group upto">
                            <label for="min_amount">{{__('app.MinimumOrderAmount')}}</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{$currencies}}</div>
                                </div>
                                <input type="number" id="editmin_amount" name="minamount" placeholder="{{__('app.MinimumOrderAmount')}}"
                                    class="form-control editmin_amount" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="editcoupon_id" value="">
                        <button type="submit" class="btn btn-success">{{__('app.Save')}}</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{__('app.Close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection
