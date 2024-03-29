@extends('templates.content',[
    'title'=>'New CAPEX',
    'description'=>'Add New CAPEX',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('CAPEX','/capex'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title','New CAPEX')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <form method="post" action="/capex/store">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Add New CAPEX</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Job ID</label>
                                    <input id="cName" type="text" class="form-control" name="JobID" required>
                                    <small id="code-error" style="color: red;"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Job Description</label>
                                    <textarea style="resize: none;" rows="3" class="form-control flat" name="JobDescription" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Start Date</label>
                                    <input type='text' class='form-control datepicker' data-date-format='MM dd, yyyy' id='pckStart' name='StartDate' required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Supervisor</label>
                                    <input type="text" class="form-control" name="Supervisor" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Job Note</label>
                                    <textarea style="resize: none;" rows="3" class="form-control flat" name="JobNote" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Est. Expenses</label>
                                    <input type="number" step="0.01" class="form-control" name="DistributionEstExpenses" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button id="btnSubmit" type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="/capex" class="btn btn-flat btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')

<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<script>
    $('#pckStart').datepicker({
        format: 'MM dd, yyyy',
        autoclose: true,
        endDate: new Date()
    });
    $(document).on('input',':input#cName', function() {
            var code = $(this).val();
            if(code.length > 2) {
            console.log(code);
            code = code.replace('/','-');
                $.get({
                    url: "/c/update/"+code,
                    success: function(msg) {
                        if(msg) {
                            $('#cName').addClass('is-invalid');
                            $('#code-error').html('<b>'+code+'</b> already exists in the database.');
                            $('#btnSubmit').attr('disabled','disabled');
                        }
                        else {
                            $('#cName').removeClass('is-invalid');
                            $('#code-error').text('');
                            $('#btnSubmit').removeAttr('disabled','disabled');
                        }
                    }
                });
            }
            else {
                $('#cName').removeClass('is-invalid');
                $('#btnSubmit').removeAttr('disabled','disabled');
                $('#code-error').text('');
            }
        });

</script>
@endsection