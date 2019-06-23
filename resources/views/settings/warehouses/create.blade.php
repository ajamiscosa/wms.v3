@extends('templates.content',[
    'title'=>'Location',
    'description'=>'Location',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Location','/warehouse'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/icheck.square-red.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <form method="post" action="/location/store">
                    {{ csrf_field() }}
                    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                        <div class="card-header card-header-text">
                            <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Add New Location</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label class="control-label">Name</label>
                                        <input required minlength="2" type="text" id="wName" class="form-control" name="Name">
                                        <small id="code-error" style="color: red;"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button id="btnSubmit" type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                    <a href="/location" class="btn btn-flat btn-default btn-sm">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script>
        $(function(){
            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_square-red'
            });
        })

        $('#wName').on('input', function() {
            var code = $(this).val();
            if(code.length == 2) {
            console.log(code);
                $.get({
                    url: "/wl/update/"+code,
                    success: function(msg) {
                        if(msg) {
                            $('#wName').addClass('is-invalid');
                            $('#code-error').html('<b>'+code+'</b> already exists in the database.');
                            $('#btnSubmit').attr('disabled','disabled');
                            nameExists = true;
                        }
                        else {
                            $('#wName').removeClass('is-invalid');
                            $('#code-error').text('');
                            $('#btnSubmit').removeAttr('disabled','disabled');
                            nameExists = false;
                        }
                    }
                });
            }
            else {
                $('#wName').removeClass('is-invalid');
                $('#btnSubmit').removeAttr('disabled','disabled');
                $('#code-error').text('');
            }
        });
    </script>
@endsection