@extends('templates.content',[
    'title'=>'Purchase Request',
    'description'=>'New Purchase Request',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Requisition','/rs'),
        \App\Classes\Breadcrumb::create('Purchase Request   ','/purchase-request'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title','New Purchase Request')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
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
        input::-webkit-input-placeholder {
            font-size: 0.8em;
            line-height: 3;
            text-align: right;
        }
    </style>
@endsection
@section('content')
<div class="col-md-12">
<div class="card card-danger card-outline flat"> <!--  collapsed-card-->
    <div class="card-header card-header-text">
        <h3 class="card-title">
            <strong>New Purchase Request</strong>
        </h3>
    </div>
    <form action="/issuance-request/store" method="post">
        <input type="hidden" name="Type" value="PR">
        <input type="hidden" name="ChargeType" value="S">
        {{csrf_field()}}
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="GLCode" class="control-label">Charge Type</label>
                                <select class="form-control charge-type-select" name="ChargeType">
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
                                <label class="control-label ">Department</label>
                                <div class="form-group" style="border: 1px solid #AAA;">
                                    <span style="line-height: 36px;">&nbsp;&nbsp;{{ auth()->user()->Department()->Name }}</span>
                                    <input type="hidden" id="userDept" value="{{auth()->user()->Department()->ID}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label ">Approver</label>
                                <select class="form-control approver1-select" name="Approver1" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label ">Charged To Department</label>
                                <br class="input-lining"/>
                                <select class="form-control department-select" name="ChargeTo" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label ">Charged Department Approver</label>
                                <select class="form-control approver2-select" name="Approver2" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>









                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Purpose" class="control-label">Purpose</label>
                                <textarea class="form-control flat" style="resize: none;" rows="3" name="Purpose" required>Restock</textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="GLCode" value="0">
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="GLCode" class="control-label">G/L Code</label>
                                <select class="form-control glcode-select" name="GLCode" required>
                                    <option></option>
                                    {{-- @foreach(\App\GeneralLedger::getInventoryGeneralLedgerCodes() as $gl)
                                        <option value="{{ $gl->ID }}">[{{ $gl->Code }}] {{ $gl->Description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <br/>
            <br/>

            <div class="table-responsive-md">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-50" scope="col">Item</th>
                            <th class="w-50" scope="col">
                                <label class="float-right">Quantity</label>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        @php
                            $product = \App\Product::where('ID','=',$item)->first();
                        @endphp
                        <tr>
                            <th class="w-50" scope="row">    
                                <input type="hidden" value="{{ $product->ID }}" name="Product[]">
                                [{{ $product->UniqueID }}] {{ $product->Description }}
                            </th>
                            <td class="w-50" scope="col">
                                <span class="float-right" style="margin-left:5px">
                                    {{ $product->UOM()->Abbreviation }}
                                </span>
                                <input 
                                    style="width:125px" 
                                    class="form-control float-right"
                                    placeholder="Enter Quantity" 
                                    min="0" 
                                    name="Quantity[]" 
                                    type="number" 
                                    step="{{ $product->UOM()->Type==1?"0.001":"1" }}"
                                    required>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
                                <textarea class="form-control flat" style="resize: none;" id="Remarks" rows="3" name="Remarks" required></textarea>
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
                    <a href="{{ Request::server('HTTP_REFERER') }}" class="btn btn-default btn-sm">Cancel</a>
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
    <script>
        $(function(){
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



            var currentUserDept = $('#userDept').val();
            $(".approver1-select").select2({
                ajax: {
                    url: '/rs/approver-data/'+currentUserDept,
                    dataType: 'json'
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                matcher: matchCustom,
                placeholder: 'Select Approver'
            });

            $(".approver2-select").select2({
                placeholder: 'Select Approver'
            });
            
            $(".glcode-select").select2({
                dropdownAutoWidth : true,
                placeholder: 'Select GL Code',
                minimumResultsForSearch: -1
            });
            
            var $deptSelect = $(".department-select").select2({
                ajax: {
                    url: '/rs/department-data',
                    dataType: 'json'
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                matcher: matchCustom,
                placeholder: 'Select Department',
//                minimumResultsForSearch: -1
            });

            // $deptSelect.select2('val',"{{ \App\Department::findByName('Materials Group')->ID }}");
            $deptSelect.on('change', function () {
                var $glCode = $('.glcode-select').val("");
                var $approverSelect = $('.approver2-select').val("");

                var chargeType = $chargeType.val();

                var glType = 'issuance';
                if(chargeType=='C') {
                    glType = 'capex';
                }

                var deptID = $('.department-select').select2('data')[0].id;
                $glCode.select2({
                    ajax: {
                        url: '/rs/gl-data/'+glType+'/'+deptID,
                        dataType: 'json'
                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    },
                    matcher: matchCustom,
                    placeholder: 'Select GL Code'
                });

                $approverSelect.select2({
                    ajax: {
                        url: '/rs/approver-data/'+deptID,
                        dataType: 'json'
                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    },
                    matcher: matchCustom,
                    placeholder: 'Select Approver'
                });
            });


            var $glCode = $(".glcode-select").select2({
                placeholder: 'Select GL Code',
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


            $glCode.val("");

//            var deptID = $('#ChargeTo').val();
//            $glCode.select2({
//                ajax: {
//                    url: '/rs/gl-data/issuance/'+deptID,
//                    dataType: 'json'
//                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
//                },
//                matcher: matchCustom,
//                placeholder: 'Select GL Code'
//            });

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