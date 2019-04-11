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
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-6">
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
                                    <input type="text" class="form-control" name="Name" value="{{ $data->Name }}">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <textarea rows="4" class="form-control flat" name="Address" style="resize: none;">{{ $data->Address}}</textarea>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="togglebutton checkbox">
                                    <label>
                                        <input name="Default" type="checkbox" {{ $data->Default?"checked":"" }}>
                                        <span class="align-middle">&nbsp;&nbsp;Default Warehouse</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-flat btn-primary btn-sm">Save</button>
                                <a href="{{ $view_path }}" class="btn btn-flat btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
    </script>
@endsection