@extends('include.app')


@section('content')

<script src="{{asset('asset/script/users.js')}}"></script> 
<div class="card">
    <div class="card-header">
        <h4>{{__('app.Users')}}</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped w-100"  id="UsersTable">
                <thead>
                    <tr>
                        <th >{{__('app.Identity')}}</th>
                        <th >{{__('app.Full_Name')}}</th>
                        <th >{{__('app.Active')}}</th>
                
                    </tr>
                </thead>
                <tbody >

                </tbody>
            </table>
        </div>
    </div>
</div>


    
@endsection