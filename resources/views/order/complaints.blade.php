@extends('include.app')

@section('content')
   
<script src="{{asset('asset/script/complaints.js')}}"></script>
<div class="modal fade" id="ansModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{__('app.Answer')}} </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form action="" method="POST" id="ansForm">
            <div class="modal-body">

                <input type="hidden" name="id" class="id">

                <div class="form-group ">
                    <label>{{__('app.Title')}}</label>
                <input type="text" class="form-control" readonly id="title">
                </div>

                <div class="form-group ">
                    <label>{{__('app.Question')}}</label>
                <input type="text" class="form-control" readonly  id="question">
                </div>
                <div class="form-group ">
                    <label>{{__('app.Answer')}}</label>
                 
                    <input type="hidden" id="comid" name="id">
             <textarea   class="form-control" name="answer">  </textarea>
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
            <h4>{{__('app.Complaints')}}</h4>
        </div>

        <div class="card-body">


            <div class="tab  " role="tabpanel">
                <ul class="nav nav-pills border-b mb-3  ml-0">

                    <li role="presentation" class="nav-item bg-light "><a class="nav-link pointer active" href="#Section1"
                            aria-controls="home" role="tab" data-toggle="tab">{{__('app.Open')}} {{__('app.Complaints')}} <span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>

                    <li role="presentation" class="nav-item bg-light "><a class="nav-link pointer" href="#Section3"
                            role="tab" data-toggle="tab">{{__('app.Close')}} {{__('app.Complaints')}}<span
                                class="badge badge-transparent total_open_complaint"></span></a>
                    </li>
                </ul>

                <hr>

                <div class="tab-content tabs" id="home">

                    <div role="tabpanel" class="tab-pane active" id="Section1">

                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="openComplaintTable" >
                                <thead>
                                    <tr>
                                        <th>{{__('app.ComplaintsId')}}</th>
                                        <th>{{__('app.OrderId')}}</th>
                                        <th>{{__('app.Username')}}</th>
                                        <th>{{__('app.Status')}}</th>
                                        <th>{{__('app.CreatedAt')}} </th>
                                        <th>{{__('app.Resolved')}}</th>
                                        <th>{{__('app.Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody id="">

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div role="tabpanel" class="tab-pane " id="Section3">
                        <div class="table-responsive">
                            <table class="table table-striped w-100" id="closeComplaintTable" >
                                <thead>
                                    <tr>
                                        <th>{{__('app.ComplaintsId')}}</th>
                                        <th>{{__('app.OrderId')}}</th>
                                        <th>{{__('app.Username')}}</th>
                                        <th>{{__('app.Status')}}</th>
                                        <th>{{__('app.CreatedAt')}} </th>
                                        <th>{{__('app.Action')}}</th>
                                       
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
