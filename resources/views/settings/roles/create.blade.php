@extends('templates.content',[
    'title'=>'New User Role',
    'description'=>'Create a new user role.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('User Roles','/role'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/icheck.square-red.css') }}">
@endsection
@section('content')
<form method="post" action="/role/store">
    {{ csrf_field() }}
    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
        <div class="card-header card-header-text">
            <h3 class="card-title" style="padding-top: 0; margin-top: 0;">New User Role</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input type="text" class="form-control" name="Name">
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
                        <label><input name="Permissions[]" type="checkbox" value="{{ $temp->ID }}"><span class="align-middle">&nbsp;&nbsp;&nbsp;View</span></label>
                    </div>
                </div>
                @endif
                @if($temp = \App\Permission::where([
                    ['Module','=',$permission->Module],
                    ['Permission','=','M']
                ])->first())
                <div class="col-md-2 mt-3">
                    <div class="checkbox icheck">
                        <label><input name="Permissions[]" type="checkbox" value="{{ $temp->ID }}"><span class="align-middle">&nbsp;&nbsp;&nbsp;Modify</span></label>
                    </div>
                </div>
                @endif
                @if($temp = \App\Permission::where([
                    ['Module','=',$permission->Module],
                    ['Permission','=','A']
                ])->first())
                <div class="col-md-2 mt-3">
                    <div class="checkbox icheck">
                        <label><input name="Permissions[]" type="checkbox" value="{{ $temp->ID }}"><span class="align-middle">&nbsp;&nbsp;&nbsp;Approve</span></label>
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
                    <button type="submit" class="btn btn-flat btn-primary btn-sm">Save</button>
                    <a href="/uom" class="btn btn-flat btn-default btn-sm">Cancel</a>
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