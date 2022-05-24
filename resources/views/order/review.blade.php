@extends('include.app')

@section('content')

<script src="{{asset('asset/script/review.js')}}"></script>

    <div class="card">
        <div class="card-header">
            <h4>{{__('app.Reviews')}} </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped w-100" id="reviewTable">
                    <thead>
                        <tr>
                            <th>{{__('app.OrderId')}}  </th>
                            <th>{{__('app.Username')}}</th>
                            <th>{{__('app.Reviews')}} </th>
                            <th>{{__('app.Ratings')}} </th>
                            <th>{{__('app.Featured')}} </th>
                            <th>{{__('app.Action')}} </th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
@endsection
