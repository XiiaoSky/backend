@extends('include.app')


@section('content')

<script src="{{asset('asset/script/unit.js')}}"></script> 
<div class="text-right mb-3">
    <a class="btn btn-primary addunitModalBtn" href="" data-toggle="modal" data-target="#addunitmodel"  >{{__('app.Add')}}  {{__('app.Unit')}} 
    </a>
</div>

<div class="modal fade" id="addunitmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true" >
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class=" ">
                    <h5>{{__('app.Add')}}  {{__('app.Unit')}} </h5>
                </div>
             
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

             
                  
                    <div class="">
                        <form action="" method="post" enctype="multipart/form-data" class="addunit" id="addForm" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label>{{__('app.Title')}} </label>
                                <input type="text"  name="title" class="form-control" required>
                            </div>
                       

                            <div class="form-group text-right">
                                <input class="btn btn-success mr-1" type="submit" id="addcat2" value="{{__('app.Save')}}">
                                <a href="#" class="btn btn-light text-dark" data-dismiss="modal" aria-label="Close">{{__('app.Close')}}</a>
                            </div>

                        </form>


                    </div>

               

            </div>

        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h4>{{__('app.Units')}}</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped w-100" id="unitshowtable">
                <thead>
                    <tr>
                       
                        <th class="w-75" >{{__('app.Title')}}</th>
                      
                        <th >{{__('app.Edit')}}</th>
                     
                    </tr>
                </thead>
                <tbody >

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
                <h5 class="modal-title" id="exampleModalLabel">{{__('app.Edit')}}  {{__('app.Unit')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data"  id="edit_cat" autocomplete="off">

                    @csrf
                    <input type="hidden" class="form-control" id="editunitid" name="id" value="">
       
                    <div class="form-group">
                        <label for="">{{__('app.Title')}}</label>
                        <input type="text" class="form-control" id="edit_title" name="title"  required>
                    </div>

                

                    <div class="form-group text-right">
                        <input type="submit" value="{{__('app.Save')}}" class=" btn btn-success" id="editcat2">
                        <a href="#" class="btn btn-light text-dark" data-dismiss="modal" aria-label="Close">{{__('app.Close')}}</a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>




@endsection