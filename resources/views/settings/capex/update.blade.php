@extends('templates.content',[
    'title'=>'Update CAPEX',
    'description'=>'Update CAPEX',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('CAPEX','/capex'),
        \App\Classes\Breadcrumb::create('Update')
    ]
])
@section('title','Update CAPEX')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/select2.css') }}">
<link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
@endsection
@php
    $currpath = request()->path();
    $updatePath = str_replace('update','view',$currpath);
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <form method="post" action="/capex/{{$data->ID}}/update">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Add Update CAPEX</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Job ID</label>
                                    <input type="text" class="form-control" name="JobID" value="{{ $data->JobID }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Job Description</label>
                                    <textarea style="resize: none;" rows="3" class="form-control flat" name="JobDescription">{{ $data->JobDescription }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Start Date</label>
                                    <input type='text' class='form-control datepicker' data-date-format='MM dd, yyyy' id='pckStart' name='StartDate' value="{{ Carbon\Carbon::parse($data->StartDate)->format('F d, Y') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Supervisor</label>
                                    <select id="selPerPage" class="form-control" name="Supervisor" style="width: 100px;">
                                        <option></option>
                                        @foreach(App\User::all() as $user)
                                            @if($user->isManager())
                                                <option value="{{ strtoupper($user->Person()->Name()) }}">{{ $user->Person()->Name() }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                    <a href="../../{{ $updatePath }}" class="btn btn-flat btn-default btn-sm">Cancel</a>
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

    var value = "{{ $data->Supervisor }}";
    console.log(value);


    var $perPage = $('#selPerPage').select2({
        width: '100%',
        placeholder: "Select Supervisor",
        minimumResultsForSearch: -1,
        val: value
    });

    $perPage.val(value).trigger('change');
    
    $('#pckStart').datepicker({
        format: 'MM dd, yyyy',
        autoclose: true,
        endDate: new Date()
    });

</script>
@endsection