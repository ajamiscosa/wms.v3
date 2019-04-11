@extends('templates.content',[
    'title'=>'View Units of Measure',
    'description'=>'View details of a Unit of Measure',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Units of Measure','/uom'),
        \App\Classes\Breadcrumb::create('View')
    ]
])
@section('title',"$data->Name ($data->Abbreviation)")
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
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Unit of Measurement: </strong>{{ $data->Name }}
                        @if(!$data->Status)
                            <span class="badge badge-danger text-center align-middle flat" style="font-size: 11px;">DISABLED</span>
                        @endif
                    </h3>
                </div>
                <div class="card-body" style="padding-bottom: 0px;">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="/uom/toggle/{{$data->ID}}-{{$name}}" method="post">
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
                <div class="card-body">
                    <hr class="pb-0 mt-0">
                    <div class="row mb-0 pb-0">
                        <div class="col-lg-8 col-md-8">
                            <strong><i class="fa fa-edit mr-1"></i> Name</strong>
                            <p class="text-muted">
                                {{ $data->Name }}
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <strong><i class="fa fa-code mr-1"></i> Abbreviation</strong>
                            <p class="text-muted">
                                {{ $data->Abbreviation }}
                            </p>
                        </div>
                    </div>
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