@extends('include.app')

@section('content')
<script src="{{asset('asset/script/viewcomplaint.js')}}"></script>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body padd-0">
                    <div>
                        <h5 class="font-normal font-18 card-title d-inline" >{{__('app.Complaint')}} - {{$data['complaints_id']}}</h5>

                        <div class="pull-right"> 
                      <a class="badge badge-danger text-white ">

                            <?php
                                if($data['status'] == 0){
                                    echo ''.__('app.Open').'';
                                }else {
                                   echo ''.__('app.Close').'';
                                }
                                ?>
                            
                        </a>
                        <?php
                        if($data['status'] == 0)echo '<a href=""  data-toggle="modal" rel="'.$data['id'].'" data-target="#ansModel"  class="btn btn-primary move ml-2">'.__('app.Resolved').'</a>';
                        
                        ?>
                    </div>
                       
                    </div>
                    <br>
                    <p> {{__('app.OrderId')}} : {{$data['order_id']}}</p>
                    <p>{{__('app.Username')}}  :{{$data['user']['firstname']}}</p>
                    <p>{{__('app.PhoneNumber')}} : {{$data['mobile_no']}}</p>
                    <p> {{__('app.Title')}} : {{$data['title']}}</p>
                    <p>{{__('app.Description')}}  :{{$data['description']}}</p>

                    <?php
                     

                     if($data['status'] != 0){
                         echo "<p> ".__('app.Answer')." :".$data['answer']."</p>";
                     }
                     
                    ?>
                    
                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ansModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('app.Answer')}}  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
    
            <form action="" method="POST" id="ansForm">
                <div class="modal-body">
    
                    <input type="hidden" name="id" class="id">
    
                    <div class="form-group ">
                        <label>{{__('app.Title')}} </label>
                    <input type="text" class="form-control" readonly id="title">
                    </div>
    
                    <div class="form-group ">
                        <label>{{__('app.Question')}} </label>
                    <input type="text" class="form-control" readonly  id="question">
                    </div>
                    <div class="form-group ">
                        <label>{{__('app.Answer')}} </label>
                     
                        <input type="hidden" id="comid" name="id">
                 <textarea    class="form-control" name="answer">
                 </textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group text-right">
                        <input type="submit" class=" btn btn-success" value="{{__('app.Save')}} ">
                        <a href="#" class="btn btn-light text-dark" data-dismiss="modal" aria-label="Close">{{__('app.Close')}} </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>

@endsection
