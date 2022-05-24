@extends('include.app')



@section('content')

<script src="{{asset('asset/script/index.js')}}"></script>
<link rel="stylesheet" href="{{asset('asset/style/index.css')}}">
<?php
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;
    $settingData = DB::table('shippingcharge')->where('id',1)->first();
    $currencies = $settingData->currencies;
    
    $todayCount = DB::table('orderdetails')
    ->whereDate('created_at', Carbon::today())
    ->count();
    $todayAmount = DB::table('orderdetails')
    ->whereDate('created_at', Carbon::today())
    ->sum('total_amount');
    $monthCount = DB::table('orderdetails')
    ->whereMonth('created_at', date('m'))
    ->count();
    $monthAmount = DB::table('orderdetails')
    ->whereMonth('created_at', date('m'))
    ->sum('total_amount');
    $YearCount = DB::table('orderdetails')
    ->whereYear('created_at', date('Y'))
    ->count();
    $YearAmount = DB::table('orderdetails')
    ->whereYear('created_at', date('Y'))
    ->sum('total_amount');
    $AllCount = DB::table('orderdetails')->count();
    $AllAmount = DB::table('orderdetails')->sum('total_amount');

    $proCount = DB::table('orderdetails')
    ->where('status', 1)
    ->count();
    $confirmCount = DB::table('orderdetails')
    ->where('status', 2)
    ->count();
    $holdCount = DB::table('orderdetails')
    ->where('status', 3)
    ->count();
    $cancelCount = DB::table('orderdetails')
    ->where('status', 5)
    ->count();

    $proAmount = DB::table('orderdetails')
    ->where('status', 1)
    ->sum('total_amount');
    $confirmAmount = DB::table('orderdetails')
    ->where('status', 2)
    ->sum('total_amount');
    $holdAmount = DB::table('orderdetails')
    ->where('status', 3)
    ->sum('total_amount');
    $cancelAmount = DB::table('orderdetails')
    ->where('status', 5)
    ->sum('total_amount');

    $category = DB::table('category')->count();
    $product = DB::table('product')->count();
    $ofsproduct = DB::table('product')
    ->where('stock', 0)
    ->count();

    $dbboycount = DB::table('deliveryboy')->count();
    $dbpayment = DB::table('deliveryboy')->sum('payment');
    $opcomplaint = DB::table('complaint')
    ->where('status', 0)
    ->count();
    ?>




<section class="section">
    <div class="row">
        <div class="col-md-12">
            <h4> {{__('app.Orders')}}</h4>
        </div>
    </div>
    <div class="row ">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card ">
                <div class="card-statistic-4 ">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 pr-0 ">
                                <div class="card-content">
                                     <div class="card-icon2 mainbg">
                                    <i class="fas fa-calendar-alt maincolor"></i>
                                </div>
                                    <h5 class="font-15">{{__('app.Today')}}</h5>
                                    <h2 class="mb-3 font-18">{{ $todayCount }}</h2>
                                    <p class="mb-0"><span class="col-green">{{  $currencies}} {{ $todayAmount }}</span></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">
                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-calendar-alt maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15"> {{__('app.This_Month')}}</h5>
                                    <h2 class="mb-3 font-18 ">{{ $monthCount }}</h2>
                                    <p class="mb-0"><span class="col-orange">{{  $currencies}} {{ $monthAmount }}</span> </p>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">

                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-calendar-alt maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15">{{__('app.This_Year')}}</h5>
                                    <h2 class="mb-3 font-18">{{ $YearCount }}</h2>
                                    <p class="mb-0"><span class="col-green">{{  $currencies}} {{ $YearAmount }}</span> </p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">

                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-calendar-alt maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15">{{__('app.All_Time')}}</h5>
                                    <h2 class="mb-3 font-18">{{ $AllCount }}</h2>
                                    <p class="mb-0"><span class="col-green">{{  $currencies}}{{ $AllAmount }}</span> </p>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4> {{__('app.Orders')}}</h4>
        </div>
    </div>


    <div class="row ">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">
                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-chart-line maincolor" ></i>
                                </div>
                                <div class="card-content">
                                   
                                    <h6 class="font-15">{{__('app.Processing')}}</h6>
                                    <h2 class="mb-3 font-18">{{ $proCount }}</h2>
                                    <p class="mb-0"><span class="col-green">{{  $currencies}} {{ $proAmount }}</span> </p>
                                </div>
                            </div>
                   
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">
                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-check maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15"> {{__('app.Confirmed')}}</h5>
                                    <h2 class="mb-3 font-18"> {{ $confirmCount }}</h2>
                                    <p class="mb-0"><span class="col-orange">{{  $currencies}} {{ $confirmAmount }}</span> </p>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">
                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-pause maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15">{{__('app.On_Holds')}}</h5>
                                    <h2 class="mb-3 font-18"> {{ $holdCount }}</h2>
                                    <p class="mb-0"><span class="col-dark">{{  $currencies}} {{ $holdAmount }}</span>
                                    </p>
                                </div>
                            </div>
                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">
                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-times maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15">{{__('app.Cancelled')}}</h5>
                                    <h2 class="mb-3 font-18"> {{ $cancelCount }}</h2>
                                    <p class="mb-0"><span class="col-green">{{  $currencies}} {{ $cancelAmount }}</span> </p>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4> {{__('app.Products')}}</h4>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">
                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-boxes maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15">{{__('app.Categories')}}</h5>
                                    <h2 class="mb-3 font-18"> {{ $category }}</h2>
            
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">
                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-box maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15">{{__('app.Products')}}</h5>
                                    <h2 class="mb-3 font-18"> {{ $product }}</h2>
            
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">
                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-box-open maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15">{{__('app.Out_of_Stock_Products')}}</h5>
                                    <h2 class="mb-3 font-18"> {{ $ofsproduct }}</h2>
            
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
       
        
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4>{{__('app.Miscellaneous')}}</h4>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">
                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-box maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15">{{__('app.Delivery_Boy')}}</h5>
                                    <h2 class="mb-3 font-18"> {{ $dbboycount }}</h2>
            
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">
                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-box maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15">{{__('app.Total_Delivery_Boy_Payment')}}</h5>
                                    <h2 class="mb-3 font-18"> {{  $currencies}} {{ $dbpayment }}</h2>
            
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 ">
                                <div class="card-icon2 mainbg">
                                    <i class="fas fa-box maincolor"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="font-15">{{__('app.Open_Complaints')}}</h5>
                                    <h2 class="mb-3 font-18"> {{ $opcomplaint }}</h2>
            
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>




@endsection