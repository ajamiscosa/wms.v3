@extends('templates.content',[
    'title'=>'Update GL Code',
    'description'=>'Update GL Code information to the system.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('General Ledger','/gl'),
        \App\Classes\Breadcrumb::create('Update'),
    ]
])
@section('title',"Updating $data->Code")
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
@endsection
@php
    $url = \Illuminate\Support\Facades\URL::current();
    $app_url = env('APP_URL');
    $edit_path = str_replace($app_url, "", $url);
    $edit_path = str_replace("view", "update", $edit_path);


    $glcode = explode('-',$data->Code);
    $code = $glcode[0];
    $cc = $glcode[1];
    $pl = $glcode[2];
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-6">
            <form action="{{$edit_path}}" method="post">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Updating GL Code: </strong>[{{ $data->Code }}] {{ $data->Description }}</h3>
                    </div>
                    <div class="card-body" style="padding-top: 4px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Preview</label>
                                    <input type="text" class="form-control" id="Preview" value="{{ $data->Code }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="control-label">Account Type</label>
                                <div class="form-group">
                                    <select class="accountType-select form-control" name="AccountType" id="selAccountType" required>
                                        <option></option>
                                        <option value="X" {{ $data->Type=="X"?"selected":"" }}>Accounts RS Expense</option>
                                        <option value="V" {{ $data->Type=="V"?"selected":"" }}>Accounts RS Inventory</option>
                                        <option value="C" {{ $data->Type=="C"?"selected":"" }}>Accounts RS CAPEX</option>
                                        <option value="P" {{ $data->Type=="P"?"selected":"" }}>Accounts PO</option>
                                        <option value="I" {{ $data->Type=="I"?"selected":"" }}>Accounts Issuance</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Code</label>
                                    <input required type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" name="Code" id="txtCode" maxlength="5" min="10000" max="99999" value="{{ $code }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="control-label">Cost Center / Department</label>
                                <div class="form-group">
                                    <select class="costcenter-select form-control" name="CostCenter" id="selCostCenter" required>
                                        <option></option>
                                        @foreach(\App\Department::all() as $department)
                                            <option value="{{ $department->GL }}" {{ $department->GL==$cc?"selected":"" }}>[{{ $department->GL }}] {{ $department->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="control-label">Product Line</label>
                                <div class="form-group">
                                    <select class="pl-select form-control" name="ProductLine" id="selProductLine" required>
                                        <option></option>
                                        @foreach(\App\ProductLine::all() as $productLine)
                                        <option value="{{ $productLine->Code }}" {{ $productLine->Code==$pl?"selected":"" }}>[{{ $productLine->Code }}] {{ $productLine->Description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <input type="text" class="form-control" name="Description" value="{{ $data->Description }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="/gl" class="btn btn-flat btn-default btn-sm">Cancel</a>
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
        $('#txtCode').on('keyup',function(){
            updateCodePreview();
        });

        var $accountType = $('.accountType-select');
        $accountType.select2({
            placeholder: 'Select Account Type',
            minimumResultsForSearch: -1
        });

        var $cc = $('.costcenter-select');
        $cc.select2({
            placeholder: 'Select Cost Center',
            ajax: {
                url: '/department/costcenter/select-data',
                dataType: 'json'
            },
            minimumResultsForSearch: -1
        });


        $cc.on('change', function(){
            updateCodePreview();
        });

        var $pl = $('.pl-select');
        $pl.select2({
            placeholder: 'Select Product Line',
            minimumResultsForSearch: -1
        });

        $pl.on('change', function(){
            updateCodePreview();
        });

        function updateCodePreview(){
            var id = $("#txtCode").val();
            var cc = $("#selCostCenter").val();
            var pl = $("#selProductLine").val();
            $('#Preview').val(id+'-'+cc+'-'+pl);
        }
    </script>
@endsection