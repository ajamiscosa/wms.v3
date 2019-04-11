@extends('templates.content',[
    'title'=>'View Category',
    'description'=>'View Category Details',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Category','/category'),
        \App\Classes\Breadcrumb::create('View')
    ]
])
@section('styles')
@endsection
@php
$url = \Illuminate\Support\Facades\URL::current();
$app_url = env('APP_URL');
$edit_path = str_replace($app_url, "", $url);
$edit_path = str_replace("view", "update", $edit_path);

$name = explode(' ', $data->Name);
$name = implode('-', $name);
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-6">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-text">
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Category: </strong>{{ $data->Name }}
                        @if(!$data->Status)
                            <span class="badge badge-danger text-center align-middle flat" style="font-size: 11px;">DISABLED</span>
                        @endif
                    </h3>
                </div>
                <div class="card-body" style="padding-bottom: 0px;">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="/category/toggle/{{$data->ID}}-{{$name}}" method="post">
                                {{ csrf_field() }}
                            @if($data->Status)
                                <button type="submit" class="btn btn-flat pull-right btn-fill btn-default btn-sm">Disable</button>
                                <a href="{{ $edit_path }}" class="btn btn-flat pull-right btn-fill btn-danger btn-sm">Edit</a>
                            @else
                                <button type="submit" class="btn btn-flat pull-right btn-fill btn-success btn-sm">Enable</button>
                            @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding-top: 4px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input type="text" class="form-control" name="Name" value="{{ $data->Name }}" readonly>
                                
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Address</label>
                                <textarea readonly rows="3" class="form-control flat" style="resize: none;" name="Address">{{ $data->Description }}</textarea>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection