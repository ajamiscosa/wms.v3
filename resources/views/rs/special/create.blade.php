@extends('templates.content',[
    'title'=>'Special Purchase Request',
    'description'=>'New Special Purchase Request',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Requisition','/rs'),
        \App\Classes\Breadcrumb::create('Purchase Request   ','/purchase-request'),
        \App\Classes\Breadcrumb::create('New Special Request')
    ]
])
@section('title','New Special Purchase Request')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">
    <style>
        a {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        a:hover {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        span.uom {
            display: inline-flex;
            align-items: center;
        }
        input[type='text'].datepicker {
            height: 38px;
        }
        .xwrapper {
            display : flex;
            align-items : center;
        }

    </style>
@endsection
@section('content')
    <div class="col-md-12">
        <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
            <div class="card-header card-header-text">
                <h3 class="card-title">
                    <strong>New Special Purchase Request</strong>
                </h3>
            </div>
            <form action="/issuance-request/store" method="post">
                <input type="hidden" name="Type" value="PR">
                <input type="hidden" name="ChargeType" value="D">
                {{csrf_field()}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="GLCode" class="control-label">Charge Type</label>
                                <select required class="form-control charge-type-select" name="ChargeType">
                                    <option></option>
                                    <option value="S" selected>STOCK</option>
                                    <option value="D">DIRECT CHARGE</option>
                                    <option value="C">CAPEX</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="capexDiv">
                            <div class="form-group">
                                <label for="GLCode" class="control-label" >CAPEX</label>
                                <select class="form-control capex-select" name="CAPEX">
                                    <option></option>
                                    @foreach(App\CAPEX::all() as $capex)
                                        <option value="{{ $capex->JobID }}">{{ $capex->JobID }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label ">Request Type</label>
                                <select required class="form-control requestType-select" name="RequestType">
                                    <option></option>
                                    <option value="S">Service</option>
                                    <option value="O">One Time Purchase</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label ">Charge To</label>
                                <br class="input-lining"/>
                                <select required class="form-control department-select" name="ChargeTo" id="ChargeTo">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="GLCode" class="control-label">G/L Code</label>
                                <select required class="form-control glcode-select" name="GLCode">
                                    <option></option>
                                    {{--@foreach(\App\GeneralLedger::getInventoryGeneralLedgerCodes() as $gl)--}}
                                    {{--<option value="{{ $gl->ID }}">[{{ $gl->Code }}] {{ $gl->Description }}</option>--}}
                                    {{--@endforeach--}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label ">Date Required</label>
                                <input required type="text" class="form-control datepicker" id="DateRequired" name="DateRequired" value="{{ \Carbon\Carbon::today()->format('F d, Y') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Purpose" class="control-label">Purpose</label>
                                <textarea class="form-control flat" style="resize: none;" rows="3" name="Purpose" required></textarea>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row float-right">
                                <div class="col-md-12">
                                    <input type="button" class="btn btn-block btn-flat btn-outline btn-danger" id="btnAddLineItem" value="Add Line Item"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row" id="mydiv">
                        <div class="col-lg-12">
                            <table id="roTable" class="table table-no-bordered dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                                <thead>
                                <tr role="row">
                                    <th>Item / Service</th>
                                    <th style="width: 30%;">GL Code</th>
                                    <th style="width: 20%;" class="text-center">Quantity</th>
                                    <th class="text-right">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody class="productTable">
                                <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row">&nbsp;</div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Remarks" class="control-label">Remarks</label>
                                        <textarea class="form-control flat" style="resize: none;" rows="3" name="Remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row float-right">
                        <div class="col-md-12">
                            <button type="submit" class="btn flat btn-danger btn-sm">Save</button>
                            <a href="/purchase-order" class="btn btn-default btn-sm">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script>
        $(function(){
            $('#btnAddLineItem').on('click', function(){
                var requestType = $('.requestType-select').val();
                var chargedTo = $('.department-select').val();

                if(requestType=="" || chargedTo=="") {
                    swal({
                        type: 'error',
                        title: 'Input Required',
                        html: "Please select Request Type and Charged Department first.",
                        confirmButtonColor: '#DC3545'
                    });
                } else {
                    if(requestType==='S') {
                        console.log("Service Request");
                        var result = swal({
                            type: 'info',
                            title: 'Service Request',
                            html: "@include('templates.addservice')",
                            showCancelButton: true,
                            confirmButtonColor: '#DC3545',
                            confirmButtonText: 'Add Item',
                            cancelButtonText: 'Cancel',
                            allowOutsideClick: false,
                        }).then(function(x){
                            if(x.value===true) {
                                console.log(x);
                                var desc = $('#Description').val();
                                var table = $("#roTable tbody");

                                if(
                                    desc.length>0
                                ) {
                                    var markup = $.ajax({type: "GET",
                                        url: "/special-request/new-line-service?Description="+desc, async: false}).responseText;
                                    table.append(markup);
                                }
                                else {

                                }
                            }
                        });
                    } else {
                        console.log("One Time Purchase");
                        swal({
                            type: 'info',
                            title: 'Line Item',
                            html: "@include('templates.addproduct')",
                            showCancelButton: true,
                            confirmButtonColor: '#DC3545',
                            confirmButtonText: 'Add Item',
                            cancelButtonText: 'Cancel',
                            allowOutsideClick: false,
                            onBeforeOpen: function() {
                                var $categorySelect = $('.category-select');
                                $categorySelect.select2({
                                    placeholder: 'Select Category',
                                    ajax: {
                                        url: '/category/select-data',
                                        dataType: 'json',
                                        success: function(x) {
                                            var source = $('#Source').val();
                                            x.results.splice( $.inArray(source, x.results), 1 );
                                        }
                                    },
                                    matcher: matchCustom,
                                    minimumResultsForSearch: -1
                                });

                                var $productLineSelect = $('.productline-select');
                                $productLineSelect.select2({
                                    placeholder: 'Select Product Line',
                                    ajax: {url: '/product-line/select-data',
                                        dataType: 'json',
                                        success: function(x) {
                                            var source = $('#Source').val();
                                            x.results.splice( $.inArray(source, x.results), 1 );
                                        }
                                    },
                                    matcher: matchCustom,minimumResultsForSearch: -1
                                });

                                var $uomSelect = $('.uom-select');
                                $uomSelect.select2({
                                    placeholder: 'Select UOM',
                                    ajax: {url: '/uom/select-data',
                                        dataType: 'json',
                                        success: function(x) {
                                            var source = $('#Source').val();
                                            x.results.splice( $.inArray(source, x.results), 1 );
                                        }
                                    }
                                });
                            }
                        }).then(function(x, evt){
                            if(x.value===true) {
                                console.log(x);
                                var name = $('#Name').val();
                                var desc = $('#Description').val();
                                var category = $('.category-select').val();
                                var productLine = $('.productline-select').val();
                                var uom = $('.uom-select').val();


                                var table = $("#roTable tbody");

                                if(
                                    name.length>0 &&
                                    desc.length>0 &&
                                    category.length>0 &&
                                    productLine.length>0 &&
                                    uom.length>0
                                ) {
                                    var markup = $.ajax({type: "GET",
                                        url: "/special-request/new-line-item?Name="+name+"&Description="+desc+"&Category="+category+"&ProductLine="+productLine+"&UOM="+uom, async: false}).responseText;
                                    table.append(markup);
                                }
                                else {

                                }
                            }
                        });
                    }
                }
            });


            var $requestType = $('.requestType-select').select2({
                placeholder: 'Select Request Type',
                minimumResultsForSearch: -1
            });

            var $chargeType = $(".charge-type-select").select2({
                placeholder: 'Select Charge Type',
                minimumResultsForSearch: -1
            });

            
            var $capex = $(".capex-select").select2({
                placeholder: 'Select CAPEX',
                minimumResultsForSearch: -1
            });

            $(document).ready(function(){
                $('#capexDiv').hide();
            });

            $(document).on('change','.charge-type-select', function(e) {
                var chargeType = $chargeType.val();
                if(chargeType=='C') {
                    $('#capexDiv').show();
                    $('#Remarks').attr('readonly',true);
                    var capex = $capex.val();
                    $('#Remarks').val(capex);
                }
                else {
                    $('#capexDiv').hide();
                    $('#Remarks').attr('readonly',false);
                    $('#Remarks').val('');
                }
            });

            $(document).on('change','.capex-select', function(e) {
                var capex = $capex.val();
                $('#Remarks').val(capex);
            });
            


            var $glCode = $(".glcode-select").select2({
                placeholder: 'Select GL Code',
                minimumResultsForSearch: -1
            });



            var glType = 'inventory';
            var chargeType = 'S';

            var deptID = $('#ChargeTo').val();
            $glCode.select2({
                ajax: {
                    url: '/rs/gl-data/'+glType+'/'+deptID,
                    dataType: 'json'
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                matcher: matchCustom,
                placeholder: 'Select GL Code'
            });


            $(document).on('change','.charge-type-select', function(e) {
                chargeType = $chargeType.val();
                switch (chargeType) {
                    case 'S': glType = 'inventory'; break;
                    case 'D': glType = 'expense'; break;
                    case 'C': glType = 'capex'; break;
                }
                var deptID = $('#ChargeTo').val();
                console.log(deptID);
                $glCode.val("");
                $glCode.select2({
                    ajax: {
                        url: '/rs/gl-data/'+glType+'/'+deptID,
                        dataType: 'json'
                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    },
                    matcher: matchCustom,
                    placeholder: 'Select GL Code'
                });
            });

            $(document).on('change','.department-select', function(e) {
                var deptID = $('#ChargeTo').val();
                console.log(deptID);
                $glCode.val("");
                $glCode.select2({
                    ajax: {
                        url: '/rs/gl-data/'+glType+'/'+deptID,
                        dataType: 'json'
                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    },
                    matcher: matchCustom,
                    placeholder: 'Select GL Code'
                });

            });
















            var requestType = $requestType.val();

            $requestType.on('select2:select',function(e){
                e.preventDefault();
                if(requestType!=="") {
                    var result = swal({
                        type: 'warning',
                        title: 'Warning',
                        html: 'Changing <b>Request Type</b> now will reset all line items. Continue?',
                        showCancelButton: true,
                        confirmButtonColor: '#DC3545',
                        confirmButtonText: 'Proceed',
                        cancelButtonText: 'Cancel',
                        allowOutsideClick: false,
                    }).then(function(x){
                        if(x.value===true) {
                            requestType = $requestType.val();
                            $('#roTable tr.line-item').remove();
                        } else {
                            $requestType.select2("val", requestType);
                        }
                    });
                } else {
                    requestType = $requestType.val();
                }
            });





























            var $datepicker = $('#DateRequired').datepicker({
                format: "MM dd, yyyy",
                autoclose: true,
                startDate: new Date()
            });

            $('#datemask').inputmask('MM dd, yyyy', { 'placeholder': 'MM dd, yyyy' });

            var date = Date.parse($datepicker.val());
            $datepicker.datepicker("setDate", new Date(date));

            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $("input[type='checkbox'].item").change(function(){
                var a = $("input[type='checkbox'].item");
                if(a.length == a.filter(":checked").length){
                    $("#checkAll").prop('checked', true);
                }else {
                    $("#checkAll").prop('checked', false);
                }
            });

            var $deptSelect = $(".department-select").select2({
                ajax: {
                    url: '/rs/department-data',
                    dataType: 'json'
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                matcher: matchCustom,
                placeholder: 'Select Department'
            });

            $(".glcode-select").select2({
                placeholder: 'Select GL Code'
            });

            $deptSelect.on('change', function () {
                var $glCode = $('.glcode-select').val("");

                var deptID = $('.department-select').select2('data')[0].id;
                $glCode.select2({
                    ajax: {
                        url: '/rs/gl-data/expense/'+deptID,
                        dataType: 'json'
                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    },
                    matcher: matchCustom,
                    placeholder: 'Select GL Code'
                });
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

        });
    </script>
@endsection