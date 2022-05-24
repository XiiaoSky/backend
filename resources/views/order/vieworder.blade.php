@extends('include.app')


@section('content')
<script src="{{asset('asset/script/vieworder.js')}}"></script>
<?php
use Illuminate\Support\Facades\DB;
$settingData = Db::table('shippingcharge')->where('id',1)->first();
    
    $currencies = $settingData->currencies;

?>

    <div class="section-body">

        <div class="invoice">
            <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        
        <div class=" ">
            <h2>{{__('app.View')}}{{__('app.Order')}} </h2>
            <div class="">{{__('app.Order')}}  {{$data['order_id']}}</div>
        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <address>


                                    
                               
                                    <?php 
                                    if($data['dbname'] != null)
                                    {
                                        echo "     <strong>".__('app.AssignTo').":</strong><br>";
                                    echo $data['dbname'];
                                    echo "<br>";
                                    echo $data['dbnumber'];
                                    }

                                   ?>
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>{{__('app.ShippedTo')}} :
                                        
                                    </strong><br>
                                    {{$data['orderaddress']['firstname']}} {{$data['orderaddress']['lastname']}} <br>
                                    {{$data['orderaddress']['address']}},<br>  {{$data['orderaddress']['landmark']}}, <br>
                                    {{$data['orderaddress']['area']}} , {{$data['orderaddress']['city']}}.<br>
                                    {{$data['orderaddress']['pincode']}} 
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>{{__('app.PaymentMethod')}}:</strong><br>
                                   <?php
                                       echo $data['payment_name'];
                                       
                                   ?><br>
                                   <strong>{{__('app.PaymentId')}}:</strong><br>
                                   <?php
                                  
                                       echo $data['payment_id'];
                                   ?><br>
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>{{__('app.Order')}} {{__('app.Date')}}:</strong><br>
                                    {{  $data['created_at']->format('d M Y g:i A') }}<br><br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="section-title">{{__('app.Order')}} {{__('app.Summary')}}</div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-md">
                                <tbody>
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th >{{__('app.Image')}}</th>
                                        <th>{{__('app.Product')}}</th>
                                        <th class="text-center">{{__('app.Unit')}}</th>
                                        <th class="text-center">{{__('app.Price')}}</th>
                                        <th class="text-center">{{__('app.Quantity')}}</th>
                                        <th class="text-right">{{__('app.Total')}}</th>
                                    </tr>
                                    
                                    <?php $i = 1; ?>
                                        @foreach ( $data['orderproducts'] as  $result)

                                       
                                       <tr>
                                 
                                        <td>{{$i}}</td>
                                        <td><img src="{{env('image')}}public/storage/{{$result['image']}}" height="50" width="50" alt=""></td>
                                        <td>{{$result['product_name']}}</td>
                                        <td class="text-center">{{$result['price_unit']}} {{$result['price_unit_name']}}</td>
                                        <td class="text-center">{{$currencies}} {{$result['price']}} </td>
                                        <td class="text-center">{{$result['quantity']}}</td>

                                    
                                        <td class="text-right">{{$currencies}} {{ $result['total_price']}} </td>

                                        <?php $i++; ?>
                                          
                                    </tr>
                                            
                                        @endforeach
                                    
                                   
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-8">
                            </div>
                            <div class="col-lg-4 text-right">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">{{__('app.Subtotal')}}</div>
                                    <div class="invoice-detail-value">{{$currencies}} {{$data['subtotal']}} </div>
                                </div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">{{__('app.Shipping')}}</div>
                                    <div class="invoice-detail-value">{{$currencies}} {{$data['shipping_charge']}} </div>
                                </div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">{{__('app.Coupon')}} {{__('app.Discount')}} </div>
                                    <div class="invoice-detail-value">{{$currencies}} {{$data['coupon_discount']}} </div>
                                </div>
                                <hr class="mt-2 mb-2">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">{{__('app.Total')}}</div>
                                    <div class="invoice-detail-value invoice-detail-value-lg">{{$currencies}} {{$data['total_amount']}} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <?php 
            if($data['reason'] != ""){
                echo  '<div class="form-group ">
                        <label for="product_description">'.__('app.On_Holds').' '.__('app.Reason').'</label>
                        <textarea name="" id="" cols="30" rows="10"class="form-control" readonly>'.$data['reason'].'</textarea >

                    </div>';
              
            }
          ?>
            <div class="text-md-right pb-5">
                <div class="float-lg-left mb-lg-0 mb-3">

                    <?php 
                    if($data['status']  == 1 || $data['status'] == 3)
                    {
                    
                    echo "<a href='' data-toggle='modal' data-target='#deliveryBoyModal' class='btn text-white btn-primary  confirmOrder' rel=".$data['id']."><i class='fas fa-truck'></i> ".__('app.StartDelivery')."</a>";
                   
                    }
                    ?>
              
                    <a href="{{route('orders')}}"
                        class="btn btn-danger btn-icon icon-left text-white"><i class="fas fa-arrow-left"></i> {{__('app.Back')}}</a>
                </div>
            </div>

           
        </div>
    </div>

    <div class="modal fade" id="deliveryBoyModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title">{{__('app.Add')}} {{__('app.Delivery_Boy')}} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
   
                <form action="" method="POST" id="deliveryfrom" >
                <div class="modal-body">
                 
                    <input type="hidden" name="id" class="id">
                   <div class="form-group ">
                       <label>&nbsp;</label>
                       <select class="form-control select_delivery" name="deliveryBoy_id" required>
   
                           <option disabled selected value="">{{__('app.Select')}}</option>
   
                       </select>
                   </div>
                </div>
                <div class="modal-footer">
                   <div class="form-group text-right">
                       <input type="submit" class=" btn btn-success" value="{{__('app.Save')}}">
                       <a href="#" class="btn btn-light text-dark" data-dismiss="modal" aria-label="Close">{{__('app.Close')}}</a>
                   </div>
                </div>
               </form>
            </div>
        </div>
    </div>
   

@endsection
