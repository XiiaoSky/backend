@extends('include.app')


@section('content')
<script src="{{asset('asset/script/viewdbdetails.js')}}"></script>
<?php
use Illuminate\Support\Facades\DB;
$settingData = Db::table('shippingcharge')->where('id',1)->first();
    
    $currencies = $settingData->currencies;

?>
    <input type="hidden" id="idFromView" value="{{$data['id']}}">
    <div class="d-flex   ">

        <div class="card w-50 " >

            <div class=" text-center mt-2">
                <img src="{{env('image')}}public/storage/{{ $data['image'] }}" class="rounded-circle" height="170"
                    width="170" alt="">
                <h4 class="text-dark mt-2">{{ $data['username'] }}</h4>
                <h6>{{ $data['fullname'] }}</h6>
                <h6>{{ $data['number'] }}</h6>


            </div>

        </div>

        <div class="card ml-3" >
            <div class="card-header">
                <h4>{{__('app.PaymentDetails')}}</h4>
            </div>
            <div class="card-body" >
                <h6 class="card-title text-dark " >{{__('app.AmountToPay')}}:</h6>
                <p class="card-text">{{$currencies}} {{ $data['payment'] }} </p>
<button class="btn btn-danger" rel="{{ $data['id'] }}" id="paymentResolve">{{__('app.PaymentResolve')}}</button>
            </div>

        </div>
    </div>

   


    <div class="card mt-3">

        <div class="card-header">
            <h4>{{__('app.Orders')}} {{__('app.List')}}</h4>
        </div>

        <div class="card-body">


            <div class="tab  " role="tabpanel">
                <ul class="nav nav-pills border-b mb-3  ml-0">


                    <li role="presentation" class="nav-item bg-light  mr-2 mt-2 "><a class="nav-link active pointer" href="#Section1"
                            role="tab" data-toggle="tab">{{__('app.Completed')}} {{__('app.Orders')}}<span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>

                    <li role="presentation" class="nav-item bg-light mr-2 mt-2 "><a class="nav-link pointer" href="#Section2"
                            role="tab" data-toggle="tab">{{__('app.Confirmed')}} {{__('app.Orders')}} <span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>


                    <li role="presentation" class="nav-item bg-light mr-2 mt-2 "><a class="nav-link pointer" href="#Section3"
                            role="tab" data-toggle="tab">{{__('app.OnHold')}} {{__('app.Orders')}}<span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>




                </ul>

                <hr>

                <div class="tab-content tabs" id="home">

                    <div role="tabpanel" class="tab-pane active" id="Section1">

                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="dbCompleteOrderTable">
                                <thead>
                                    <tr>
                                       
                                       
                                        <th>{{__('app.OrderId')}}</th>
                                        <th>{{__('app.Username')}}</th>
                                        <th>{{__('app.Area')}}</th>
                                        <th>{{__('app.Total')}}</th>
                                        <th >{{__('app.PaymentType')}}</th>
                                        <th>{{__('app.Status')}}</th>
                                        <th>{{__('app.Order')}} {{__('app.Date')}}</th>
                                        <th>{{__('app.CompletedAt')}}</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div role="tabpanel" class="tab-pane " id="Section2">
                        <div class="table-responsive">
                            <table class="table table-striped  w-100"  id="cofirmorderTable">
                                <thead>
                                    <tr>

                                        <th>{{__('app.OrderId')}}</th>
                                        <th>{{__('app.Username')}}</th>
                                        <th>{{__('app.Area')}}</th>
                                        <th>{{__('app.Total')}}</th>
                                        <th >{{__('app.PaymentType')}}</th>
                                        <th>{{__('app.Status')}}</th>
                                        <th>{{__('app.Order')}} {{__('app.Date')}}</th>
                                       


                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>


                   

                    <div role="tabpanel" class="tab-pane " id="Section3">
                        <div class="table-responsive">
                            <table class="table table-striped  w-100" id="holdOrderTable">
                                <thead>
                                    <tr>

                                        <th>{{__('app.OrderId')}}</th>
                                        <th>{{__('app.Username')}}</th>
                                        <th>{{__('app.Area')}}</th>
                                        <th>{{__('app.Total')}}</th>
                                        <th >{{__('app.Reason')}}</th>
                                        <th>{{__('app.Status')}}</th>
                                        <th>{{__('app.Order')}} {{__('app.Date')}}</th>
                                   

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                  

                </div>
            </div>
        </div>
    </div>

@endsection
