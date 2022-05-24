@extends('include.app')

@section('content')

<script src="{{asset('asset/script/setting.js')}}"></script> 



    <div class="card col-md-12">
        <div class="card-header">
           <h5>{{__('app.Prefix')}}</h5>
        </div>

        <div class="card-body">
            <form action="" method="POST" id="idsFrom">
        <div class="form-group">
            <label>{{__('app.Order')}} {{__('app.Prefix')}} </label>
            <input type="text"  name="of" value="{{$idsdata['of']}}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>{{__('app.Complaint')}} {{__('app.Prefix')}} </label>
            <input type="text"  name="cf" value="{{$idsdata['cf']}}" class="form-control" required>
        </div>
        
        
        <div class="form-group ">
            <input type="submit" class=" btn btn-success" value="{{__('app.Save')}}" >
        </div>

            </form>
        </div>

    </div>
  





    <div class="card col-md-12">
        <div class="card-header">
           <h5> {{__('app.EditSettingData')}}  </h5>
        </div>

       
            <div class="card-body">
                <form action="" method="POST" id="shippingchargeFrom">

            <div class="row">

                <div class="form-group col-md-6">
                    <label>{{__('app.AppName')}} </label>
                    <input type="text"  name="app_name" value="{{$data['app_name']}}" class="form-control" required>
                </div>
                <div class="form-group upto  col-md-6">
                    <label for="min_amount">{{__('app.ShippingCharge')}} </label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{$data['currencies']}}</div>
                        </div>
                        <input type="number"  name="shippingcharge" 
                            class="form-control " value="{{$data['shippingcharge']}}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('app.Currency')}}</label>
                    <input type="text"  name="currencies" value="{{$data['currencies']}}" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('app.MaximumQSlogan')}}</label>
                    <input type="number"  name="quantity" value="{{$data['quantity']}}" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('app.SupportNumber')}}</label>
                    <input type="text"  name="number" value="{{$data['number']}}" class="form-control" required>
                </div>

                <div class="form-group col-md-6">
                    <label>{{__('app.SupportEmail')}}</label>
                    <input type="text"  name="email" value="{{$data['email']}}" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group  col-md-6">
                    <label>{{__('app.PlaystoreUrl')}} </label>
                    <input type="text"  name="playstore" value="{{$data['playstore']}}" class="form-control" required>
                </div>
                <div class="form-group  col-md-6">
                    <label>{{__('app.AppstoreUrl')}} </label>
                    <input type="text"  name="appstore" value="{{$data['appstore']}}" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>{{__('app.TermsOfUseUrl')}}</label>
                    <input type="text"  name="terms" value="{{$data['terms']}}" class="form-control" required>
                </div>

                <div class="form-group col-md-6">
                    <label>{{__('app.PrivacyPolicyUrl')}}</label>
                    <input type="text"  name="privacy_policy" value="{{$data['privacy_policy']}}" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group  col-md-6">
                    <label>{{__('app.AboutUrl')}}</label>
                    <input type="text"  name="about" value="{{$data['about']}}" class="form-control" required>
                </div>
                <div class="form-group  col-md-6">
                    <label>{{__('app.ContactUrl')}}</label>
                    <input type="text"  name="contact" value="{{$data['contact']}}" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group  col-md-6">
                    <label>{{__('app.InstagramUrl')}}</label>
                    <input type="text"  name="instagram" value="{{$data['instagram']}}" class="form-control" required>
                </div>
                <div class="form-group  col-md-6">
                    <label>{{__('app.FacebookUrl')}}</label>
                    <input type="text"  name="facebook" value="{{$data['facebook']}}" class="form-control" required>
                </div>
            </div>


            <div class="row">
                <div class="form-group  col-md-6">
                    <label>{{__('app.twitterUrl')}}</label>
                    <input type="text"  name="twitter" value="{{$data['twitter']}}" class="form-control" required>
                </div>
                <div class="form-group  col-md-6">
                    <label>{{__('app.LinkedinUrl')}}</label>
                    <input type="text"  name="linkedin" value="{{$data['linkedin']}}" class="form-control" required>
                </div>
            </div>


            <div class="row">
                <div class="form-group  col-md-6">
                    <label>{{__('app.ShortDescription')}}</label>
                    <input type="text"  name="short_des" value="{{$data['short_des']}}" class="form-control" required>
                </div>
                <div class="form-group  col-md-6">
                    <label>{{__('app.Slogan')}} </label>
                    <input type="text"  name="slogan" value="{{$data['slogan']}}" class="form-control" required>
                </div>
            </div>

            <div class="form-group  " >
                <label>{{__('app.LongDescription')}} </label>
                <textarea type="text"  name="long_des" class="form-control" required>{{$data['long_des']}}</textarea>
            </div>
                

           
            <div class="row">
                <div class="form-group col-md-4">
                    <input type="submit" class=" btn btn-success" value="{{__('app.Save')}}" >
                </div>
            </div>
            </form>
            </div>
        
    </div>

@endsection
