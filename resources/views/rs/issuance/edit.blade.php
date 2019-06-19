@extends('templates.content',[
    'title'=>'Edit Issuance Request',
    'description'=>"Update Issuance Request Details",
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Issuance Requests','/issuance-request'),
        \App\Classes\Breadcrumb::create("$data->OrderNumber")
    ]
])
@section('title',"Updating $data->OrderNumber | Issuance Requests")
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <style>
        .entry { display: none; }
        a {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        a:hover {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        .card-title {
            padding-top: 4px;
            height: 27px;
            line-height: 27px;
        }

        .btn-simple {
            border: 1px solid #D7D7D7;
        }

        .badge {
            padding: 5px 5px 5px 5px;
        }

        .uom {
            display : flex;
            align-items : center;
        }
    </style>
@endsection
@section('content')
    <form method="post" id="editIssuanceForm" action="/issuance-request/edit/{{ $data->OrderNumber }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-lg-9 col-md-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-text">
                    <div class="col-lg-12">
                        <div class="row">
                            <h3 class="card-title" style="padding-top: 0; margin-top: 0;">
                                <strong>Updating Issuance Request: </strong> {{ $data->OrderNumber }} &nbsp;
                            </h3>
                        </div>
                    </div>
                </div>
                @if($data->Status!='V')
                    <div class="card-body clearfix">
                        <div class="toolbar">
                            @if(
                                auth()->user()->Person()->ID == $data->Approver1 // check if user is one of the approvers.
                                or
                                auth()->user()->isAdministrator() //admins can overrule anybody.
                            )
                                @if($data->Status=='P')
                                    <a class="btn flat btn-sm btn-simple" id="btnSave">
                                        <span class="fa fa-save"></span>&nbsp;Save
                                    </a>
                                @endif
                                <a href="/issuance-request/view/{{$data->OrderNumber}}" class="btn flat btn-sm btn-simple" style="color: black;" id="btnCancel">
                                    <span class="fa fa-ban pr-1"></span>Cancel
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Department</label><br/>
                                        <span>{{ $data->Department()->Name }}</span>
                                        <input type="hidden" id="Department" value="{{ $data->ChargeTo }}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Approver</label><br/>
                                        <span>{{ \App\Person::where('ID','=',$data->Approver1)->first()->Name() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Charge To</label><br/>
                                        <span>{{ $data->ChargedTo()->Name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Filed By</label><br/>
                                        <span>{{ $data->Requester()->Name() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="mydiv">
                        <div class="col-lg-12">
                            <table id="poTable" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                                <thead>
                                <tr role="row">
                                    <th style="width: 35%;">Item</th>
                                    <th class="text-center">G/L Code</th>
                                    <th class="text-center align-middle" style="width: 20%;">Quantity</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tbody class="productTable">
                                @foreach($data->LineItems() as $lineItem)
                                    @php
                                        $product = \App\Product::where('ID','=',$lineItem->Product)->first();
                                    @endphp
                                    <tr>
                                        <td style="vertical-align: middle;">
                                            <input type="hidden" value="{{ $product->ID }}" name="Product[]">
                                            <input type="hidden" value="{{ $lineItem->ID }}" name="LineItem[]">
                                            [{{ $product->UniqueID }}] {{ $product->Description }}
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <select class="form-control glcode-select flat" name="GLCode[]">
                                                <option></option>
                                                <option value="{{ $lineItem->GLCode }}" selected>[{{ $lineItem->GeneralLedger()->Code }}] {{ $lineItem->GeneralLedger()->Description }}</option>
                                            </select>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <div class="col-md-12 pull-right">
                                                <div class="row">
                                                    <div class="col-md-12 input-group" style="padding-left: 0px;">
                                                        <input 
                                                            style="width: 75%;" 
                                                            class="form-control quantity-input text-right" 
                                                            required 
                                                            placeholder="Max: {!! $product->getAvailableQuantity() !!}" 
                                                            max="{!! $product->getAvailableQuantity() !!}" 
                                                            min="0" 
                                                            name="Quantity[]" 
                                                            type="number" 
                                                            step="{{ $product->UOM()->Type==1?"0.001":"1" }}"
                                                            value="{{ $lineItem->Quantity }}"
                                                        >
                                                        <span style="width: 25%;" class="uom">&nbsp;&nbsp;&nbsp;{{ $product->UOM()->Abbreviation }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Remarks" class="control-label">Remarks</label>
                                        <div class="col-lg-12">
                                            @php
                                                $remarks = json_decode($data->Remarks, true);
                                            @endphp

                                            @if(count($remarks['data'])>0)
                                                @foreach($remarks['data'] as $entry)
                                                    <div class="row">
                                                        [{{ \Carbon\Carbon::parse($entry['time'])->format("M. d, Y | h:i A") }}]
                                                        [{{ \App\User::find($entry['userid'])->Username }}]:
                                                        {{ $entry['message'] }}
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-text">
                    <div class="col-lg-12">
                        <div class="row">
                            <h3 class="card-title" style="padding-top: 0; margin-top: 0;">
                                <strong>Logs</strong>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($data->Logs() as $log)
                        <div class="row">
                            <div class="col-lg-5 col-md-6 col-sm-6">
                                {{ $log->created_at }}
                            </div>
                            <div class="col-lg-7 col-md-6 col-sm-6">
                                {{ \App\Classes\IssuanceHelper::ParseLog($log) }}
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr style="margin-top: 5px; margin-bottom: 5px;"/>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection
@section('scripts')
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript">

        $('#btnSave').on('click', function() {
            $('#editIssuanceForm').submit();
        });



        var deptID = $('#Department').val();

        $('.glcode-select').select2({
            ajax: {
                url: '/rs/gl-data/issuance/'+deptID,
                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            matcher: matchCustom,
            placeholder: 'Select GL Code'
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

    </script>
@endsection