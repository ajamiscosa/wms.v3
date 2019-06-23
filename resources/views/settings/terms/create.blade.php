@extends('templates.content',[
    'title'=>'New Term',
    'description'=>'Create New Term',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Terms','/term'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title','New Term')
@section('styles')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <form method="post" action="/term/store">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Add New Term</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <input id="tName" type="text" class="form-control" name="Description" required/>                                        <small id="code-error" style="color: red;"></small>
                                    <small id="code-error" style="color: red;"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Value (numeric)</label>
                                    <input type="number" class="form-control" name="Value" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button id="btnSubmit" type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="/term" class="btn btn-flat btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).on('input',':input#tName', function() {
            var code = $(this).val();
            if(code.length > 2) {
            console.log(code);
                $.get({
                    url: "/t/update/"+code,
                    success: function(msg) {
                        if(msg) {
                            $('#tName').addClass('is-invalid');
                            $('#code-error').html('<b>'+code+'</b> already exists in the database.');
                            $('#btnSubmit').attr('disabled','disabled');
                            nameExists = true;
                        }
                        else {
                            $('#tName').removeClass('is-invalid');
                            $('#code-error').text('');
                            $('#btnSubmit').removeAttr('disabled','disabled');
                            nameExists = false;
                        }
                    }
                });
            }
            else {
                $('#tName').removeClass('is-invalid');
                $('#btnSubmit').removeAttr('disabled','disabled');
                $('#code-error').text('');
            }
        });
</script>
@endsection