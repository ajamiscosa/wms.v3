@extends('templates.content',[
    'title'=>'View CAPEX',
    'description'=>'View CAPEX Details',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('CAPEX','/capex'),
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
        <div class="col-lg-4 col-md-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-text">
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>CAPEX: </strong>{{ $data->JobID }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="/category/update/{{$data->ID}}" method="post">
                                {{ csrf_field() }}
                                <a href="{{ $edit_path }}" class="btn btn-flat btn-fill btn-danger btn-sm">Edit</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding-top: 4px;">
                    <strong><i class="fa fa-braille mr-1"></i> Job ID</strong>
                    <p class="text-muted">
                        {{ $data->JobID }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-edit mr-1"></i> Job Description</strong>
                    <p class="text-muted">
                        {{ $data->JobDescription }}
                    </p>
                    </p>
                    <hr>
                    <strong><i class="fa fa-user-tie mr-1"></i> Supervisor</strong>
                    <p class="text-muted">
                        {{ $data->Supervisor }}
                    </p>
                    </p>
                    <hr>
                    <strong><i class="fa fa-calendar-alt mr-1"></i> Start Date</strong>
                    <p class="text-muted">
                        {{ Carbon\Carbon::parse($data->StartDate)->format('F d, Y') }}
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