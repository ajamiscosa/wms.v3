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
                                    <a href="/reports/pr-status/export" target="_blank" class="btn btn-danger btn-flat mr-2 export-today">
                                        Export All
                                    </a>
                                    <button type="button" class="btn btn-danger btn-flat export-custom">
                                        Export Custom
                                    </button>
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
                            <th>PR to PO</th>
                            <th>PR to RR</th>
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
                            <th>PR to PO</th>
                            <th>PR to RR</th>
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

                                        @if($orderItem = $lineItem->OrderItem())
                                            @if($po = $orderItem->PurchaseOrder())
                                                @if($po->Status != 'D')
                                                    <td>{{ $po->OrderNumber }}</td>
                                                    <td>{{ $po->OrderDate->format('m/d/Y') }}</td>
                                                    <td>{{ $po->Supplier()->Name }}</td>
                                                    <td class="text-right">{{ $orderItem->SelectedQuote()->Amount }}</td>
                                                    <td class="text-right">{{ number_format($orderItem->SelectedQuote()->Amount * $lineItem->Quantity,2,'.',',') }}</td>
                                                    @forelse($orderItem->getReceivingReceipts() as $rr)
                                                        @php
                                                            $purchaseOrder = $rr->PurchaseOrder();
                                                            $quote = $orderItem->SelectedQuote();
                                                            $supplier = $quote->Supplier();
                                                        @endphp
                                                        
                                                        @if ($loop->first)
                                                            <td>{{ $rr->OrderNumber }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($rr->Received)->format('m/d/Y') }}</td>
                                                            <td class="text-center">{{ \Carbon\Carbon::parse($po->OrderDate)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                                            <td class="text-center">{{ \Carbon\Carbon::parse($rr->Received)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                                        </tr>
                                                        @else
                                                        <tr>
                                                            <td>{{ $request->OrderNumber }}</td>
                                                            <td>{{ $request->Department()->Name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($request->Date)->format('m/d/Y') }}</td>
                                                            <td>{{ $product->UniqueID }}</td>
                                                            <td>{{ $product->getGeneralLedger()->Code }}</td>
                                                            <td class="text-right">{{ $lineItem->Quantity }}</td>
                                                            <td>{{ $product->UOM()->Abbreviation }}</td>
                                                            <td>{{ $product->Description }}</td>
                                                            <td>{{ $po->OrderNumber }}</td>
                                                            <td>{{ $po->OrderDate->format('m/d/Y') }}</td>
                                                            <td>{{ $po->Supplier()->Name }}</td>
                                                            <td class="text-right">{{ $orderItem->SelectedQuote()->Amount }}</td>
                                                            <td class="text-right">{{ number_format($orderItem->SelectedQuote()->Amount * $lineItem->Quantity,2,'.',',') }}</td>
                                                            
                                                            <td>{{ $rr->OrderNumber }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($rr->Received)->format('m/d/Y') }}</td>
                                                            <td class="text-center">{{ \Carbon\Carbon::parse($po->OrderDate)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                                            <td class="text-center">{{ \Carbon\Carbon::parse($rr->Received)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                                        </tr>
                                                        @endif
                                                    @empty
                                                        <td colspan="2"></td>
                                                        <td class="text-center">{{ \Carbon\Carbon::parse($po->OrderDate)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                                        <td></td>
                                                    @endforelse
                                                @else
                                                    <td colspan="9"></td>
                                                @endif
                                            @else
                                                <td colspan="9"></td>
                                            @endif
                                        @else
                                        <td colspan="9"></td>
                                        @endif


                                        @php($count++)
                                    </tr>
                                    @else
                                    <td colspan="14"></td>
                                    @endif
                                @empty
                                    <td colspan="14"></td>
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


            $('.export-custom').on('click', function() {


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

                        dStart = String.format('{0}{1}{2}', yStart,zeroFill(mStart+1,2),zeroFill(dStart,2));
                        dEnd = String.format('{0}{1}{2}', yEnd,zeroFill(mEnd+1,2),zeroFill(dEnd, 2));

                        window.open('/reports/pr-status/export?start='+dStart+"&end="+dEnd,'_blank');
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