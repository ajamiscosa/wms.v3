@extends('templates.content',[
    'title'=>'New General Ledger Code',
    'description'=>'Add a new General Ledger Code to the system.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('General Ledger','/gl'),
        \App\Classes\Breadcrumb::create('New'),
    ]
])
@section('title','New General Ledger Code')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
@endsection
@section('content')
<div class="col-lg-4">
    <form method="post" action="/gl/store">
        {{ csrf_field() }}
        <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
            <div class="card-header card-header-text">
                <h3 class="card-title" style="padding-top: 0; margin-top: 0;">New General Ledger Code</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Preview</label>
                            <input type="text" class="form-control" id="Preview" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label class="control-label">Account Type</label>
                        <div class="form-group">
                            <select class="accountType-select form-control" name="AccountType" id="selAccountType" required>
                                <option></option>
                                <option value="X">Accounts RS Expense</option>
                                <option value="V">Accounts RS Inventory</option>
                                <option value="C">Accounts RS CAPEX</option>
                                <option value="P">Accounts PO</option>
                                <option value="I">Accounts Issuance</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Code</label>
                            <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" name="Code" id="txtCode" maxlength="5" min="10000" max="99999" required/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label class="control-label">Cost Center / Department</label>
                        <div class="form-group">
                            <select class="costcenter-select form-control" name="CostCenter" id="selCostCenter" required>
                                <option></option>
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
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <input type="text" class="form-control flat" name="Description" required/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row float-right">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                        <a href="/gl" class="btn btn-flat btn-default btn-sm">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
            ajax: {
                url: '/product-line/glselectdata',
                dataType: 'json'
            },
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