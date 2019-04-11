@extends('templates.content',[
    'title'=>'Inventory Report',
    'description'=>'Shows list of all inventory balances.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Reports','/reports'),
        \App\Classes\Breadcrumb::create('Inventory Report')
    ]
])
@section('title','Inventory Balance Report')
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
        .vr {

            border:         none;
            border-left:    1px solid hsla(200, 10%, 50%,100);
            height:         100%;
            width:          1px;
        }

    </style>
@endsection
@php
    $v = request()->v;
@endphp
@section('content')
    <div class="card card-danger card-outline flat">
        <div class="card-header card-header-text xwrapper">
            <h3 class="card-title">
                <strong>Inventory Report</strong>
            </h3>
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
                            <div class="col-lg-5 col-md-12"></div>
                            <div class="col-lg-3 col-md-12">
                                <div class="input-group float-right">
                                    <a href="/reports/inventory-balance/export" target="_blank" role="button" class="btn btn-danger btn-flat">
                                        Export
                                    </a>
                                    &nbsp;
                                    &nbsp;
                                    <input type="search" id="txtSearch" name="s" class="form-control float-right" value="{{ request()->s }}"/>
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="productTable" class="table table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                                <thead>
                                <tr role="row">
                                    <th>ID</th>
                                    {{--<th>Name</th>--}}
                                    <th>Description</th>
                                    {{--<th>Category</th>--}}
                                    {{--<th>Product Line</th>--}}
                                    <th class="text-right">On Hand</th>
                                    <th class="text-right">Available</th>
                                    <th class="text-right">Reserved</th>
                                    <th class="text-right">Incoming</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    {{--<th>Name</th>--}}
                                    <th>Description</th>
                                    {{--<th>Category</th>--}}
                                    {{--<th>Product Line</th>--}}
                                    <th class="text-right">On Hand</th>
                                    <th class="text-right">Available</th>
                                    <th class="text-right">Reserved</th>
                                    <th class="text-right">Incoming</th>
                                </tr>
                                </tfoot>
                                <tbody>

                                @php

                                    $products = new \App\Product();


                                    if(request()->has('s')) {
                                        $products = $products->
                                        where('Name','like','%'.request('s').'%')->
                                        orWhere('Description','like','%'.request('s').'%')->
                                        orWhere('UniqueID','like','%'.request('s').'%');
                                    }


                                    if(request()->has('v')) {
                                        $page = request()->v;
                                        if($page=="All") {
                                            $products = $products->paginate($products->count())->appends([
                                                's' => request('s'),
                                                'v' => request('v')
                                            ]);
                                        } else {
                                            $products = $products->paginate(request()->v)->appends([
                                                's' => request('s'),
                                                'v' => request('v')
                                            ]);
                                        }
                                    } else {
                                        $products = $products->paginate(10)->appends([
                                            's' => request('s')
                                        ]);
                                    }

                                @endphp
                                @if($products->count()>0)
                                    @foreach($products as $product)
                                        @php($uom = $product->UOM()!=null?$product->UOM()->Abbreviation:"")
                                        <tr role="row" class="{{ $loop->index % 2 ? "odd":"even" }}">
                                            <td><a href="/product/view/{{ $product->UniqueID }}">{{ $product->UniqueID }}</a></td>
                                            {{--<td>{{ $product->Name }}</td>--}}
                                            <td>{{ $product->Description }}</td>
                                            {{--<td>{{ $product->Category()->Identifier }}</td>--}}
                                            {{--<td>{{ $product->ProductLine()->Identifier }}</td>--}}
                                            <td class="text-right">{{ sprintf('%d %s',($product->Quantity), $uom) }}</td>
                                            <td class="text-right">{{ sprintf('%d %s',($product->getAvailableQuantity()), $uom) }}</td>
                                            <td class="text-right">{{ sprintf('%d %s',($product->getReservedQuantity()), $uom) }}</td>
                                            <td class="text-right">{{ sprintf('%d %s',($product->getIncomingQuantity()), $uom) }}</td>
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
                        {{ $products->links('templates.pagination.default') }}
                    </div>
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