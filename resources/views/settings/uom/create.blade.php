@extends('templates.content',[
    'title'=>'New Units of Measure',
    'description'=>'Create a new Unit of Measure',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Units of Measure','/uom'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title','New Unit of Measure')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/select2.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <form method="post" action="/uom/store">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Add New Unit of Measure</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">Name</label>
                                    <input id="UomName" type="text" class="form-control" name="Name" required>
                                    <small id="code-error" style="color: red;"></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Code</label>
                                    <input type="text" class="form-control" name="Abbreviation" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Allow Decimal</label>
                                    <select class="form-control decimal-select" name="Type" required>
                                        <option></option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row float-right">
                            <div class="col-md-12">
                                <button id="btnSubmit" type="submit" class="btn flat btn-danger btn-sm">Save</button>
                                <a href="/uom" class="btn flat btn-default btn-sm">Cancel</a>
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

        $('#UomName').on('input', function() {
            var code = $(this).val();
            if(code.length > 2) {
            console.log(code);
                $.get({
                    url: "/uom/ajax/"+code,
                    success: function(msg) {
                        if(msg) {
                            $('#UomName').addClass('is-invalid');
                            $('#code-error').html('<b>'+code+'</b> already exists in the database.');
                            $('#btnSubmit').attr('disabled','disabled');
                            nameExists = true;
                        }
                        else {
                            $('#UomName').removeClass('is-invalid');
                            $('#code-error').text('');
                            $('#btnSubmit').removeAttr('disabled','disabled');
                            nameExists = false;
                        }
                    }
                });
            }
            else {
                $('#UomName').removeClass('is-invalid');
                $('#btnSubmit').removeAttr('disabled','disabled');
                $('#code-error').text('');
            }
        });


        $(function () {
            var addFormGroup = function (event) {
                event.preventDefault();

                var $content = $(this).closest('.entry');
                var $clone = $content.clone();

                $(this)
                    .toggleClass('btn-add btn-outline-danger btn-remove')
                    .html('<i class="fa fa-minus-circle"></i>');

                $clone.find('input').val('');
                $clone.insertAfter($content);

            };

            var removeFormGroup = function (event) {
                event.preventDefault();

                var $content = $(this).closest('.entry');
                $content.remove();
            };


            $('.decimal-select').select2({
                placeholder: '- Select -',
                minimumResultsForSearch: -1
            });

            $(document).on('click', '.btn-add', addFormGroup);
            $(document).on('click', '.btn-remove', removeFormGroup);

        });
    </script>
@endsection