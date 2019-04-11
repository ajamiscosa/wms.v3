@extends('templates.content',[
    'title'=>'View Shipping Methods',
    'description'=>'View All Shipping Methods',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Shipping Methods','/ship-via'),
        \App\Classes\Breadcrumb::create('View')
    ]
])
@section('title',"$data->Description | Shipping Method")
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
        <div class="col-lg-4 col-md-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-text">
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Shipping Method: </strong>{{ $data->Description }}
                        @if(!$data->Status)
                            <span class="badge badge-danger text-center align-middle flat" style="font-size: 11px;">DISABLED</span>
                        @endif
                    </h3>
                </div>
                <div class="card-body" style="padding-bottom: 0px;">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="/ship-via/toggle/{{$data->Description}}" method="post">
                                {{ csrf_field() }}
                            @if($data->Status)
                                <a href="{{ $edit_path }}" class="btn btn-flat btn-fill btn-danger btn-sm">Edit</a>
                                <button type="submit" class="btn btn-flat btn-fill btn-default btn-sm">Disable</button>
                            @else
                                <button type="submit" class="btn btn-flat btn-fill btn-success btn-sm">Enable</button>
                            @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding-top: 4px;">
                    <hr>
                    <strong><i class="fa fa-edit mr-1"></i> Description</strong>
                    <p class="text-muted">
                        {{ $data->Description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection