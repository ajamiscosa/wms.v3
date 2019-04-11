@extends('templates.content',[
    'title'=>'User Accounts',
    'description'=>'View all user accounts associated with the system',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('User Accounts','/account'),
        \App\Classes\Breadcrumb::create('New Account')
    ]
])
@section('title','Account Registration')
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
        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }
        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }
        .image-preview-input-title {
            margin-left:2px;
        }
    </style>
@endsection
@section('content')
    <div class="col-lg-4 col-lg-offset-4">
<form method="post" action="/account/store" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
        <div class="card-header card-header-text">
            <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Add User Account</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input type="text" class="form-control" name="FirstName">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input type="text" class="form-control" name="LastName">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">Username</label>
                        <input type="text" class="form-control" name="Username">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <input type="password" class="form-control" name="Password">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group ">
                        <label class="control-label">Repeat Password</label>
                        <input type="password" class="form-control" name="RePassword">
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
                                <option value="{{ $role->ID }}">{{ \App\Classes\Helper::camelSplit($role->Name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">Position</label>
                        <input type="text" class="form-control" name="Position">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">Gender</label>
                        <select class="form-control gender-select select2-container" name="Gender">
                            <option></option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">Email Address</label>
                        <input type="text" class="form-control" name="Email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">Date of Birth</label>
                        <input type="text" class="form-control datepicker" data-date-format="MM dd, yyyy" id="Birthday" name="Birthday" value="{{ \Carbon\Carbon::create(1980,01,01)->format('F d, Y') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">Contact Number</label>
                        <input type="text" class="form-control" name="ContactNumber">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <label class="control-label">Picture</label>
                    <!-- image-preview-filename input [CUT FROM HERE]-->
                    <div class="input-group image-preview">
                        <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
                        <span class="input-group-btn">
                    <!-- image-preview-clear button -->
                    <button type="button" class="btn btn-flat btn-default image-preview-clear mr-0" style="display:none;">
                        <span class="glyphicon glyphicon-remove"></span> Clear
                    </button>
                            <!-- image-preview-input -->
                    <div class="btn btn-flat btn-default image-preview-input ml-0">
                        <span class="glyphicon glyphicon-folder-open"></span>
                        <span class="image-preview-input-title">Browse</span>
                        <input type="file" accept="image/png, image/jpeg, image/gif" name="input-file-preview"/> <!-- rename it -->
                    </div>
                </span>
                    </div><!-- /input-group image-preview [TO HERE]-->
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
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
            $('#Birthday').datepicker({
                format: "MM dd, yyyy",
                autoclose: true
            });

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
        });
        $(document).on('click', '#close-preview', function(){
            $('.image-preview').popover('hide');
            // Hover befor close the preview
            $('.image-preview').hover(
                function () {
                    $('.image-preview').popover('show');
                },
                function () {
                    $('.image-preview').popover('hide');
                }
            );
        });

        $(function() {
            // Create the close button
            var closebtn = $('<button/>', {
                type:"button",
                text: 'x',
                id: 'close-preview',
                style: 'font-size: initial;',
            });
            closebtn.attr("class","close pull-right");
            // Set the popover default content
            $('.image-preview').popover({
                trigger:'manual',
                html:true,
                title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
                content: "There's no image",
                placement:'bottom'
            });
            // Clear event
            $('.image-preview-clear').click(function(){
                $('.image-preview').attr("data-content","").popover('hide');
                $('.image-preview-filename').val("");
                $('.image-preview-clear').hide();
                $('.image-preview-input input:file').val("");
                $(".image-preview-input-title").text("Browse");
            });
            // Create the preview image
            $(".image-preview-input input:file").change(function (){
                var img = $('<img/>', {
                    id: 'dynamic',
                    width:250,
                    height:200
                });
                var file = this.files[0];
                var reader = new FileReader();
                // Set preview image into the popover data-content
                reader.onload = function (e) {
                    $(".image-preview-input-title").text("Change");
                    $(".image-preview-clear").show();
                    $(".image-preview-filename").val(file.name);
                    img.attr('src', e.target.result);
                    $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection