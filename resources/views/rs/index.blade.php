@extends('templates.content',[
    'title'=>'Requisition',
    'description'=>'Requisition',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Requisition')
    ]
])
@section('title','New Requisition')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
    <style>
        a {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        a:hover {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }

        table.dataTable tbody tr.selected {
            background-color: #B0BED9;
        }

        .xwrapper {
            display : flex;
            align-items : center;
        }

        .collapsing {
            -webkit-transition: none;
            transition: none;
            display: none;
        }
    </style>
@endsection
@php
    $v = request()->v;
    $rsList = session()->pull('issuanceList', []); // Second argument is a default value
    session()->put('issuanceList', $rsList);
@endphp
@section('content')
    <div class="card card-danger card-outline flat">
        <div class="card-header card-header-text">
            <h3 class="card-title"><strong>Selected Items</strong></h3>
        </div>
        <div class="card-body">
            <div class="material-datatables">
                <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                    <table id="selectedTable" class="table table-responsive-lg dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                        <thead>
                        <tr role="row">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Product Line</th>
                            <th class="text-right">Available</th>
                            <th class="text-right">Reserved</th>
                            <th class="text-right">Incoming</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Product Line</th>
                            <th class="text-right">Available</th>
                            <th class="text-right">Reserved</th>
                            <th class="text-right">Incoming</th>
                            <th>&nbsp;</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <button class="btn btn-block btn-flat btn-outline btn-success" id="btnNewIssuance">Create Issuance Request</button>
                </div>
                <div class="col-md-6 col-sm-12">
                    <button class="btn btn-block btn-flat btn-outline btn-info" id="btnNewPurchase">Create Purchase Request</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-danger card-outline flat">
        <div class="card-header card-header-text">
            <h3 class="card-title"><strong>Items Lookup</strong></h3>
        </div>
        <div class="card-body">
            <div class="material-datatables">
                <div id="productsTableWrapper" class="dataTables_wrapper dt-bootstrap">
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
                            <div class="col-lg-6 col-md-12"></div>
                            <div class="col-lg-2 col-md-12">
                                <div class="input-group float-right">
                                    <input type="search" id="txtSearch" name="s" class="form-control float-right" value="{{ request()->s }}"/>
                                    <span class="input-group-append">
                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="productsTable" class="table table-responsive-lg dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                        <thead>
                        <tr role="row">
                            <th></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Product Line</th>
                            <th class="text-right">Available</th>
                            <th class="text-right">Reserved</th>
                            <th class="text-right">Incoming</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Product Line</th>
                            <th class="text-right">Available</th>
                            <th class="text-right">Reserved</th>
                            <th class="text-right">Incoming</th>
                            <th>&nbsp;</th>
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
                                $products = $products->
                                where('Category','!=',1)->
                                where('Category','!=',5)->
                                where('Quantity','>',0)->
                                where('Status','=',1)->
                                paginate(10)->appends([
                                    's' => request('s')
                                ]);
                            }

                        @endphp
                        @if($products->count()>0)
                            @foreach($products as $product)
                                @php
                                    $uom = $product->UOM()!=null?$product->UOM()->Abbreviation:"";

                                    // Marker for Reorder Quantity
                                    $marker = $product->getAvailableQuantity() < $product->MinimumQuantity ? "low":"";
                                    // Marker for Critical Quantity
                                    $marker = $product->getAvailableQuantity() < $product->CriticalQuantity ? "critical":"";
                                    // Marker for Zero Quantity
                                    $marker = $product->getAvailableQuantity() == 0 ? "zero":"";

                                    $rsList = session('issuanceList');
                                @endphp
                                <tr role="row" class="{{ $loop->index % 2 ? "odd":"even" }} {{ $marker }} {{ ($rsList && in_array($product->ID, $rsList))?"selected":"" }}">
                                    <td>
                                        <a class="alert-link" data-toggle="collapse" data-target="#demo{{$loop->index}}" id="toggle-menu"><i class="nav-icon fa fa-expand details"></i></a>
                                    </td>
                                    <td>{{ $product->UniqueID }}</td>
                                    <td>{{ $product->Name }}</td>
                                    <td>{{ $product->Description }}</td>
                                    <td>{{ $product->Category()->Description }}</td>
                                    <td>{{ $product->ProductLine()->Description }}</td>
                                    <td class="text-right">{{ sprintf('%d %s',($product->getAvailableQuantity()), $uom) }}</td>
                                    <td class="text-right">{{ sprintf('%d %s',($product->getReservedQuantity()), $uom) }}</td>
                                    <td class="text-right">{{ sprintf('%d %s',($product->getIncomingQuantity()), $uom) }}</td>
                                    <td class="text-center">
                                        <button {{ in_array($product->ID, $rsList)?"disabled":"" }} class="item-add" value="{{ $product->ID }}">&nbsp;&nbsp;Add&nbsp;&nbsp;</button>
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
                    {{ $products->links('templates.pagination.default') }}
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
    <script>
        $(function () {
            // ==== [ Start of Function] ========================================================
            var selectedTable = $('#selectedTable').DataTable( {
                serverSide: false,
                processing: true,
                searching: true,
                ajax: '/rs/issuanceList',
                dataSrc: 'data',
                columns: [
                    { data:"UniqueID" },
                    { data:"Name" },
                    { data:"Description" },
                    { data:"Category" },
                    { data:"ProductLine" },
                    { data:"Available", class:"text-right",orderable: false },
                    { data:"Reserved", class:"text-right",orderable: false },
                    { data:"Incoming", class:"text-right",orderable: false },
                    { data: null, class:"text-center",orderable: false }
                ],
                columnDefs: [
                    {
                        render: function ( data, type, row ) {
                            return '<button class="item-remove" value="'+data['ID']+'">Remove</button>';
                        },
                        targets: 8

                    }
                ],
                pagingType: "full_numbers",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                    infoFiltered: ""
                }
            } );
            // ==== [ End of Function] ==========================================================






            // ==== [ Start of Function] ========================================================
            $('.item-defer').on('click', function(e) {
                e.preventDefault();
                alert($(this).val());
            });

            // ==== [ End of Function] ==========================================================

            var selected = [];

            var perPage = $('#selPerPage').select2({
                width: '100%',
                placeholder: "Select Filter",
                minimumResultsForSearch: -1
            });


            perPage.on('change', function(){
                $('#frmParams').submit();
            });


            var productsTable = $('#productsTable');
            var detailRows = [];

            $('#productsTable #selectedTable tbody').on( 'click', 'tr', function (e) {
                console.log(e.target.innerHTML.indexOf("Defer")>=0);
                if(e.target.className.includes('details')) {
                    var tr = $(this).closest('tr');
                    var idx = $.inArray( tr.attr('id'), detailRows );

                    if ( tr.child.isShown() ) {
                        tr.removeClass( 'details' );
                        tr.child.hide();

                        // Remove from the 'open' array
                        detailRows.splice( idx, 1 );
                    }
                    else {
                        tr.addClass( 'details' );
                        tr.child( format( row.data() ) ).show();

                        // Add to the 'open' array
                        if ( idx === -1 ) {
                            detailRows.push( tr.attr('id') );
                        }
                    }
                }
            });

            $('#btnNewIssuance').on('click', function(e){
                e.preventDefault();
                var request = $.ajax({
                    method: "POST",
                    url: "/rs/issuanceList/check/ir",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                request.done(function(x) {
                    console.log(x);
                    if(x.code==1) {
                        location.href = "/issuance-request/new?_zx="+x.csrf;
                    } else {
                        swal({
                            type: 'error',
                            title: x.title,
                            text: x.message
                        });
                    }
                });
            });

            $('#btnNewPurchase').on('click', function(e){
                e.preventDefault();
                var request = $.ajax({
                    method: "POST",
                    url: "/rs/issuanceList/check/pr",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                request.done(function(x) {
                    console.log(x);
                    if(x.code==1) {
                        location.href = "/purchase-request/new?_zx="+x.csrf+"&ref=rspage";
                    } else {
                        swal({
                            type: 'error',
                            title: x.title,
                            text: x.message
                        });
                    }
                });
            });



            //==============================================================================================================
            // DO NOT DELETE
            // THIS THE ENDING TAG.
            // KEEP SCRIPTS ABOVE THIS.
            //==============================================================================================================
        });


        // ==== [ Start of Function] ========================================================
        $(document).on('click', '.item-add', function(e){
            e.preventDefault();

            var itemID = $(this).val();

            var $row = $(this).closest('tr');
            var $cols = $row.find('td');
            var str = JSON.stringify($cols[3].innerHTML);

            $.ajax({
                method: "GET",
                url: "/rs/issuanceList/count",
                success: function(e) {
                    if (e>=10) {
                        swal({
                            title: 'Error',
                            text: 'Only 10 items allowed per transaction.',
                            type: 'error'
                        });
                    }
                    else {
                        var request = $.ajax({
                            method: "POST",
                            url: "/rs/issuanceList/addToList",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: { variable: "issuanceList", value:  itemID }
                        });

                        request.done(function(x) {
                            swal({
                                title: 'Success',
                                text: decodeEntities(str)+' added to list.',
                                type: 'success'
                            }, function(x) {
                                $('#selectedTable').dataTable().api().ajax.reload();
                                $('#productsTableWrapper' ).load(location.href+" #productsTableWrapper>*","");
                            });
                        });


                    }
                }
            });
        });
        // ==== [ End of Function] ==========================================================

        // ==== [ Start of Function] ========================================================
        $(document).on('click', '.item-remove', function(e){
            var itemID = $(this).val();

            var $row = $(this).closest('tr');
            var $cols = $row.find('td');
            var str = JSON.stringify($cols[2].innerHTML);

            var request = $.ajax({
                method: "POST",
                url: "/rs/issuanceList/removeFromList",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { variable: "issuanceList", value:  itemID }
            });

            request.done(function(x) {
                swal({
                    title: 'Removed',
                    text: decodeEntities(str)+' was removed from the list.',
                    type: 'error'
                }, function(x) {
                    $('#selectedTable').dataTable().api().ajax.reload();
                    $('#productsTableWrapper' ).load(location.href+" #productsTableWrapper>*","");
                });

            });


        });

        // ==== [ End of Function] ==========================================================

        function decodeEntities(encodedString) {
            var textArea = document.createElement('textarea');
            textArea.innerHTML = encodedString;
            return textArea.value;
        }

    </script>
@endsection