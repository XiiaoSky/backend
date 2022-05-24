@extends('include.app')


@section('content')
<script src="{{asset('asset/script/order.js')}}"></script>
  


    <div class="modal fade" id="deliveryBoyModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.Add')}} {{__('app.Delivery_Boy')}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST" id="deliveryfrom">
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




    <div class="card mt-3">

        <div class="card-header">
            <h4>{{__('app.Orders')}} {{__('app.List')}}</h4>
        </div>

        <div class="card-body">


            <div class="tab  " role="tabpanel">
                <ul class="nav nav-pills border-b mb-3  ml-0">

                    <li role="presentation" class="nav-item bg-light mr-2 mt-2 "><a class="nav-link pointer active" href="#Section1"
                            aria-controls="home" role="tab" data-toggle="tab">{{__('app.All')}} {{__('app.Orders')}} <span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>

                    <li role="presentation" class="nav-item bg-light mr-2 mt-2 "><a class="nav-link pointer" href="#Section2"
                            role="tab" data-toggle="tab">{{__('app.Processing')}} {{__('app.Orders')}} <span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>


                    <li role="presentation" class="nav-item bg-light mr-2 mt-2"><a class="nav-link pointer" href="#Section3"
                            role="tab" data-toggle="tab">{{__('app.Confirmed')}} {{__('app.Orders')}} <span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>


                    <li role="presentation" class="nav-item bg-light mr-2 mt-2"><a class="nav-link pointer" href="#Section4"
                            role="tab" data-toggle="tab">{{__('app.OnHold')}} {{__('app.Orders')}}<span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>

                    <li role="presentation" class="nav-item bg-light mr-2 mt-2"><a class="nav-link pointer" href="#Section5"
                            role="tab" data-toggle="tab">{{__('app.Completed')}} {{__('app.Orders')}}<span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>


                    <li role="presentation" class="nav-item bg-light mr-2 mt-2"><a class="nav-link pointer" href="#Section6"
                            role="tab" data-toggle="tab">{{__('app.Cancelled')}} {{__('app.Orders')}} <span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>

                </ul>

                <hr>

                <div class="tab-content tabs" id="home">

                    <div role="tabpanel" class="tab-pane active" id="Section1">

                        <div class="table-responsive">
                            <table class="table table-striped w-100"  id="allOrderTable">
                                <thead>
                                    <tr>
                                        <th>{{__('app.OrderId')}}</th>
                                        <th>{{__('app.Username')}}</th>
                                        <th>{{__('app.Total')}}</th>
                                        <th>{{__('app.Status')}}</th>
                                        <th>{{__('app.PaymentType')}}</th>
                                        <th>{{__('app.Date')}}</th>
                                        <th>{{__('app.Action')}}</th>
                                        <th>{{__('app.StartDelivery')}}</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div role="tabpanel" class="tab-pane " id="Section2">
                        <div class="table-responsive">
                            <table class="table table-striped w-100"  id="ProcessingTable">
                                <thead>
                                    <tr>
                                        <th>{{__('app.OrderId')}}</th>
                                        <th>{{__('app.Username')}}</th>
                                        <th>{{__('app.Total')}}</th>
                                        <th>{{__('app.Status')}}</th>
                                        <th>{{__('app.PaymentType')}}</th>
                                        <th>{{__('app.Date')}}</th>
                                        <th>{{__('app.Action')}}</th>
                                        <th>{{__('app.StartDelivery')}}</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    


                    <div role="tabpanel" class="tab-pane " id="Section3">
                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="ConfirmedTable">
                                <thead>
                                    <tr>
                                        <th>{{__('app.OrderId')}}</th>
                                        <th>{{__('app.Username')}}</th>
                                        <th>{{__('app.Total')}}</th>
                                        <th>{{__('app.Status')}}</th>
                                        <th>{{__('app.PaymentType')}}</th>
                                        <th>{{__('app.Date')}}</th>
                                        <th>{{__('app.Action')}}</th>
                                      

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>


                 


                    <div role="tabpanel" class="tab-pane " id="Section4">
                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="holdTable">
                                <thead>
                                    <tr>
                                        <th>{{__('app.OrderId')}}</th>
                                        <th>{{__('app.Username')}}</th>
                                        <th>{{__('app.Total')}}</th>
                                        <th>{{__('app.Status')}}</th>
                                        <th>{{__('app.PaymentType')}}</th>
                                        <th>{{__('app.Date')}}</th>
                                        <th>{{__('app.Action')}}</th>
                                        <th>{{__('app.StartDelivery')}}</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>


        


                    <div role="tabpanel" class="tab-pane " id="Section5">
                        <div class="table-responsive">
                            <table class="table table-striped w-100"  id="CompletedTable">
                                <thead>
                                    <tr>
                                        <th>{{__('app.OrderId')}}</th>
                                        <th>{{__('app.Username')}}</th>
                                        <th>{{__('app.Total')}}</th>
                                        <th>{{__('app.Status')}}</th>
                                        <th>{{__('app.PaymentType')}}</th>
                                        <th>{{__('app.Date')}}</th>
                                        <th>{{__('app.Action')}}</th>
                                       

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>



                   





                    <div role="tabpanel" class="tab-pane " id="Section6">
                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="CancelledTable">
                                <thead>
                                    <tr>
                                        <th>{{__('app.OrderId')}}</th>
                                        <th>{{__('app.Username')}}</th>
                                        <th>{{__('app.Total')}}</th>
                                        <th>{{__('app.Status')}}</th>
                                        <th>{{__('app.PaymentType')}}</th>
                                        <th>{{__('app.Date')}}</th>
                                        <th>{{__('app.Action')}}</th>

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
