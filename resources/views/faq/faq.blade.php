@extends('include.app')

@section('content')
<script src="{{asset('asset/script/faq.js')}}"></script>
    <div class="text-right mb-3">
        <a class="btn btn-primary faqModalBtn" href="" data-toggle="modal" data-target="#addcat" >{{__('app.Add')}} {{__('app.FAQs')}}
        </a>
    </div>


    <div class="modal fade" id="addcat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class=" ">
                        <h5>{{__('app.Add')}} {{__('app.FAQs')}}</h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">



                    <div class="">
                        <form action="" method="post" enctype="multipart/form-data" class="" id="addForm"
                            autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label>{{__('app.Question')}}</label>
                                <input type="text" name="question" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>{{__('app.Answer')}} </label>
                                <textarea name="answer" class="form-control" required></textarea>
                            </div>


                            <div class="form-group text-right">
                                <input class="btn btn-success mr-1" type="submit" id="addcat2" value="{{__('app.Save')}}">
                                <a href="#" class="btn btn-light text-dark" data-dismiss="modal"
                                    aria-label="Close">{{__('app.Close')}}</a>
                            </div>

                        </form>


                    </div>



                </div>

            </div>
        </div>
    </div>






    <div class="card">
        <div class="card-header">
            <h4>{{__('app.FAQs')}} </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped w-100"  id="faqTable">
                    <thead>
                        <tr class="">
                            <th class="" >{{__('app.Question')}} </th>
                            <th >{{__('app.Answer')}} </th>
                            <th class="w-25">{{__('app.Action')}} </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit_cat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('app.Edit')}} {{__('app.FAQs')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" id="editFaq" autocomplete="off">

                        @csrf
                        <input type="hidden" class="form-control" id="editcatid" name="id" value="">

                        <div class="form-group">
                            <label for="">{{__('app.Question')}} </label>
                            <input type="text" class="form-control" id="editquestion" name="question" required>
                        </div>

                        <div class="form-group">
                            <label for="">{{__('app.Answer')}} </label>
                            <textarea class="form-control" id="editanswer" name="answer" required>
                            </textarea>
                        </div>



                        <div class="form-group text-right">
                            <input type="submit" class=" btn btn-success" value="{{__('app.Save')}} " id="editcat2">
                            <a href="#" class="btn btn-light text-dark" data-dismiss="modal" aria-label="Close">{{__('app.Close')}} </a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    
@endsection
