@extends('templates.content',[
    'title'=>'View User Role',
    'description'=>'View all available options enabled on the user role.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('User Roles','/role'),
        \App\Classes\Breadcrumb::create('View')
    ]
])
@section('title','View User Role')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/icheck.square-red.css') }}">
@endsection
@php
    $permissions = json_decode($data->Permissions);

    $url = \Illuminate\Support\Facades\URL::current();
    $app_url = env('APP_URL');
    $edit_path = str_replace($app_url, "", $url);
    $edit_path = str_replace("view", "update", $edit_path);

    $name = explode(' ', $data->Name);
    $name = implode('-', $name);
@endphp

@section('content')
<div class="card card-danger card-outline flat"> <!--  collapsed-card-->
    <div class="card-header card-header-text">
        <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>User Role:</strong> {{ $data->Name }}</h3>
    </div>
    <div class="card-body" style="padding-bottom: 0px;">
                <form action="/role/toggle/{{$data->ID}}-{{$name}}" method="post">
                    {{ csrf_field() }}
                    @if($data->Status)
                        <a href="{{ $edit_path }}" class="btn btn-flat btn-fill btn-danger btn-sm">Edit</a>
                        <button type="submit" class="btn btn-flat btn-fill btn-default btn-sm">Disable</button>
                    @else
                        <button type="submit" class="btn btn-flat btn-fill btn-success btn-sm">Enable</button>
                    @endif
                </form>
    </div>
    <div class="card-body">
        @foreach(\Illuminate\Support\Facades\DB::table('permissions')->distinct()->get(['Module']) as $permission)
            <div class="row pb-0 mb-0 mt-0 pt-0">
                <div class="col-md-4 mt-3">
                    <h4>{{ \App\Classes\Helper::camelSplit($permission->Module) }}</h4>
                </div>
                @if($temp = \App\Permission::where([
                    ['Module','=',$permission->Module],
                    ['Permission','=','V']
                ])->first())
                    <div class="col-md-2 mt-3">
                        <div class="checkbox icheck">
                            <label><input name="Permissions[]" disabled type="checkbox" value="{{ $temp->ID }}" {{ in_array($temp->ID, $permissions, true)?"checked":"" }}><span class="align-middle">&nbsp;&nbsp;&nbsp;View</span></label>
                        </div>
                    </div>
                @endif
                @if($temp = \App\Permission::where([
                    ['Module','=',$permission->Module],
                    ['Permission','=','M']
                ])->first())
                    <div class="col-md-2 mt-3">
                        <div class="checkbox icheck">
                            <label><input name="Permissions[]" disabled type="checkbox" value="{{ $temp->ID }}" {{ in_array($temp->ID, $permissions, true)?"checked":"" }}><span class="align-middle">&nbsp;&nbsp;&nbsp;Modify</span></label>
                        </div>
                    </div>
                @endif
                @if($temp = \App\Permission::where([
                    ['Module','=',$permission->Module],
                    ['Permission','=','A']
                ])->first())
                    <div class="col-md-2 mt-3">
                        <div class="checkbox icheck">
                            <label><input name="Permissions[]" disabled type="checkbox" value="{{ $temp->ID }}" {{ in_array($temp->ID, $permissions, true)?"checked":"" }}><span class="align-middle">&nbsp;&nbsp;&nbsp;Approve</span></label>
                        </div>
                    </div>
                @endif
            </div>
            @if(!$loop->last)
                <hr/>
            @endif
        @endforeach
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-12">
                <p style="font-size: 8pt;">
                    <i>
                        @if($data->created_at == $data->updated_at)
                            @if($data->updated_at == \Carbon\Carbon::today())
                                Created: Today @ {{ $data->created_at->format('h:i:s A') }} by {{\App\User::where('ID','=',$data->created_by)->first()->Username }}
                            @else
                                Created: {{ $data->created_at->toFormattedDateString() }} by {{ \App\User::where('ID','=',$data->created_by)->first()->Username }};
                            @endif
                        @else
                            @if($data->updated_at->diffInDays(\Carbon\Carbon::now())>1)
                                Last Updated: {{ $data->updated_at->toFormattedDateString() }} by {{ \App\User::where('ID','=',$data->updated_by)->first()->Username }}
                            @else
                                Last Updated: Today @ {{ $data->updated_at->format('h:i:s A') }} by {{\App\User::where('ID','=',$data->updated_by)->first()->Username }}
                            @endif
                        @endif
                    </i>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script>
        $(function () {

            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_square-red'
            });

            var addFormGroup = function (event) {
                event.preventDefault();

                var $content = $(this).closest('.entry');
                var $clone = $content.clone();

                $(this)
                    .toggleClass('btn-default btn-add btn-danger btn-remove')
                    .html('<span class="glyphicon glyphicon-minus"></span>');

                $clone.where('ID','=','input').val('');
                $clone.insertAfter($content);

            };

            var removeFormGroup = function (event) {
                event.preventDefault();

                var $content = $(this).closest('.entry');
                $content.remove();
            };


            $(document).on('click', '.btn-add', addFormGroup);
            $(document).on('click', '.btn-remove', removeFormGroup);

        });
    </script>
@endsection