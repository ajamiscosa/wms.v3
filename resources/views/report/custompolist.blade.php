@extends('templates.content',[
    'title'=>'Custom Purchase Order List Report',
    'description'=>'Shows Custom Purchase Order List Report from the system.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Reports','/reports'),
        \App\Classes\Breadcrumb::create('Custom Purchase Order List Report')
    ]
])
@section('title','Custom Purchase Order List Report')

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
    </style>
@endsection
@php
    $v = request()->v;
@endphp
@section('content')

    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
        <div class="card-header card-header-icon">
            <h4 class="card-title" style="display: inline-block">Custom Purchase Order List Report</h4>
        </div>
        <div class="card-body">
            <div id="datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap">
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
                                <a href="/reports/custom-po-list/export" target="_blank" class="btn btn-danger btn-flat mr-2 export-today">
                                    Export Today
                                </a>
                                <button type="button" class="btn btn-danger btn-flat export-custom">
                                    Export Custom
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <table id="supplierTable" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                    <thead>
                    <tr role="row">
                        <th>Vendor ID</th>
                        <th>Vendor Name</th>
                        <th>PO Number</th>
                        <th>Date</th>
                        <th>Ship Via</th>
                        <th class="text-right">PO Total</th>
                        <th>Terms</th>
                        {{--<th>&nbsp;</th>--}}
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Vendor ID</th>
                        <th>Vendor Name</th>
                        <th>PO Number</th>
                        <th>Date</th>
                        <th>Ship Via</th>
                        <th class="text-right">PO Total</th>
                        <th>Terms</th>
                        {{--<th>&nbsp;</th>--}}
                    </tr>
                    </tfoot>
                    <tbody>
                    @php

                        $po = new \App\PurchaseOrder();

                        $poList = $po->orderBy('created_at','desc');

                        $poList = $poList->where('Status','=','A');
                        if(request()->has('v')) {
                            $page = request()->v;
                            if($page=="All") {
                                $poList = $poList->paginate($po->count())->appends([
                                    's' => request('s'),
                                    'v' => request('v')
                                ]);
                            } else {
                                $poList = $poList->paginate(request()->v)->appends([
                                    's' => request('s'),
                                    'v' => request('v')
                                ]);
                            }
                        } else {
                            $poList = $poList->paginate(10)->appends([
                                's' => request('s')
                            ]);
                        }


                    @endphp
                    @if($poList->count()>0)
                        @foreach($poList as $order)
                            @php($supplier = $order->Supplier())
                            @php($term = $order->PaymentTerm()!=null?$order->PaymentTerm()->Description:"")
                            <tr role="row" class="{{ $loop->index % 2 ? "odd":"even" }}">
                                <td><a class="alert-link" href="/vendor/view/{{ $supplier->Code }}">{{ $supplier->Code }}</a></td>
                                <td>{{ $supplier->Name }}</td>
                                <td>{{ $order->OrderNumber }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->OrderDate)->format('d/m/Y') }}</td>
                                <td>{{ $order->getShipVia() }}</td>
                                <td class="text-right">{{ $order->Total }}</td>
                                <td>{{ $term }}</td>
                                {{--<td class="text-right"><a role="button" class="btn btn-sm btn-danger btn-flat" href="/vendor/{{ $supplier->Code }}/product">View Products</a></td>--}}
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
            <div class="dataTables_paginate paging_full_numbers float-right">
                {{ $poList->links('templates.pagination.default') }}
            </div>
        </div>
        <!-- /.card-body -->
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
                            "<input readonly type='text' class='form-control datepicker' data-date-format='MM dd, yyyy' id='pckStart' name='Start' required>" +
                            "to"+
                            "<input readonly type='text' class='form-control datepicker' data-date-format='MM dd, yyyy' id='pckEnd' name='End' required>" +
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


                                var dateStart = new Date();
                                var dateEnd = new Date();

                                console.log(pckStart.val()==="");
                                if(pckStart.val()!=="") {
                                    dateStart = Date.parse(pckStart.val());
                                }
                                if(pckEnd.val()!=="") {
                                    dateEnd = Date.parse(pckEnd.val());
                                }

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

                                window.open('/reports/custom-po-list/export?start='+dStart+"&end="+dEnd,'_blank');
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