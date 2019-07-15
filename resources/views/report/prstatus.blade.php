@extends('templates.content',[
    'title'=>'Purchase Request Status',
    'description'=>'Shows current progression of Purchase Requests.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Reports','/reports'),
        \App\Classes\Breadcrumb::create('Purchase Request Status')
    ]
])
@section('title','Purchase Request Status')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <style>
        a {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        a:hover {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        .xwrapper {
            display : flex;
            align-items : center;
        }
        th, td { white-space: nowrap; }
    </style>
@endsection
@php
    $v = request()->v;
@endphp
@section('content')
    <div class="card card-danger card-outline flat">
        <div class="card-header card-header-text">
            <div class="col-lg-6 col-md-12"><h3 class="card-title"><strong>Purchase Request Status</strong></h3></div>
        </div>
        <div class="card-body pt-2">
            <div class="material-datatables">
                <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                    <form method="get" id="frmParams">
                        <div class="row">
                            <div class="col-lg-4 col-md 12 align-middle" style="display: inline-flex;">
                                <span class="xwrapper">
                                    Show
                                </span>
                                <span class=" ml-2 pr-2">
                                    <select id="selPerPage" class="form-control" name="v" style="width: 100px;">
                                        <option></option>
                                        <option value="10" {{ (!$v or $v==10)?"selected":"" }}>10</option>
                                        <option value="25" {{ $v==25?"selected":"" }}>25</option>
                                        <option value="50" {{ $v==50?"selected":"" }}>50</option>
                                        <option value="All" {{ $v=="All"?"selected":"" }}>All</option>
                                    </select>
                                </span>
                                <span class="xwrapper">
                                    Entries
                                </span>
                            </div>
                            <div class="col-lg-8 col-md-12">
                                <div class="btn-group float-right">
                                    <button type="button" class="btn btn-danger dropdown-toggle btn-flat" data-toggle="dropdown" aria-expanded="false">
                                        Export Custom
                                        <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-112px, 38px, 0px);">
                                        <a class="dropdown-item issuance-custom" href="#PHP">PHP</a>
                                        <a class="dropdown-item issuance-custom" href="#USD">USD</a>
                                    </div>
                                </div>
                                <div class="btn-group float-right pr-2">
                                    <button type="button" class="btn btn-danger dropdown-toggle btn-flat" data-toggle="dropdown" aria-expanded="false">
                                        Export Today
                                        <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-112px, 38px, 0px);">
                                        <a class="dropdown-item" href="/reports/issuance-log/export?date={{ \Carbon\Carbon::today()->format('Ymd') }}&curr=PHP">PHP</a>
                                        <a class="dropdown-item" href="/reports/issuance-log/export?date={{ \Carbon\Carbon::today()->format('Ymd') }}&curr=USD">USD</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div style="overflow-x:auto !important;">
                    <table id="productsTable" class="table table-responsive dataTable dtr-inline nowrap" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                        <thead>
                        <tr role="row">
                            <th>PR #</th>
                            <th>Department</th>
                            <th>PR Date</th>
                            <th>Item ID</th>
                            <th>G/L Account</th>
                            <th class="text-right">Quantity</th>
                            <th>Unit</th>
                            <th>Description</th>
                            <th>PO #</th>
                            <th>PO Date</th>
                            <th>Vendor</th>
                            <th class="text-right">Unit Cost</th>
                            <th class="text-right">PO Amount</th>
                            <th>RR No.</th>
                            <th>RR Date</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>PR #</th>
                            <th>Department</th>
                            <th>PR Date</th>
                            <th>Item ID</th>
                            <th>G/L Account</th>
                            <th class="text-right">Quantity</th>
                            <th>Unit</th>
                            <th>Description</th>
                            <th>PO #</th>
                            <th>PO Date</th>
                            <th>Vendor</th>
                            <th class="text-right">Unit Cost</th>
                            <th class="text-right">PO Amount</th>
                            <th>RR No.</th>
                            <th>RR Date</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @php

                            $pr = new \App\Requisition();
                            $pr = $pr->where('Type','=','PR');
                            if(request()->has('v')) {
                                $page = request()->v;
                                if($page=="All") {
                                    $pr = $pr->paginate($pr->count())->appends([
                                        's' => request('s'),
                                        'v' => request('v')
                                    ]);
                                } else {
                                    $pr = $pr->paginate(request()->v)->appends([
                                        's' => request('s'),
                                        'v' => request('v')
                                    ]);
                                }
                            } else {
                                $pr = $pr->paginate(10)->appends([
                                    's' => request('s')
                                ]);
                            }

                        @endphp
                        @if($pr->count()>0)
                            @foreach($pr as $request)
                                <tr>
                                    <td>{{ $request->OrderNumber }}</td>
                                    <td>{{ $request->Department()->Name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($request->Date)->format('m/d/Y') }}</td>
                                    @php($count=0)
                                @forelse($request->LineItems() as $lineItem)
                                    @if($lineItem)
                                        @php
                                            // $lineItem = $orderItem->LineItem();
                                            $product = $lineItem->Product();
                                        @endphp
                                        @if($count==0)
                                            <td>{{ $product->UniqueID }}</td>
                                            <td>{{ $product->getGeneralLedger()->Code }}</td>
                                            <td class="text-right">{{ $lineItem->Quantity }}</td>
                                            <td>{{ $product->UOM()->Abbreviation }}</td>
                                            <td>{{ $product->Description }}</td>
                                        @else
                                            <td colspan="3"></td>
                                            <td>{{ $product->UniqueID }}</td>
                                            <td>{{ $product->getGeneralLedger()->Code }}</td>
                                            <td class="text-right">{{ $lineItem->Quantity }}</td>
                                            <td>{{ $product->UOM()->Abbreviation }}</td>
                                            <td>{{ $product->Description }}</td>
                                        @endif

                                        @php($count++)
                                        @forelse($request->OrderItems() as $orderItem)
                                            @if($orderItem)
                                                @if($po = $orderItem->PurchaseOrder())
                                                    @if($po->Status != 'D')
                                                        <td>{{ $po->OrderNumber }}</td>
                                                        <td>{{ $po->OrderDate->format('m/d/Y') }}</td>
                                                        <td>{{ $po->Supplier()->Name }}</td>
                                                        <td class="text-right">{{ $orderItem->SelectedQuote()->Amount }}</td>
                                                        <td class="text-right">{{ $po->Total }}</td>
                                                        @forelse($orderItem->getReceivingReceipts() as $rr)
                                                            @php
                                                                $purchaseOrder = $rr->PurchaseOrder();
                                                                $quote = $orderItem->SelectedQuote();
                                                                $supplier = $quote->Supplier();
                                                            @endphp
                                                            
                                                            @if ($loop->first)
                                                                <td>{{ $rr->OrderNumber }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($rr->Received)->format('m/d/Y') }}</td>
                                                            </tr>
                                                            @else
                                                            <tr>
                                                                <td colspan="13"></td>
                                                                <td>{{ $rr->OrderNumber }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($rr->Received)->format('m/d/Y') }}</td>
                                                            </tr>
                                                            @endif
                                                        @empty
                                                            <td colspan="2"></td>
                                                        @endforelse
                                                    @else
                                                        <td colspan="7"></td>
                                                    @endif
                                                @else
                                                    <td colspan="7"></td>
                                                @endif
                                            @else
                                            <td colspan="7"></td>
                                            @endif
                                        @empty
                                            <td colspan="7"></td>
                                        @endforelse
                                    </tr>
                                    @else
                                    <td colspan="12"></td>
                                    @endif
                                @empty
                                    <td colspan="12"></td>
                                @endforelse
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="100%" style="text-align: center; vertical-align: middle;">
                                    No Data Available
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="dataTables_paginate paging_full_numbers float-right">
                    {{ $pr->links('templates.pagination.default') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script>
        $(function () {
            var selected = [];

            var perPage = $('#selPerPage').select2({
                width: '100%',
                placeholder: "Select Filter",
                minimumResultsForSearch: -1
            });


            perPage.on('change', function(){
                $('#frmParams').submit();
            });


            $('.issuance-custom').on('click', function() {


                swal({
                    html: true,
                    title: 'Select Range',
                    text:
                    "<html>Please select the date range below:<br/><br/>" +
                    "<input readonly type='text' class='form-control datepicker' data-date-format='MM dd, yyyy' id='pckStart' name='Start'>" +
                    "to"+
                    "<input readonly type='text' class='form-control datepicker' data-date-format='MM dd, yyyy' id='pckEnd' name='End'>" +
                    "</html>",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }, function(x){
                    if(x) {
                        var pckStart = $('#pckStart');
                        var pckEnd = $('#pckEnd');

                        var dateStart = Date.parse(pckStart.val());
                        var dateEnd = Date.parse(pckEnd.val());

                        var zDate = new Date(dateStart);
                        var zEnd = new Date(dateEnd);

                        var yStart = zDate.getFullYear();
                        var mStart = zDate.getMonth();
                        var dStart = zDate.getDate();

                        var yEnd = zEnd.getFullYear();
                        var mEnd = zEnd.getMonth();
                        var dEnd = zEnd.getDate();

                        dStart = String.format('{0}{1}{2}', yStart,mStart+1,zeroFill(dStart,2));
                        dEnd = String.format('{0}{1}{2}', yEnd,mEnd+1,zeroFill(dEnd, 2));

                        window.open('/reports/issuance-log/export?start='+dStart+"&end="+dEnd,'_blank');
                    }
                });


                $('#pckStart').datepicker({
                    format: 'MM dd, yyyy',
                    autoclose: true,
                    endDate: new Date()
                });

                $('#pckStart').on('changeDate', function(){
                    $('#pckEnd').datepicker('remove');
                    $('#pckEnd').datepicker({
                        format: 'MM dd, yyyy',
                        autoclose: true,
                        startDate: new Date($('#pckStart').val()),
                        endDate: new Date()
                    });
                });

            });


            //==============================================================================================================
            // DO NOT DELETE
            // THIS THE ENDING TAG.
            // KEEP SCRIPTS ABOVE THIS.
            //==============================================================================================================
        });

        if (!String.format) {
            String.format = function(format) {
                var args = Array.prototype.slice.call(arguments, 1);
                return format.replace(/{(\d+)}/g, function(match, number) {
                    return typeof args[number] != 'undefined'
                        ? args[number]
                        : match
                        ;
                });
            };
        }

        function zeroFill( number, width )
        {
            width -= number.toString().length;
            if ( width > 0 )
            {
                return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
            }
            return number + ""; // always return a string
        }

    </script>
@endsection