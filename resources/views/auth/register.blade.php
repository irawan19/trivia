@extends('layouts.app')
@section('content')

    <form class="form-horizontal form-material" id="loginform" action="{{ route('register') }}" method="POST">
        {{ csrf_field() }}
        @php($get_app_configuration = \App\Master_app_configuration::first())
        <a href="{{ URL('/') }}" class="text-center db"><img width="35%" src="{{ URL::asset($get_app_configuration->path_logo_app_configurations.$get_app_configuration->name_logo_app_configurations) }}"></a>
        <div class="form-group m-t-20">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
                {{ Shwetech::formError($errors->first('name')) }}
            </div>
        </div>
        <div class="form-group m-t-20">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="Email" required>
                {{ Shwetech::formError($errors->first('email')) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control" type="password" required="" placeholder="Password" name="password" required>
                {{ Shwetech::formError($errors->first('password')) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control" type="password" required="" placeholder="Confirm Password" name="password_confirmation" required>
                {{ Shwetech::formError($errors->first('password_confirmation')) }}
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" value="signup" name="signup">Sign Up</button>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-12 text-center">
                <p>Already have an account? <a href="login" class="text-info m-l-5"><b>Sign In</b></a></p>
            </div>
        </div>
    </form>

@endsection
