@extends('templates.content',[
    'title'=>'Inventory Log',
    'description'=>'Shows all recent transactions.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Reports','/reports'),
        \App\Classes\Breadcrumb::create('Inventory Log')
    ]
])
@section('title','Inventory Logs')
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

        table.dataTable tbody tr.outbound {
            background-color: #e0e0e0;
            color: #454F59;
        }

        table.dataTable tbody tr.inbound {
            background-color: #90EE90;
            color: #454F59;
        }

    </style>
@endsection
@php
    $v = request()->v;
@endphp
@section('content')
    <div class="card card-danger card-outline flat">
        <div class="card-header card-header-text">
            <div class="col-lg-6 col-md-12"><h3 class="card-title"><strong>Inventory Logs</strong></h3></div>
        </div>
        <div class="card-body">
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
                            {{--<div class="col-lg-5 col-md-12"></div>--}}
                            {{--<div class="col-lg-3 col-md-12 float-right align-right">--}}
                                {{--<div class="input-group float-right align-right">--}}
                                    {{--<a href="/reports/inventory-log/export?date={{ \Carbon\Carbon::today()->format('Ymd') }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-download"></i>&nbsp;Export Today</a>&nbsp;--}}
                                    {{--<a href="#" class="btn btn-sm btn-danger btn-flat" id="customDate"><i class="fa fa-download"></i>&nbsp;Export Custom</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </form>
                    <table id="productsTable" class="table table-responsive-lg dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                        <thead>
                        <tr role="row">
                            <th>Product</th>
                            <th>Log Type</th>
                            <th>Transaction Type</th>
                            <th>Date</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Initial Quantity</th>
                            <th class="text-right">Final Quantity</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Product</th>
                            <th>Log Type</th>
                            <th>Transaction Type</th>
                            <th>Date</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Initial Quantity</th>
                            <th class="text-right">Final Quantity</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @php

                            $inventoryLogs = new \App\InventoryLog();

                            if(request()->has('v')) {
                                $page = request()->v;
                                if($page=="All") {
                                    $inventoryLogs = $inventoryLogs->paginate($inventoryLogs->count())->appends([
                                        's' => request('s'),
                                        'v' => request('v')
                                    ]);
                                } else {
                                    $inventoryLogs = $inventoryLogs->paginate(request()->v)->appends([
                                        's' => request('s'),
                                        'v' => request('v')
                                    ]);
                                }
                            } else {
                                $inventoryLogs = $inventoryLogs->paginate(10)->appends([
                                    's' => request('s')
                                ]);
                            }

                        @endphp
                        @if($inventoryLogs->count()>0)
                            @foreach($inventoryLogs as $inventoryLog)
                                @php
                                    $product = $inventoryLog->getProduct();
                                    $uom = $product->UOM();

                                    if($inventoryLog->Type=='O') {
                                        $marker = "outbound";
                                    } else {
                                        if($inventoryLog->Final - $inventoryLog->Initial < 0) {
                                            $marker = "outbound";
                                        } else {
                                            $marker = "inbound";
                                        }
                                    }


                                @endphp
                                <tr role="row" class="{{ $loop->index % 2 ? "odd":"even" }} {{ $marker }} ">
                                    <td>[{{ $product->Name }}] {{ $product->Description }}</td>
                                    <td>{{ \App\Classes\InventoryLogHelper::parseLogType($inventoryLog->Type) }}</td>
                                    <td>{{ \App\Classes\InventoryLogHelper::parseTransactionType($inventoryLog->TransactionType) }}</td>
                                    <td>{{ $inventoryLog->created_at->format('m/d/Y') }}</td>
                                    <td class="text-right">{{ sprintf('%d %s',($inventoryLog->Quantity), $uom->Abbreviation) }}</td>
                                    <td class="text-right">{{ sprintf('%d %s',($inventoryLog->Initial), $uom->Abbreviation) }}</td>
                                    <td class="text-right">{{ sprintf('%d %s',($inventoryLog->Final), $uom->Abbreviation) }}</td>
                                </tr>
                                <tr id="demo{{$loop->index}}" class="collapse">
                                    <td colspan="100%">
                                        @include('templates.rsitemsub',['data'=>$product])
                                    </td>
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
                    {{ $inventoryLogs->links('templates.pagination.default') }}
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


            $('#customDate').on('click', function() {


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
                        console.log(yStart);
                        var mStart = zDate.getMonth();
                        var dStart = zDate.getDate();

                        var yEnd = zEnd.getFullYear();
                        var mEnd = zEnd.getMonth();
                        var dEnd = zEnd.getDate();

                        var dStart = String.format('{0}{1}{2}', yStart,mStart,dStart);
                        var dEnd = String.format('{0}{1}{2}', yEnd,mEnd,dEnd);

                        window.open('/reports/inventory-log/export?start='+dStart+"&end="+dEnd,'_blank');
                    }
                });


                $('#pckStart').datepicker({
                    format: 'MM dd, yyyy',
                    autoclose: true,
                    endDate: new Date()
                });


                $('#pckEnd').datepicker({
                    format: 'MM dd, yyyy',
                    autoclose: true,
                    endDate: new Date()
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

    </script>
@endsection