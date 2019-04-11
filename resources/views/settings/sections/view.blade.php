@extends('templates.content',[
    'title'=>'Location',
    'description'=>'Location',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Location','/section'),
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
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Section: </strong>{{ $data->Name }}
                    </h3>
                </div>
                <div class="card-body" style="padding-bottom: 0px;">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="" class="btn btn-flat pull-right btn-fill btn-default btn-sm">Delete</a>
                            <a href="{{ $edit_path }}" class="btn btn-flat pull-right btn-fill btn-group-begin btn-danger btn-sm">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding-top: 4px;">
                    <hr>
                    <strong><i class="fa fa-edit mr-1"></i> Name</strong>
                    <p class="text-muted">
                        {{ $data->Name }}
                    </p>
                    <strong><i class="fa fa-edit mr-1"></i> Description</strong>
                    <p class="text-muted">
                        {{ $data->Description }}
                    </p>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="font-size: 8pt;">
                                <i>
                                    @if($data->created_at == $data->updated_at)
                                        @if($data->updated_at == \Carbon\Carbon::today())
                                            Created: Today @ {{ $data->created_at->format('h:i:s A') }} by {{\App\User::find($data->created_by)->first()->Username }}
                                        @else
                                            Created: {{ $data->created_at->toFormattedDateString() }} by {{ \App\User::find($data->created_by)->first()->Username }};
                                        @endif
                                    @else
                                        @if($data->updated_at->diffInDays(\Carbon\Carbon::now())>1)
                                            Last Updated: {{ $data->updated_at->toFormattedDateString() }} by {{ \App\User::find($data->updated_by)->first()->Username }}
                                        @else
                                            Last Updated: Today @ {{ $data->updated_at->format('h:i:s A') }} by {{\App\User::find($data->updated_by)->first()->Username }}
                                        @endif
                                    @endif
                                </i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection