@extends('templates.content',[
    'title'=>'Create Department',
    'description'=>'Add a new department to the database.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Department','/department'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title','New Department')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <style>
        .form-group .select2-container {
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
        <div class="row">
            <form method="post" action="/department/store">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Department Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <span class="label label-danger">**</span>
                                    <label class="control-label">Code</label>
                                    <input id="dName" type="text" class="form-control" name="Code" required>
                                    <small id="code-error" style="color: red;"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <span class="label label-danger">**</span>
                                    <label class="control-label">Name</label>
                                    <input id="dName" type="text" class="form-control" name="Name" required>
                                    <small id="code-error" style="color: red;"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Manager</label>
                                    <select required class="manager-select form-control select2-container" name="Manager" style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <span class="label label-danger">**</span>
                                    <label class="control-label">Approver/s</label>
                                    <select class="approver-select form-control select2-container" multiple name="Approver[]" required style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Parent Department</label>
                                    <select class="parent-select form-control select2-container" name="ParentDepartment" required style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Department Code (to be used in G/L Accounts)</label>
                                    <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="GL" class="form-control text-right" style="width: 25%" maxlength="2" required/>
                                </div>
                            </div>
                        </div>
                        {{--<div class="row">--}}
                            {{--<div class="col-lg-12">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label class="control-label">General Ledger Code</label>--}}
                                    {{--<select class="gl-select form-control select2-container" name="GL" style="width: 100%;">--}}
                                        {{--<option></option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <div class="card-footer">
                        <div class="row float-right">
                            <div class="col-md-12">
                                <button id="btnSubmit" type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="/department" class="btn btn-flat btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>    
        $(document).on('input',':input#dName', function() {
            var code = $(this).val();
            if(code.length > 2) {
            console.log(code);
                $.get({
                    url: "/d/update/"+code,
                    success: function(msg) {
                        if(msg) {
                            $('#dName').addClass('is-invalid');
                            $('#code-error').html('<b>'+code+'</b> already exists in the database.');
                            $('#btnSubmit').attr('disabled','disabled');
                            nameExists = true;
                        }
                        else {
                            $('#dName').removeClass('is-invalid');
                            $('#code-error').text('');
                            $('#btnSubmit').removeAttr('disabled','disabled');
                            nameExists = false;
                        }
                    }
                });
            }
            else {
                $('#dName').removeClass('is-invalid');
                $('#btnSubmit').removeAttr('disabled','disabled');
                $('#code-error').text('');
            }
        });


        var $approverSelect = $('.approver-select');
        $approverSelect.select2({
            width: '100%',
            ajax: {
                url: '/department/approverdata',
                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            matcher: matchCustom,
            placeholder: "Select Approver"
        });

        var $managerSelect = $('.manager-select');
        $managerSelect.select2({
            width: '100%',
            ajax: {
                url: '/department/approverdata',
                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            matcher: matchCustom,
            placeholder: "Select Manager"
        });

        var $parentSelect = $('.parent-select');
        $parentSelect.select2({
            width: '100%',
            ajax: {
                url: '/department/parentdata',
                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            matcher: matchCustom,
            placeholder: "Select Parent Department"
        });

        var $glSelect = $('.gl-select');
        $glSelect.select2({
            width: '100%',
            ajax: {
                url: '/department/gldata',
                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            matcher: matchCustom,
            placeholder: "Select GL Code"
        });


        function matchCustom(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }

            // `params.term` should be the term that is used for searching
            // `data.text` is the text that is displayed for the data object
            if (data.text.indexOf(params.term) > -1) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.text += ' (matched)';

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }

            // Return `null` if the term should not be displayed
            return null;
        }
    </script>
@endsection