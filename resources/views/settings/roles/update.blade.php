@extends('templates.content',[
    'title'=>'Update User Role',
    'description'=>'Update available actions for the user role.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('User Roles','/role'),
        \App\Classes\Breadcrumb::create('Update')
    ]
])
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
<form method="post" action="{{ $edit_path }}">
    {{ csrf_field() }}
    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
        <div class="card-header card-header-text">
            <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Updating User Role:</strong> {{ \App\Classes\Helper::camelSplit($data->Name) }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input type="text" class="form-control" name="Name" value="{{ $data->Name }}">
                    </div>
                </div>
            </div>
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
                                <label><input name="Permissions[]" type="checkbox" class="form-control" value="{{ $temp->ID }}" {{ in_array($temp->ID, $permissions, true)?"checked":"" }}><span class="align-middle">&nbsp;&nbsp;&nbsp;View</span></label>
                            </div>
                        </div>
                    @endif
                    @if($temp = \App\Permission::where([
                        ['Module','=',$permission->Module],
                        ['Permission','=','M']
                    ])->first())
                        <div class="col-md-2 mt-3">
                            <div class="checkbox icheck">
                                <label><input name="Permissions[]" type="checkbox" class="form-control" value="{{ $temp->ID }}" {{ in_array($temp->ID, $permissions, true)?"checked":"" }}><span class="align-middle">&nbsp;&nbsp;&nbsp;Modify</span></label>
                            </div>
                        </div>
                    @endif
                    @if($temp = \App\Permission::where([
                        ['Module','=',$permission->Module],
                        ['Permission','=','A']
                    ])->first())
                        <div class="col-md-2 mt-3">
                            <div class="checkbox icheck">
                                <label><input name="Permissions[]" type="checkbox" class="form-control" value="{{ $temp->ID }}" {{ in_array($temp->ID, $permissions, true)?"checked":"" }}><span class="align-middle">&nbsp;&nbsp;&nbsp;Approve</span></label>
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
                    <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                    <a href="/role" class="btn btn-flat btn-default btn-sm">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
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

                $clone.find('input').val('');
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