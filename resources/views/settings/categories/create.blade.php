@extends('templates.content',[
    'title'=>'New Category',
    'description'=>'Add New Item Category',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Category','/category'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title','New Category')
@section('styles')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <form method="post" action="/category/store">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Add New Category</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Name</label>&ensp;<small id="name-error" style="color: red;"></small>
                                    <input type="text" class="form-control" name="Name" id="Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <textarea style="resize: none;" rows="3" class="form-control flat" name="Description" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-flat btn-danger btn-sm" id="btnSave">Save</button>
                                <a href="/category" class="btn btn-flat btn-default btn-sm">Cancel</a>
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
    
    $('#Name').on('input', function() {
            var code = $(this).val();
            if(code.length > 0) {
                $.get({
                    url: "/category/check/"+$(this).val(),
                    success: function(msg) {
                        if(msg) {
                            $('#Name').addClass('is-invalid');
                            $('#name-error').html('<b>'+code+'</b> already exists in the database.');
                            $('#btnSave').attr('disabled','disabled');
                        }
                        else {
                            $('#Name').removeClass('is-invalid');
                            $('#Name-error').text('');
                            $('#btnSave').removeAttr('disabled');
                        }
                    }
                });
            }
            else {
                $('#Name').removeClass('is-invalid');
                $('#Name-error').text('');
            }
        });
</script>
@endsection