
@extends('include.app')

@section('content')
<script src="{{asset('asset/script/banner.js')}}"></script>
<div class="text-right mb-3">
    <a class="btn btn-primary addbannerModalBtn" href="" data-toggle="modal" data-target="#addBannermodel"  >{{__('app.Add')}} {{__('app.Banner')}}  
    </a>
</div>

<div class="modal fade" id="addBannermodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true" >
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class=" ">
                    <h5>{{__('app.Add')}} {{__('app.Banner')}}  </h5>
                </div>
          
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

             
                  
                    <div class="">
                        <form action="" method="post" enctype="multipart/form-data" class="" id="addForm" autocomplete="off">
                            @csrf

                            <div class="form-group">
                                <label for="file">    <img src="{{ asset('asset/image/default.png') }}" id="defaultimg" height="150" width="150" class="rounded" alt=""></label>
                                <input type="file"  id="file" name="image" class="form-control add_image5 d-none" accept="image/x-png,image/jpeg" required>
                            </div>
                         
                                                  
                                                  <div class="info">
                                                      <p>{{__('app.bannerSlogan')}} </p>
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
        <h4>{{__('app.Banners')}} </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped w-100" id="bannerTable">
                <thead>
                    <tr>
                       
                        <th  >{{__('app.Banner')}}</th>
                      
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

<div class="modal fade" id="edit_unit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('app.Edit')}} {{__('app.Banner')}}  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data"  id="editbanner" autocomplete="off">

                    @csrf
                    <input type="hidden" class="form-control" id="editBannerid" name="id" value="">
       
                    <div class="form-group">
                        <label for="editimagefile">    <img src="" id="editdefaultimg" height="150" width="150" class="rounded" alt=""></label>
                        <input type="file"  id="editimagefile" name="image" class="form-control add_image5 d-none" accept="image/x-png,image/jpeg"  required>
                    </div>

                 
                    <div class="info">
                        <p> {{__('app.bannerSlogan')}}</p>
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