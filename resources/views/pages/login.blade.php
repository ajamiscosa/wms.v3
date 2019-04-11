@extends('auth')
@section('title',"Login")
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
                        <img src="{{ asset('img/logo1.png') }}" style="max-width: 100%; max-height: 100%"/>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Error!</h4>
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif
                        <form action="/login" method="post">
                            {{ csrf_field() }}
                            <div class="form-group has-icon has-feedback {{ $errors->has('Username.notfound')?"has-error":"" }}" style="margin-bottom: 5px;">
                                <input type="text" class="form-control flat" name="Username" id="Username" placeholder="Username" value="{{ old('Username') }}">
                                <span class="form-icon"><i class="fa fa-user"></i></span>
                            </div>
                            <div class="form-group has-icon has-feedback {{ $errors->has('Password.incorrect')?"has-error":"" }}" style="margin-bottom: 8px;">
                                <input type="password" name="Password" id="Password" class="form-control flat" placeholder="Password">
                                <span class="form-icon"><i class="fa fa-lock"></i></span>
                            </div>
                            <div class="col-xs-12">
                                <button type='submit' class="btn btn-danger btn-block btn-flat" value="Login">Login</button>
                            </div>
                        </form>
                </div>
                <!-- /.login-box-body -->
            </div>
        </div>
        <div class="footer-box" style="margin-top: 0px">
            <div class="register-box-msg">
                Copyright © 2018 <br/>DevFINITY® Solutions<br/>ZMPS Engineering Services, Inc.<br/>All Rights Reserved.
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection