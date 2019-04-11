@extends('templates.content',[
    'title'=>'Update Shipping Method',
    'description'=>'Update Shipping Method',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Shipping Methods','/ship-via'),
        \App\Classes\Breadcrumb::create('Update')
    ]
])
@section('title',"Updating Shipping Method: $data->Description")
@section('styles')
@endsection
@php
    $url = \Illuminate\Support\Facades\URL::current();
    $app_url = env('APP_URL');
    $edit_path = str_replace($app_url, "", $url);
    $edit_path = str_replace("view", "update", $edit_path);
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <form action="{{$edit_path}}" method="post">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Updating: </strong>{{ $data->Description }}</h3>
                    </div>
                    <div class="card-body" style="padding-top: 4px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <textarea rows="4" class="form-control flat" style="resize: none;" name="Description" required>{{ $data->Description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row float-right">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="/ship-via" class="btn btn-flat btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')

@endsection