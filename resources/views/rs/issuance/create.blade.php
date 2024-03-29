@extends('templates.content',[
    'title'=>'Issuance Request',
    'description'=>'New Issuance Request',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Requisition','/rs'),
        \App\Classes\Breadcrumb::create('Issuance Request','/issuance-request'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title','New Issuance Request')
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
            padding: auto;
        }
        input[type='text'].datepicker {
            height: 38px;
        }
        input::-webkit-input-placeholder {
            font-size: 0.8em;
            line-height: 3;
            text-align: right;
        }

        span#select2-glcd-container {
            font-size: 0.9em;
        }

    </style>
@endsection
@section('content')
<div class="col-lg-12 col-md-12">
<div class="card card-danger card-outline flat"> <!--  collapsed-card-->
    <div class="card-header card-header-text">
        <h3 class="card-title">
            <strong>Issuance Request #</strong>
        </h3>
    </div>
    <form action="/issuance-request/store" method="post" id="issuanceRequestForm">
        <input type="hidden" name="Type" value="IR">
        {{csrf_field()}}
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="GLCode" class="control-label">Charge Type</label>
                        <select class="form-control charge-type-select" name="ChargeType" style="width: 100%;">
                            <option></option>
                            <option value="S" selected>INVENTORY</option>
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
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label ">Charged To Department</label>
                        <br class="input-lining"/>
                        <select class="form-control department-select" name="ChargeTo" required style="width: 100%;">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                {{--<div class="col-md-6">--}}
                    {{--<div class="form-group">--}}
                        {{--<label class="control-label ">Date Required</label>--}}
                        {{--<input type="text" class="form-control datepicker" id="DateRequired" name="DateRequired" value="{{ \Carbon\Carbon::today()->addDays(7)->format('F d, Y') }}">--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label ">Department</label>
                        <div class="form-group" style="border: 1px solid #AAA;">
                            <span style="line-height: 36px;">&nbsp;&nbsp;{{ auth()->user()->Department()->Name }}</span>
                            <input type="hidden" name="UserDept" id="userDept" value="{{auth()->user()->Department()->ID}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label ">Approver</label>
                        <div class="form-group" style="border: 1px solid #AAA;">
                            <select class="form-control approver1-select" name="Approver1" required style="width: 100%;">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="Purpose" class="control-label">Purpose</label>
                        <textarea class="form-control flat" style="resize: none;" rows="3" name="Purpose" required></textarea>
                    </div>
                </div>
            </div> <? /* row */?>
        
             
            {{--<div class="row">
                <div class="col-md-6">
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
                </div>
            </div> --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive-md">
                        <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">GL Code</th>
                                    <th scope="col">
                                        <label class="float-right">
                                        Quantity
                                        </label>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $item)
                                    @php
                                        $product = \App\Product::where('ID','=',$item)->first();
                                    @endphp
                                        <tr>
                                            <th scope="row" class="w-25">
                                                <input type="hidden" value="{{ $product->ID }}" name="Product[]">
                                                [{{ $product->UniqueID }}] {{ $product->Description }}
                                            </th>
                                            
                                            <td scope="col" class="w-auto">
                                                <select id="glcd" style="width:100%; font-size: 0.9em" class="form-control glcode-select" name="GLCode[]" required>
                                                    <option></option>
                                                </select>
                                            </td>
                                            <td scope="col" class="w-auto">
                                                <span class="float-right" style="margin:10px; font-size: 0.6em;">
                                                    {{ $product->UOM()->Abbreviation }}
                                                </span>
                                                <input 
                                                    style="width: 100px;" class="form-control float-right" 
                                                    placeholder="Max: {!! $product->getAvailableQuantity() !!}" 
                                                    max="{!! $product->getAvailableQuantity() !!}"
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
                </div>
            </div> <? //row ?>

            <hr class="pt-0 mt-0">

            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Remarks" class="control-label">Remarks</label>
                                <textarea class="form-control flat" style="resize: none;" rows="3" name="Remarks" id="Remarks"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div> <? // card-body ?>
    
        <div class="card-footer">
            <div class="row float-right">
                <div class="col-md-12">
                    {{-- <button id="btnSave" type="submit" class="btn flat btn-danger btn-sm">Save</button> --}}
                    <input type="submit" class="btn flat btn-danger btn-md" value="Save" id="btnSave">
                    <a href="/rs" class="btn btn-default btn-sm">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(function(){
            var $datepicker = $('#DateRequired').datepicker({
                format: "MM dd, yyyy"
            });
            
            var $chargeType = $(".charge-type-select").select2({
                placeholder: 'Select Charge Type',
                minimumResultsForSearch: -1
            });
            
            //get chargetype id 
            var cType = $('.charge-type-select').change(function () {
                $(this).val();
                console.log($(this).val());
            });
            
            // get dept id
            var cDept = $('.department-select').change(function () {
                $(this).val();
                console.log($(this).val());
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

            var chargeType = $chargeType.val();
            var glType = 'issuance';
            if(chargeType=='C') {
                glType = 'capex';
            }
            
            var $glCode = $(".glcode-select").select2({
                dropdownAutoWidth : true,
                placeholder: 'Select GL Code',
                minimumResultsForSearch: -1,
                // ajax: {
                //     url: '/rs/gl-data/'+glType+'/'+{{auth()->user()->Department()->ID}},
                //     dataType: 'json'
                //     // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                // },
                // matcher: matchCustom,
            });

            $(document).on('change', function () {
                //var $glCode = $('.glcode-select').val();
                var $approverSelect = $('.approver2-select').val("");



                var deptID = $('.department-select').select2('data')[0].id;
                $glCode.select2({
                    ajax: {
                        url: '/rs/gl-data/'+glType+'/'+deptID,
                        // url: '/rs/gl-data/'+glType+'/'+{{auth()->user()->Department()->ID}},
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

            $(document).on('click','#btnSave',function(e){
                e.preventDefault();
                if((typeof($('#issuanceRequestForm')[0].checkValidity) == "function" ) && $('#issuanceRequestForm')[0].checkValidity()) { // force validation. hax. :D
                    Swal.fire({
                        title: 'Issuance Request',
                        html:
                        "<html>Are you sure you want to proceed?<br/><br/>"+
                        "</html>",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#83B74B',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.value) {
                            console.log(result.value);
                            $('#issuanceRequestForm').submit();
                        } else {
                            
                        }
                    });
                }
                else {
                    Swal.fire({
                        html: false,
                        title: 'Issuance Request',
                        text: "Please fill up all fields.",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#83B74B',
                        confirmButtonText: 'OK',
                    });
                }
            });

        })
    </script>
@endsection