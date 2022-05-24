<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Gng</title>

    <script src="{{asset('asset/cdnjs/jquery.min.js')}}"></script>

    @yield('pageSpecificCSS')

    <link rel="stylesheet" href="{{ asset('asset/css/app.min.css') }}">

    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/custom.css') }}">

    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('asset/img/favicon.ico') }}'
        style="width: 2px !important;" />

    <link rel="stylesheet" href="{{ asset('asset/bundles/codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href=" {{ asset('asset/bundles/codemirror/theme/duotone-dark.css') }} ">
    <link rel="stylesheet" href=" {{ asset('asset/bundles/jquery-selectric/selectric.css') }}">

    <script src="{{asset('asset/cdnjs/iziToast.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('asset/cdncss/iziToast.css')}}" />

    <script src="{{asset('asset/cdnjs/sweetalert.min.js')}}"></script>
    <script src="{{asset('asset/script/language.js')}}"></script>
    <link rel="stylesheet" href="{{asset('asset/style/app.css')}}">

</head>

<body>

    <?php 
        
        use Illuminate\Support\Facades\DB;

        $settingData = DB::table('shippingcharge')->where('id',1)->first();
    
        $currencies = $settingData->currencies;
         $app_name = $settingData->app_name;
        ?>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky bgcolor">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link text-white nav-link-lg
         collapse-btn"> <i data-feather="align-justify"></i></a></li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right ml-auto">


                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <span
                                class="d-sm-none d-lg-inline-block text-white useradmin"><i
                                    class="fas fa-id-badge "></i></span></a>

                        <div class="dropdown-menu dropdown-menu-right pullDown ">
                            <div class="dropdown-title">{{__('app.Hello_admin')}}</div>

                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"> <i
                                    class="fas fa-sign-out-alt logicon"></i>
                                {{__('app.Logout')}}
                            </a>
                        </div>




        </div>
        </li>
        </ul>
        </nav>
        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="{{ route('index') }}"> <img alt="image"
                            src=" https://freepngimg.com/thumb/vegetable/24646-6-vegetable-photos.png"
                            class="header-logo" /> <span
                            class="logo-name font-gilorybold text-white">{{$app_name}}</span>
                    </a>
                </div>

                <ul class="sidebar-menu">
                    <li class="menu-header text-dark">{{__('app.Main')}}</li>
                    <li class="sideBarli dashboardSideA ">
                        <a href="{{ route('index') }}" class="nav-link text-white "><i
                                class="fas fa-tachometer-alt pt-1"></i><span>{{__('app.Dashboard')}}</span></a>
                    </li>

                    <li class="sideBarli  usersSideA">
                        <a href="{{ route('users') }}" class="nav-link"><i
                                class="fas fa-users"></i></i><span>{{__('app.Users')}}</span></a>
                    </li>

                    <li class="menu-header text-dark">{{__('app.Products')}}</li>



                    <li class="sideBarli categoriesSideA">
                        <a href="{{ route('categories') }}" class="nav-link "><i
                                class="fab fa-cuttlefish"></i><span>{{__('app.Categories')}}</span></a>
                    </li>

                    <li class="sideBarli unitsSideA">
                        <a href="{{ route('units') }}" class="nav-link "><i
                                class="fab fa-uniregistry"></i><span>{{__('app.Units')}}</span></a>
                    </li>


                    <li class="sideBarli productSideA">
                        <a href="{{ route('product') }}" class="nav-link "><i
                                class="fas fa-shopping-cart"></i><span>{{__('app.Products')}}</span></a>
                    </li>





                    <li class="sideBarli couponsSideA">
                        <a href="{{ route('coupons') }}"><i
                                class="fas fa-gift"></i><span>{{__('app.Coupons')}}</span></a>
                    </li>
                    <li class="menu-header text-dark">{{__('app.Orders')}}</li>

                    <li class="sideBarli ordersSideA">
                        <a href="{{ route('orders') }}"><i class="fab fa-jedi-order"></i><span>{{__('app.Orders')}}
                            </span></a>
                    </li>
                    <li class="sideBarli deliveryBoySideA">
                        <a href="{{ route('deliveryBoy') }}"><i
                                class="fas fa-child"></i><span>{{__('app.Delivery_Boy')}}
                            </span></a>
                    </li>
                    <li class="sideBarli complaintsSideA">
                        <a href="{{ route('complaints') }}"><i
                                class="fas fa-comment-alt"></i><span>{{__('app.Complaints')}}
                            </span></a>
                    </li>

                    <li class="sideBarli reviewsSideA">
                        <a href="{{ route('reviews') }}"><i
                                class="fas fa-star"></i><span>{{__('app.Reviews_And_Ratings')}}
                            </span></a>
                    </li>
                    <li class="menu-header text-dark">{{__('app.Setting')}}</li>

                    <li class="sideBarli bannersSideA">
                        <a href="{{ route('banners') }}" class="nav-link "><i
                                class="fas fa-image"></i><span>{{__('app.Banners')}}</span></a>
                    </li>

                    <li class="sideBarli faqsSideA">
                        <a href="{{ route('faqs') }}" class="nav-link "><i
                                class="fas fa-question-circle"></i><span>{{__('app.FAQs')}}</span></a>
                    </li>

                    <li class="sideBarli addressSideA">
                        <a href="{{ route('address') }}" class="nav-link "><i
                                class="fas fa-map"></i><span>{{__('app.Addresses')}}</span></a>
                    </li>

                    <li class="sideBarli notificationSideA">
                        <a href="{{ route('notification') }}" class="nav-link "><i
                                class="fas fa-bell"></i><span>{{__('app.Notifications')}}</span></a>
                    </li>

                    <li class="sideBarli otherSideA">
                        <a href="{{ route('setting') }}" class="nav-link "><i
                                class="fas fa-cog"></i><span>{{__('app.Other_Settings')}}</span></a>
                    </li>

                </ul>
            </aside>
        </div>

        <div class="main-content">

            @yield('content')
            <form action="">
                <input type="hidden" id="user_type" value="{{ session('user_type') }}">
            </form>

        </div>

    </div>
    </div>
    <footer class="main-footer">
        <div class="footer-left">
            <a href="templateshub.net">{{__('app.All_rights_reserved')}}</a>
        </div>
        <div class="footer-right">
        </div>
    </footer>


    <script src="{{ asset('asset/js/app.min.js ') }}"></script>


    <script src="{{ asset('asset/bundles/datatables/datatables.min.js ') }}"></script>
    <script src=" {{ asset('asset/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('asset/bundles/jquery-ui/jquery-ui.min.js ') }}"></script>

    <script src=" {{ asset('asset/js/page/datatables.js') }}"></script>

    <script src="{{ asset('asset/js/scripts.js') }}"></script>
    <script src="{{ asset('asset/script/app.js') }}"></script>
   


</body>


</html>