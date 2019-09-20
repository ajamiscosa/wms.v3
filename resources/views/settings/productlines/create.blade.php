@extends('templates.content',[
    'title'=>'New Product Line',
    'description'=>'Add New Product Line',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Product Lines','/product-line'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('styles')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-6">
            <form method="post" action="/product-line/store">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Add New Product Line</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">G/L Code Suffix</label><small>&emsp;ie. [52100-01-<b><u>00</u></b>] MC-PROCESS CHEMICALS - SE</small>
                                    <input type="number" class="form-control" name="Code" id="prodCode" maxlength="2" required placeholder="ie. 00 for Common"/>  
                                    <small id="code-error" style="color: red;"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Code / Identifier</label>
                                    <input type="text" class="form-control" id="prodName" name="Name" maxlength="2" required placeholder="ie. CM for Common"/>  
                                    <small id="code-error-name" style="color: red;"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <textarea style="resize: none;" rows="3" class="form-control flat" name="Description" required placeholder="ie. Common"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button id="btnSubmit" type="submit" class="btn btn-flat btn-primary btn-sm">Save</button>
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
        var nameExists = false;
        var codeExists = false;
        
        $('#prodName').on('input', function() {
            var code = $(this).val();
            if(code.length == 2) {
                $.get({
                    url: "/product-line/check/name/"+code,
                    success: function(msg) {
                        if(msg) {
                            $('#prodName').addClass('is-invalid');
                            $('#code-error-name').html('<b>'+code+'</b> already exists in the database.');
                            nameExists = true;
                        }
                        else {
                            $('#prodName').removeClass('is-invalid');
                            $('#code-error-name').text('');
                            nameExists = false;
                        }
                    }
                });
            }
            else {
                $('#prodName').removeClass('is-invalid');
                $('#code-error-name').text('');
            }
        });
        
        $('#prodCode').on('input', function() {
            var code = $(this).val();
            if(code.length == 2) {
                $.get({
                    url: "/product-line/check/code/"+code,
                    success: function(msg) {
                        if(msg) {
                            $('#prodCode').addClass('is-invalid');
                            $('#code-error').html('<b>'+code+'</b> already exists in the database.');
                            $('#btnSubmit').attr('disabled','disabled');
                        }
                        else {
                            $('#prodCode').removeClass('is-invalid');
                            $('#code-error').text('');
                            $('#btnSubmit').removeAttr('disabled','disabled');
                        }
                    }
                });
            }
            else {
                $('#prodCode').removeClass('is-invalid');
                $('#btnSubmit').removeAttr('disabled','disabled');
                $('#code-error').text('');
            }
        });
    </script>
@endsection