@extends('templates.content',[
    'title'=>'View Department',
    'description'=>'View department details.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Department','/department'),
        \App\Classes\Breadcrumb::create('View')
    ]
])
@section('title',"$data->Name | Departments")
@section('styles')
    <style>
        .form-group .select2-container {
            position: relative;
            z-index: 2;
            float: left;
            width: 100%;
            margin-bottom: 0;
            display: table;
            table-layout: fixed;
        }
    </style>
@endsection
@php
$name = explode(' ', $data->Name);
$name = implode('-', $name);
@endphp
@section('content')
<div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
            <div class="card-header card-header-text">
                <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Department Information
                    @if(!$data->Status)
                        <span class="badge badge-danger text-center align-middle flat" style="font-size: 11px;">DISABLED</span>
                    @endif
                </h3>
            </div>
            <div class="card-body container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="/department/toggle/{{$data->ID}}-{{$name}}" method="post">
                            {{ csrf_field() }}
                            @if($data->Status)
                                <a href="/department/update/{{ $data->ID }}-{{$name}}" class="btn btn-flat btn-fill btn-danger btn-sm">Edit</a>
                                <button type="submit" class="btn btn-flat btn-fill btn-default btn-sm">Disable</button>
                            @else
                                <button type="submit" class="btn btn-flat pull-right btn-fill btn-success btn-sm">Enable</button>
                            @endif
                        </form>
                    </div>
                </div>
                <hr>
                <strong><i class="fa fa-users mr-1"></i> Name</strong>
                <p class="text-muted">
                    {{ $data->Name }}
                </p>
                <strong><i class="fa fa-user-check mr-1"></i> Approver/s</strong>
                <p class="text-muted">
                    @foreach($data->Approvers() as $approver)
                        @php
                            echo "{$approver->Name()}";
                            if(!$loop->last){
                                echo "<br/>";
                            }
                        @endphp
                    @endforeach
                </p>
                <strong><i class="fa fa-user-friends mr-1"></i> Parent Department</strong>
                <p class="text-muted">
                    {{ $data->ParentDepartment()->Name }}
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