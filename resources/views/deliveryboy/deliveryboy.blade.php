@extends('include.app')

@section('content')

<script src="{{asset('asset/script/deliveryboy.js')}}"></script>

<div class="text-right mb-3">
    <a class="btn btn-primary adddbmodalBtn" href="" data-toggle="modal" data-target="#addDeliveryBoyModal" >{{__('app.Add')}} {{__('app.Delivery_Boy')}}
    </a>
</div>

<div class="modal fade" id="addDeliveryBoyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">{{__('app.Add')}} {{__('app.Delivery_Boy')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="addDeliveryBoyForm" method="post" enctype="multipart" >
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label >{{__('app.Username')}}</label>
                        <input type="text"  class="form-control " name="username"
                            placeholder="{{__('app.Username')}}"  value="" required>
                    </div>

                    <div class="form-group">
                        <label for="password">{{__('app.Password')}}</label>
                        <input  type="password" class="form-control " name="password" aria-invalid="false" required>
                    </div>

                    <div class="form-group">
                        <label >{{__('app.Fullname')}}</label>
                        <input type="text"  class="form-control " name="fullname"
                            placeholder="{{__('app.Fullname')}}"  value="" required>
                    </div>

                    <div class="form-group upto">
                        <label>{{__('app.PhoneNumber')}}</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-phone-volume text-dark"></i></div>
                            </div>
                            
                            <input type="number" name="number"  placeholder="{{__('app.PhoneNumber')}}"
                                class="form-control " required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">{{__('app.Save')}}</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{__('app.Close')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h4>{{__('app.Delivery_Boys')}}</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped w-100" id="deliveryBoyTable">
                <thead>
                    <tr>
                        <th>{{__('app.Image')}}</th>
                        <th>{{__('app.Username')}}</th> 
                        <th>{{__('app.Fullname')}}</th>
                        <th>{{__('app.PhoneNumber')}}</th>
                        <th>{{__('app.AmountToPay')}}</th>
                        <th>{{__('app.Action')}}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="editdbmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">{{__('app.Edit')}} {{__('app.Delivery_Boy')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <form id="editDeliveryBoyForm" method="post" enctype="multipart" novalidate="novalidate">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label >{{__('app.Username')}}</label>
                    <input type="text"  class="form-control username" name="username"
                        placeholder="{{__('app.Username')}}" value="" required>
                </div>

                <div class="form-group">
                    <label for="password">{{__('app.Password')}}</label>
                    <input  type="password" class="form-control password" name="password" aria-invalid="false" required>
                </div>

                <div class="form-group">
                    <label >{{__('app.Fullname')}}</label>
                    <input type="text"  class="form-control fullname" name="fullname"
                        placeholder="{{__('app.Fullname')}}"  value="" required>
                </div>

                <div class="form-group upto">
                    <label >{{__('app.PhoneNumber')}}</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-phone-volume text-dark"></i></div>
                        </div>
                        <input type="number" name="number" placeholder="{{__('app.PhoneNumber')}}"
                            class="form-control number" required>
                    </div>
                </div>

            </div>

            <input type="hidden" name='id' class="id">
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">{{__('app.Save')}}</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">{{__('app.Close')}}</button>
            </div>
        </form>
    </div>
</div>
</div>


    
@endsection