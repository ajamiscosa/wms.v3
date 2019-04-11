@extends('auth')
@section('title')
    Update Password
@endsection
@section('styles')
    <link rel="stylesheet" href="css/icheck.flat.css">
    <style>
        body{
            background-color: #eeeeee !important;
        }
        .login-box.shadow {
            box-shadow: 1px 1px 10px 1px rgba(0, 0, 0, 0.1);
        }
        .footer-box {
            width: 360px;
            margin: auto;
        }
    </style>
@endsection
@section('content')
    <div class="col-md-12">
        <div class="row">
            <div class="login-box shadow" style="margin-bottom: 3px;">
                <div class="login-box-body">
                    <div class="login-logo">
                        <a href="/"><img src="{{ asset('img/logo1.png') }}" style="max-width: 100%; max-height: 100%"/></a>
                    </div>
                    <br/>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible flat">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Error!</h4>
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span><br/>
                            @endforeach
                        </div>
                    @endif
                    @if(session()->has('message'))
                        <div class="alert alert-success flat">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <form method="post" action="/update-password" id="changepwform">
                        {{ csrf_field() }}
                        <div class="form-group has-icon has-feedback {{ $errors->has('Password.incorrect')?"has-error":"" }}" style="margin-bottom: 8px;">
                            <input type="password" name="CurrentPassword" id="CurrentPassword" class="form-control flat" placeholder="Current Password">
                            <span class="form-icon"><i class="fa fa-user-lock"></i></span>
                        </div>
                        <hr/>
                        <div class="form-group has-icon has-feedback {{ $errors->has('Password.incorrect')?"has-error":"" }}" style="margin-bottom: 8px;">
                            <input type="password" name="NewPassword" id="NewPassword" class="form-control flat" placeholder="New Password">
                            <span class="form-icon"><i class="fa fa-lock"></i></span>
                        </div>
                        <div class="form-group has-icon has-feedback {{ $errors->has('Password.incorrect')?"has-error":"" }}" style="margin-bottom: 8px;">
                            <input type="password" name="NewPassword_confirmation" id="NewPassword_confirmation" class="form-control flat" placeholder="Re-enter New Password">
                            <span class="form-icon"><i class="fa fa-lock"></i></span>
                        </div>
                        <div class="col-xs-12">
                            <button type='submit' class="btn btn-danger btn-block btn-flat">Update Password</button>
                        </div>
                    </form>
                </div>
                <!-- /.login-box-body -->
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection