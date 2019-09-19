@extends('templates.content',[
    'title'=>'Issuance Report',
    'description'=>'Shows list of all issuance transactions.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Reports','/reports'),
        \App\Classes\Breadcrumb::create('Issuance Report')
    ]
])
@section('title','Issuance Report')
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
    <div class="card card-danger card-outline flat">
        <div class="card-header card-header-text">
            <div class="col-lg-6 col-md-12"><h3 class="card-title"><strong>Issuance Logs</strong></h3></div>
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
                                        <a class="dropdown-item issuance-custom" rel="PHP">PHP</a>
                                        <a class="dropdown-item issuance-custom" rel="USD">USD</a>
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
                    <table id="productsTable" class="table table-responsive-lg dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                        <thead>
                        <tr role="row">
                            <th>Item ID</th>
                            <th>Reference</th>
                            <th>Date</th>
                            <th class="text-center">Distribution #</th>
                            <th class="text-right">G/L Source Account</th>
                            <th class="text-right">Quantity</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Item ID</th>
                            <th>Reference</th>
                            <th>Date</th>
                            <th class="text-center">Distribution #</th>
                            <th class="text-right">G/L Source Account</th>
                            <th class="text-right">Quantity</th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @php

                            $issuanceReceipts = new \App\IssuanceReceipt();

                            if(request()->has('v')) {
                                $page = request()->v;
                                if($page=="All") {
                                    $issuanceReceipts = $issuanceReceipts->paginate($issuanceReceipts->count())->appends([
                                        's' => request('s'),
                                        'v' => request('v')
                                    ]);
                                } else {
                                    $issuanceReceipts = $issuanceReceipts->paginate(request()->v)->appends([
                                        's' => request('s'),
                                        'v' => request('v')
                                    ]);
                                }
                            } else {
                                $issuanceReceipts = $issuanceReceipts->paginate(10)->appends([
                                    's' => request('s')
                                ]);
                            }

                        @endphp
                        @if($issuanceReceipts->count()>0)
                            @foreach($issuanceReceipts as $receipt)
                                @php
                                    $product = $receipt->getLineItem()->Product();
                                    $uom = $product->UOM();

                                @endphp
                                <tr role="row" class="{{ $loop->index % 2 ? "odd":"even" }}">
                                    <td>{{ $product->UniqueID }}</td>
                                    <td>{{ $receipt->OrderNumber }}</td>
                                    <td>{{ \Carbon\Carbon::parse($receipt->Received)->format('m/d/Y') }}</td>
                                    {{-- <td class="text-center">{{ $receipt->Series }}</td> --}}
                                    <td class="text-center">1</td> {{-- // 1 daw to sabi ni Zarah. Sept 6 2019 --}}
                                    <td class="text-right">{{ $receipt->getLineItem()->GeneralLedger()->Code }}</td>
                                    <td class="text-right">{{ $receipt->Quantity }}</td>
                                    <td class="text-right">
                                        <a role="button" class="btn btn-default btn-sm mb-0 mt-0 downloadrrform" rel="{{ $receipt->OrderNumber }}"><i class="fa fa-download"></i>&nbsp;IS Form</a>
                                        {{-- <a href="/issuance-request/{{ $receipt->OrderNumber }}/download" class="btn btn-sm btn-default"><i class="fa fa-download"></i>&nbsp;IS Form</a>&nbsp; --}}
                                    </td>
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
                    {{ $issuanceReceipts->links('templates.pagination.default') }}
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
    
    
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/html2canvas.min.js') }}"></script>
    <script src="{{ asset('js/jspdf.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.downloadrrform').on('click', function(){
                var rr = $(this).attr('rel');
                $.ajax({
                    url: "/issuance-request/"+rr+"/download",
                    cache: false,
                    success: function(content){
//                        var win = window.open("", "Title",
//                            "toolbar=no," +
//                            "location=no," +
//                            "directories=no," +
//                            "status=no," +
//                            "menubar=no," +
//                            "scrollbars=yes," +
//                            "resizable=yes," +
//                            "width=765," +
//                            "height=990,");
//                        win.document.body.innerHTML = content;
                        var win = PopupCenter("", "Print Preview", 850,768);
                        win.document.body.innerHTML = content;
//
                        var $content = win.document.querySelector('#capture');

                        html2canvas($content,{
                            onrendered: function (canvas) {
                                win.document.body.innerHTML = "<html><head><title>"+rr+"</title><link rel='stylesheet' href='{{asset('css/custom.css')}}'/><link rel='stylesheet' href='{{asset('css/fontawesome-all.min.css')}}'/></head><a role='button' onclick='window.print(); return false;' class='float'><i class='fa fa-print my-float'></i></a></html>";
                                win.document.body.appendChild(canvas);
//                                var imgData = canvas.toDataURL(
//                                    'image/png');
//                                var doc = new jsPDF('p', 'in', [8.5, 11]);
//                                doc.addImage(imgData, 'PNG', 0, 0);
//                                doc.save(rr+'.pdf');
                            }
                        });

                    }
                });
            });
        });



        function PopupCenter(url, title, w, h) {
            // Fixes dual-screen position                         Most browsers      Firefox
            var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
            var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

            var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
            var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

            var systemZoom = width / window.screen.availWidth;
            var left = (width - w) / 2 / systemZoom + dualScreenLeft
            var top = (height - h) / 2 / systemZoom + dualScreenTop
            var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w / systemZoom + ', height=' + h / systemZoom + ', top=' + top + ', left=' + left);

            // Puts focus on the newWindow
            if (window.focus) newWindow.focus();
            return newWindow;
        }
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


                var curr = $(this).attr('rel');
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

                        window.open('/reports/issuance-log/export?start='+dStart+"&end="+dEnd+"&curr="+curr,'_blank');
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