@extends('templates.content',[
    'title'=>'Purchase Orders Report',
    'description'=>'Shows report on purchase order transactions.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Reports','/reports'),
        \App\Classes\Breadcrumb::create('Purchase Orders Report')
    ]
])
@section('title','Receiving Report')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <style>
        a {
            color: #000;
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
        .something-semantic td {
            display: table-cell;
            /*text-align: center;*/
            vertical-align: middle;
        }
    </style>
@endsection
@php
    $v = request()->v;
@endphp
@section('content')
    <div class="card card-danger card-outline flat">
        <div class="card-header card-header-text">
            <div class="col-lg-6 col-md-12"><h3 class="card-title"><strong>Purchase Orders Logs</strong></h3></div>
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
                                    <a class="btn btn-danger btn-flat issuance-custom" href="#">Export Custom</a>
                                </div>
                                <div class="btn-group float-right pr-2">
                                    <a class="btn btn-danger btn-flat" href="/reports/purchase-order-log/export">Export Today</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="productsTable" class="table table-responsive-lg dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                        <thead>
                        <tr role="row">
                            <th>Date</th>
                            <th>G/L Account</th>
                            <th>PO #</th>
                            <th>Description</th>
                            <th>Vendor ID</th>
                            <th>Vendor Name</th>
                            <th class="text-right">Quantity</th>
                            <th>U/M ID</th>
                            <th>Item ID</th>
                            <th class="text-right">Unit Price</th>
                            <th>Job ID</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">Accounts Payable Account</th>
                            <th>Ship Via</th>
                            <th>Displayed Terms</th>
                            <th>Days</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Date</th>
                            <th>G/L Account</th>
                            <th>PO #</th>
                            <th>Description</th>
                            <th>Vendor ID</th>
                            <th>Vendor Name</th>
                            <th class="text-right">Quantity</th>
                            <th>U/M ID</th>
                            <th>Item ID</th>
                            <th class="text-right">Unit Price</th>
                            <th>Job ID</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">Accounts Payable Account</th>
                            <th>Ship Via</th>
                            <th>Displayed Terms</th>
                            <th>Days</th>
                            <th>&nbsp;</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @php
                            $purchaseOrder = new \App\PurchaseOrder();
                            $purchaseOrder = $purchaseOrder->where('Status','=','A');
                            if(request()->has('v')) {
                                $page = request()->v;
                                if($page=="All") {
                                    $purchaseOrders = $purchaseOrder->paginate($purchaseOrders->count())->appends([
                                        's' => request('s'),
                                        'v' => request('v')
                                    ]);
                                } else {
                                    $purchaseOrders = $purchaseOrder->paginate(request()->v)->appends([
                                        's' => request('s'),
                                        'v' => request('v')
                                    ]);
                                }
                            } else {
                                $purchaseOrders = $purchaseOrder->paginate(10)->appends([
                                    's' => request('s')
                                ]);
                            }
                        @endphp
                        @if($purchaseOrders->count()>0)
                            @foreach($purchaseOrders as $po)

                                @php($previous = null)
                                @php($counter = 1)
                                @foreach($po->OrderItems() as $orderItem)
                                    @php($lineItem = $orderItem->LineItem())
                                    @php($product = $lineItem->Product())
                                    @php($quote = $orderItem->SelectedQuote())
                                    @php($supplier = $quote->Supplier())
                                    @php($uom = $product->UOM())
                                    @php($pr = $po->Requisition())
                                    @php($term = $po->PaymentTerm())
                                    @if($previous!=$po)
                                        @php($counter = 1)
                                        @php($previous = $po)
                                    @endif
                                    <tr>
                                        <td>{{ $po->OrderDate->format('d/m/Y') }}</td>
                                        <td>{{ $product->getGeneralLedger()->Code }}</td>
                                        <td>{{ $po->OrderNumber }}</td>
                                        <td>{{ $product->Description }}</td>
                                        <td>{{ $supplier->Code }}</td>
                                        <td>{{ $supplier->Name }}</td>
                                        <td>{{ $lineItem->Quantity }}</td>
                                        <td>{{ $product->UOM()->Abbreviation }}</td>
                                        <td>{{ $product->UniqueID }}</td>
                                        <td class="text-right">{{ $product->getLastUnitCost() }}</td>
                                        <td class="text-right">&nbsp;</td>
                                        <td class="text-right">{{ number_format($product->getLastUnitCost() * $lineItem->Quantity,2,'.',',') }}</td>
                                        <td>{{ $po->APAccount()->Code }}</td>
                                        <td>{{ sprintf("%s/%s", $pr, 'STOCKS') }}</td>
                                        <td>{{ $term->Description }}</td>
                                        <td>{{ $supplier->Due }}</td>
                                    </tr>
                                @endforeach
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
                <div class="dataTables_paginate paging_full_numbers float-right">
                    {{ $purchaseOrders->links('templates.pagination.default') }}
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
                    "<input type='text' class='form-control datepicker' data-date-format='MM dd, yyyy' id='pckStart' name='Start'>" +
                    "to"+
                    "<input type='text' class='form-control datepicker' data-date-format='MM dd, yyyy' id='pckEnd' name='End'>" +
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

                        window.open('/reports/purchase-order-log/export?start='+dStart+"&end="+dEnd,'_blank');
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