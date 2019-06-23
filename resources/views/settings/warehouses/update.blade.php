@extends('templates.content',[
    'title'=>'Location',
    'description'=>'Location',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Location','/warehouse'),
        \App\Classes\Breadcrumb::create('Update')
    ]
])
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/icheck.square-red.css') }}">
@endsection
@php
    $url = \Illuminate\Support\Facades\URL::current();
    $app_url = env('APP_URL');
    $edit_path = str_replace($app_url, "", $url);
    $view_path = str_replace("update", "view", $edit_path);
@endphp
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <form action="{{$edit_path}}" method="post">
                    {{ csrf_field() }}
                    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                        <div class="card-header card-header-text">
                            <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Updating: </strong>{{ $data->Name }}</h3>
                        </div>
                        <div class="card-body" style="padding-top: 4px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input required id="wName" type="text" class="form-control" name="Name" value="{{ $data->Name }}">
                                        <small id="code-error" style="color: red;"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button id="btnSubmit" type="submit" class="btn btn-flat btn-primary btn-sm">Save</button>
                                    <a href="{{ $view_path }}" class="btn btn-flat btn-default btn-sm">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script>
        $(function(){
            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_square-red'
            });
        })

        $(document).on('input',':input#wName', function() {
            var code = $(this).val();
            if(code.length > 2) {
            console.log(code);
                $.get({
                    url: "/wl/update/"+code,
                    success: function(msg) {
                        if(msg) {
                            $('#wName').addClass('is-invalid');
                            $('#code-error').html('<b>'+code+'</b> already exists in the database.');
                            $('#btnSubmit').attr('disabled','disabled');
                            nameExists = true;
                        }
                        else {
                            $('#wName').removeClass('is-invalid');
                            $('#code-error').text('');
                            $('#btnSubmit').removeAttr('disabled','disabled');
                            nameExists = false;
                        }
                    }
                });
            }
            else {
                $('#wName').removeClass('is-invalid');
                $('#btnSubmit').removeAttr('disabled','disabled');
                $('#code-error').text('');
            }
        });
    </script>
@endsection