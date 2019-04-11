@extends('templates.content',[
    'title'=>'Deferred Items List',
    'description'=>'List of Items for Restocking (Deferred)',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('For Restocking')
    ]
])
@section('title','[Deferred] Items for Restocking')
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
    $rsList = session()->pull('deferredList', []); // Second argument is a default value
    session()->put('deferredList', $rsList);
@endphp
@section('content')
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

                            $deferred = new \App\Defer();
                            $list = $deferred->all()->pluck('Product');

                            $products = new \App\Product();
                            if(request()->has('s')) {
                                $products = $products->
                                where('Name','like','%'.request('s').'%')->
                                orWhere('Description','like','%'.request('s').'%')->
                                orWhere('UniqueID','like','%'.request('s').'%');
                            }


                            $products = $products->whereIn('ID',$list);


                            $products = $products->where('Quantity','<=','MinimumQuantity');

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
                                {{--@if(in_array($product->ID, $rsList))--}}
                                {{--@continue--}}
                                {{--@endif--}}
                                @php



                                    $uom = $product->UOM()->Abbreviation;
                                    // Marker for Reorder Quantity
                                    $marker = $product->getAvailableQuantity() < $product->MinimumQuantity ? "low":"";
                                    // Marker for Critical Quantity
                                    $marker = $product->getAvailableQuantity() < $product->CriticalQuantity ? "critical":"";
                                    // Marker for Zero Quantity
                                    $marker = $product->getAvailableQuantity() == 0 ? "zero":"";

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
                                        <button {{ in_array($product->ID, $rsList)?"disabled":"" }} class="item-restore" value="{{ $product->ID }}">&nbsp;&nbsp;Restore&nbsp;&nbsp;</button>
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


            //==============================================================================================================
            // DO NOT DELETE
            // THIS THE ENDING TAG.
            // KEEP SCRIPTS ABOVE THIS.
            //==============================================================================================================
        });


        // ==== [ Start of Function] ========================================================
        $(document).on('click', '.item-restore', function(e){
            var itemID = $(this).val();

            var $row = $(this).closest('tr');
            var $cols = $row.find('td');
            var str = JSON.stringify($cols[2].innerHTML);

            var request = $.ajax({
                method: "POST",
                url: "/deferred/restore",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { id:  itemID }
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