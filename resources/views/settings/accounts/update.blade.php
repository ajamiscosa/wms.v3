@extends('templates.content',[
    'title'=>'Update User Account',
    'description'=>'Update user account details.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('User Accounts','/account'),
        \App\Classes\Breadcrumb::create('Update')
    ]
])
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">

    <style>
        .form-group .select2-container{
            float: left;
            width: 100%;
            display: table;
            table-layout: fixed;
            margin-bottom: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="col-lg-4 col-lg-offset-4">
        <form method="post" action="/account/{{ $data->Username }}/update" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-text">
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Update User Account</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">First Name</label>
                                <input type="text" class="form-control" name="FirstName" value="{{ $data->Person()->FirstName }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Last Name</label>
                                <input type="text" class="form-control" name="LastName" value="{{ $data->Person()->LastName }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Username</label>
                                <input type="text" class="form-control" name="Username" value="{{ $data->Username }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Position</label>
                                <input type="text" class="form-control" name="Position" value="{{ $data->Person()->Position }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Role</label>
                                <select class="form-control role-select select2-container" multiple name="Role[]">
                                    <option></option>
                                    @foreach(\App\Role::all() as $role)
                                        <option value="{{ $role->ID }}" {{ in_array($role->ID,$data->Roles(1))?"selected":"" }}>{{ \App\Classes\Helper::camelSplit($role->Name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Department</label>
                                <select class="form-control dept-select" name="Department">
                                    <option></option>
                                    @foreach(\App\Department::all() as $dept)
                                        @if($data->Department == $dept->ID)
                                        <option value="{{ $dept->ID }}" selected>{{ $dept->Name }}</option>
                                        @else
                                        <option value="{{ $dept->ID }}">{{ $dept->Name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Gender</label>
                                <select class="form-control gender-select select2-container" name="Gender">
                                    <option></option>
                                    <option value="M" {{ $data->Person()->Gender=='M'?"selected":"" }}>Male</option>
                                    <option value="F" {{ $data->Person()->Gender=='F'?"selected":"" }}>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Email Address</label>
                                <input type="text" class="form-control" name="Email" value="{{ $data->Person()->Email }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Date of Birth</label>
                                <input type="text" class="form-control datepicker" data-date-format="MM dd, yyyy" id="Birthday" name="Birthday" value="{{ \Carbon\Carbon::parse($data->Person()->Birthday)->format('F d, Y') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Contact Number</label>
                                <input type="text" class="form-control" name="ContactNumber" value="{{ $data->Person()->ContactNumber }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row float-right">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                            <a href="/account" class="btn btn-flat btn-default btn-sm">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(function () {
            var count = 1;
            var addFormGroup = function (event) {
                event.preventDefault();
                if(count<2) {
                    var $content = $(this).closest('.entry');
                    var $clone = $content.clone();

                    $(this)
                        .toggleClass('btn-default btn-add btn-remove')
                        .html('<i class="fa fa-minus-circle"></i>');

                    $clone.find('input').val('');
                    $clone.insertAfter($content);
                    count++;
                }
            };

            var removeFormGroup = function (event) {
                event.preventDefault();
                var $content = $(this).closest('.entry');
                $content.remove();
                count--;
            };


            $(document).on('click', '.btn-add', addFormGroup);
            $(document).on('click', '.btn-remove', removeFormGroup);

            //
            $('#Birthday').datepicker();

            var $roleSelect = $('.role-select');
            $roleSelect.select2({
                placeholder: 'Select Role',
                minimumResultsForSearch: -1
            });
            var $genderSelect = $('.gender-select');
            $genderSelect.select2({
                placeholder: 'Select Gender',
                minimumResultsForSearch: -1
            });
            
            var $deptSelect = $('.dept-select');
            $deptSelect.select2({
                placeholder: 'Select Department',
                minimumResultsForSearch: -1
            });
        });
    </script>
@endsection