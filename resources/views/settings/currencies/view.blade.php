@extends('templates.content',[
    'title'=>'View Currency',
    'description'=>'View Currency Details and Exchange Rate',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Currency','/currency'),
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
        <div class="col-lg-3 col-md-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-text">
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Currency: </strong>{{ $data->Name }}</h3>
                </div>
                <div class="card-body" style="padding-bottom: 0px;">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ $edit_path }}" class="btn btn-flat btn-fill btn-danger btn-sm">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding-top: 4px;">
                    <hr>
                    <strong><i class="fa fa-braille mr-1"></i> Code</strong>
                    <p class="text-muted">
                        {{ $data->Code }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-edit mr-1"></i> Name</strong>
                    <p class="text-muted">
                        {{ $data->Name }}
                    </p>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <strong><i class="fa fa-dollar-sign mr-1"></i> USD</strong>
                            <p class="text-muted">
                                {{ $data->USD }}
                            </p>
                        </div>
                        <div class="col-lg-6">
                            <strong><i class="fa fa-money-bill mr-1"></i> PHP</strong>
                            <p class="text-muted">
                                {{ $data->PHP }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <strong><i class="fa fa-stopwatch mr-1"></i> Last Updated</strong>
                    <p class="text-muted">
                        {{ \Carbon\Carbon::parse($data->updated_at)->toDayDateTimeString() }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-question mr-1"></i> Update Required</strong>
                    <p class="text-muted">
                        {{ $data->updateRequired()?"Yes":"No" }}
                    </p>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection