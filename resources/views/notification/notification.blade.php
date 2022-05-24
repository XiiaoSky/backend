@extends('include.app')


@section('content')
<script src="{{asset('asset/script/notification.js')}}"></script>
<div class="text-right mb-3">
    <a class="btn btn-primary addnotimodalbtn" href="" data-toggle="modal" data-target="#addNotificationmodal"  >{{__('app.Add')}} {{__('app.Notification')}} 
    </a>
</div>


<div class="modal fade" id="addNotificationmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true" >
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class=" ">
                    <h5>{{__('app.Add')}} {{__('app.Notification')}} </h5>
                </div>
               
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

             
                  
                    <div class="">
                        <form action="" method="post" enctype="multipart/form-data" class="add_category" id="addForm" autocomplete="off">
                            @csrf

                            <div class="form-group">
                                <label for="file">    <img src="{{ asset('asset/image/default.png') }}" id="defaultimg" height="150" width="150" class="rounded" alt=""></label>
                                <input type="file"  id="file" name="image" class="form-control add_image5 d-none" accept="image/x-png,image/jpeg"  >
                            </div>

                            <div class="form-group">
                                <label>{{__('app.Title')}}</label>
                                <input type="text"  name="title" class="form-control" required>
                            </div>
                       
                          
                            <div class="form-group">
                                <label for="">{{__('app.Message')}}</label>
                                <textarea  class="form-control"  name="message"  required></textarea>
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


<div class="modal fade" id="edit_cat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('app.Edit')}} {{__('app.Notification')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data"  id="editnotiform" autocomplete="off">

                    @csrf
                    <input type="hidden" class="form-control" id="editcatid" name="id" value="">

                    <div class="form-group">
                        <label for="editimage"> <img src="" alt="" width="150" height="150" id="editshow_img" class="rounded"></label>
                        <input type="file" class="form-control d-none" id="editimage" name="image" accept="image/x-png,image/gif,image/jpeg"  >
                    </div>
       
                    <div class="form-group">
                        <label for="">{{__('app.Title')}}</label>
                        <input type="text" class="form-control" id="edit_title" name="title"  required>
                    </div>

                 
                    

                    <div class="form-group">
                        <label for="">{{__('app.Message')}}</label>
                        <textarea  class="form-control" id="message"  name="message"  required></textarea>
                    </div>


                    <div class="form-group text-right">
                        <input type="submit" class=" btn btn-success" id="editcat2" value="{{__('app.Save')}}">
                        <a href="#" class="btn btn-light text-dark" data-dismiss="modal" aria-label="Close">{{__('app.Close')}}</a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h4>{{__('app.Notifications')}}</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="notificationtable">
                <thead>
                    <tr>
                        <th>{{__('app.Image')}}</th>
                        <th >{{__('app.Title')}}</th>
                        <th >{{__('app.Message')}}</th>
                        <th >{{__('app.Edit')}}</th>
                        <th >{{__('app.Delete')}}</th>
                    </tr>
                </thead>
                <tbody >

                </tbody>
            </table>
        </div>
    </div>
</div>
    

@endsection