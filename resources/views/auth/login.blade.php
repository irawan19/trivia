@extends('layouts.app')
@section('content')

    <form class="form-horizontal form-material" id="loginform" action="{{ route('login') }}" method="POST">
        {{ csrf_field() }}
        @php($get_app_configuration = \App\Master_app_configuration::first())
        <a href="{{ URL('/') }}" class="text-center db"><img width="35%" src="{{ URL::asset($get_app_configuration->path_logo_app_configurations.$get_app_configuration->name_logo_app_configurations) }}"></a>
        <div class="form-group m-t-40">
            <div class="col-xs-12">
                <input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
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
            <div class="col-md-12">
                <div class="checkbox checkbox-primary pull-left p-t-0">
                    <input id="checkbox-signup" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="checkbox-signup"> Remember me </label>
                </div>
                <a href="{{ route('password.request') }}" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
            </div>
        </div>
        @php($check_admin = \App\User::where('level_systems_id','1')->count())
        @if($check_admin == 0)
            <div class="form-group m-b-0">
                <div class="col-sm-12 text-center">
                    <p>Don't have an account? <a href="register" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                </div>
            </div>
        @endif
    </form>

@endsection
