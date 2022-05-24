@extends('include.app')
@section('nav')


@endsection
@section('content')

<link rel="stylesheet" href="{{ asset('asset/style/address.css') }}">
<script src="{{asset('asset/js/custom.js')}}" ></script>
<script src="{{asset('asset/script/address.js')}}"></script>


{{-- ================================= add city modal modal1 =================== --}}

<div class="modal fade" id="addCityModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true" >
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class=" ">
                    <h5>{{__('app.Add')}} {{__('app.City')}}</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

             
                  
                    <div class="">
                        <form action="" method="post" enctype="multipart/form-data" class="addunit" id="addCityForm" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label>{{__('app.Title')}} </label>
                                <input type="text"  name="name" class="form-control" required>
                            </div>
                       

                            <div class="form-group text-right">
                                <input class="btn btn-success mr-1" type="submit" value="{{__('app.Save')}}">
                                <a href="#" class="btn btn-light text-dark" data-dismiss="modal" aria-label="Close">{{__('app.Close')}}</a>
                            </div>

                        </form>


                    </div>

               

            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="editCityModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true" >
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class=" ">
                    <h5>{{__('app.Edit')}} {{__('app.City')}}</h5>
                </div>
            
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

             
                  
                    <div class="">
                        <form action="" method="post" enctype="multipart/form-data" class="addunit" id="editCityForm" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label>{{__('app.City')}}</label>
                                <input type="text" name="name" class="form-control name" required>
                            </div>

                            <input type="hidden" class="editcityid" name="id">
                       

                            <div class="form-group text-right">
                                <input class="btn btn-success mr-1" type="submit" value="{{__('app.Save')}}">
                                <a href="#" class="btn btn-light text-dark" data-dismiss="modal" aria-label="Close">{{__('app.Close')}}</a>
                            </div>

                        </form>


                    </div>

               

            </div>

        </div>
    </div>
</div>



{{-- ================================= add area modal modal2 =================== --}}


<div class="modal fade" id="addAreaModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true" >
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class=" ">
                    <h5>{{__('app.Add')}} {{__('app.Area')}}</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

             
                  
                    <div class="">
                        <form action="" method="post" enctype="multipart/form-data" class="" id="addAreaForm" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label>{{__('app.Title')}}</label>
                                <input type="text"  name="name" class="form-control" required>
                            </div>

                            
                            <div class="form-group ">
                                <label>{{__('app.Select')}}{{__('app.City')}}</label>
                                <select class="form-control" id="select_city" name="city_id" required>

                                    <option disabled selected value="">{{__('app.Select')}}{{__('app.City')}}</option>

                                </select>
                            </div>
                       

                            <div class="form-group text-right">
                                <input class="btn btn-success mr-1" type="submit"  value="{{__('app.Save')}} ">
                                <a href="#" class="btn btn-light text-dark" data-dismiss="modal" aria-label="Close">{{__('app.Close')}}</a>
                            </div>

                        </form>


                    </div>

               

            </div>

        </div>
    </div>
</div>





<div class="modal fade" id="editAreaModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true" >
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class=" ">
                    <h5>{{__('app.Edit')}} {{__('app.Area')}}  </h5>
                </div>
             
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

             
                  
                    <div class="">
                        <form action="" method="post" enctype="multipart/form-data" class="" id="editAreaForm" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label>{{__('app.Title')}} </label>
                                <input type="text"  name="name" class="form-control" id="edit_name" required>
                            </div>

                            
                            <div class="form-group ">
                                <label>{{__('app.Select')}}{{__('app.City')}}</label>
                                <select class="form-control" id="editselect_city" name="city_id" required>

                                
                                </select>
                            </div>
                       
                            <input type="hidden" class="editareaid" name="id">
                            <div class="form-group text-right">
                                <input class="btn btn-success mr-1" type="submit"  value="{{__('app.Save')}} ">
                                <a href="#" class="btn btn-light text-dark" data-dismiss="modal" aria-label="Close">{{__('app.Close')}} </a>
                            </div>

                        </form>


                    </div>

               

            </div>

        </div>
    </div>
</div>


<div class="card mt-3">

    <div class="card-header">
        <h4>{{__('app.Addresses')}} </h4>
    </div>

    <div class="card-body">


        <div class="tab  " role="tabpanel">
            <ul class="nav nav-pills border-b mb-3  ml-0">

                <li role="presentation" class="nav-item bg-light "><a class="nav-link pointer active" href="#Section1"
                        aria-controls="home" role="tab" data-toggle="tab">{{__('app.All')}} {{__('app.Cities')}}   <span
                            class="badge badge-transparent total_open_complaint"></span></a>
                </li>

                <li role="presentation" class="nav-item bg-light "><a class="nav-link pointer" href="#Section3" role="tab"
                        data-toggle="tab">{{__('app.All')}} {{__('app.Areas')}}  <span
                            class="badge badge-transparent total_open_complaint"></span></a>
                </li>

                <li class="ml-auto text-dark"><a class="btn btn-primary  text-white citymodalbtn" href="" data-toggle="modal" data-target="#addCityModel"  >{{__('app.Add')}}{{__('app.City')}}
                </a></li>

                <li class="ml-2"><a class="btn btn-primary  text-white areamodalbtn" href="" data-toggle="modal" data-target="#addAreaModel" >{{__('app.Add')}}{{__('app.Area')}}
                </a></li>

                

            </ul>

            <hr>

            <div class="tab-content tabs" id="home">

                <div role="tabpanel" class="tab-pane active" id="Section1">

                    <div class="table-responsive">
                        <table class="table table-striped  w-100" id="allCity">
                            <thead>
                                <tr>
                                    <th class="col-md-8">{{__('app.Title')}} </th>
                                    <th class="col-md-2">{{__('app.Edit')}}  </th>
                                    <th class="col-md-2">{{__('app.Delete')}}  </th>
                                </tr>
                            </thead>
                            <tbody id="">

                            </tbody>
                        </table>
                    </div>
                </div>


                <div role="tabpanel" class="tab-pane " id="Section3">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="AllArea" >
                            <thead>
                                <tr >
                                    <th >{{__('app.Title')}} </th>
                                    <th >{{__('app.City')}} </th>
                                    <th >{{__('app.Edit')}}  </th>
                                    <th >{{__('app.Delete')}}  </th>
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