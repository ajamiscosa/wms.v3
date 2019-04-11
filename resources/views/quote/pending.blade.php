@extends('templates.content',[
    'title'=>'Pending Quotations',
    'description'=>'List of Quotes that are pending approval.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Quotes Pending Approval')
    ]
])
@section('title','Quotations Pending Approval')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/icheck.square-red.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
@endsection
@php
    $url = \Illuminate\Support\Facades\URL::current();
@endphp
@section('content')
<div class="card card-danger card-outline flat"> <!--  collapsed-card-->

    <div class="card-header card-header-icon" data-background-color="green">
        <h4 class="card-title" style="display: inline-block">Products with Quotations for Approval</h4>
    </div>
    <div class="card-body">
        <div class="material-datatables">
            <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="forQuoteItemsTable" class="table table-striped table-no-bordered dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                            <thead>
                            <tr role="row">
                                <th>Order Number</th>
                                <th>Product</th>
                                <th>Date Filed</th>
                                <th class="text-right">Quoted Amt.</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Total Price</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Order Number</th>
                                <th>Product</th>
                                <th>Date Filed</th>
                                <th class="text-right">Quoted Amt.</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Total Price</th>
                                <th >&nbsp;</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script>
        var radio = $('input[type="radio"]').iCheck({
            radioClass: 'iradio_square-red'
        });

        var dt = $('#forQuoteItemsTable').DataTable( {
//                ordering: false,
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/order-item/for-quote-approval',
            dataSrc: 'data',
            columns: [
                { data:"PRNumber" },
                { data:"Product" },
                { data:"RequiredBy" },
                { data:"Quote", class: "quote-amount text-right" },
                { data:"Quantity", class: "total-quantity text-right" },
                { data:"TotalPrice", class: "total-price text-right" },
                {
                    class:          "details-control",
                    data:           null
                }
            ],
            columnDefs: [
                { orderable: false, targets: [0,3,4,5,6] },
                {
                    render: function ( data, type, row ) {
                        return '<a class="details-control alert-link" id="toggle-menu"><i class="nav-icon fa fa-plus-circle"></i></a>';
                    },
                    targets: 6
                },
                {
                    render: function ( data, type, row ) {
                        return '<a class="alert-link" href="/purchase-request/view/'+data+'">'+data+'</a>';
                    },
                    targets: 0
                },
                {
                    render: function ( data, type, row ) {
                        return '<a class="alert-link" href="/product/view/'+row.UniqueID+'">'+data+'</a>';
                    },
                    targets: 1
                }
//                ,
//                {
//                    render: function ( data, type, row ) {
//                        return '<input type="hidden" class="SelectedQuote" name="SelectedQuote[]" value="'+row.QuoteID+'"/>' +
//                            '<input type="hidden" class="Requisition" name="Requisition[]" value="'+row.ID+'"/>' +
//                            '<input type="hidden" class="LineItem" name="LineItem[]" value="'+data.LineItemID+'"/>' +
//                            '<input type="checkbox" class="checkSingle icheckbox_square-red" value="'+data.LineItemID+'-'+row.ID+'-'+row.QuoteID+'" name="SelectedItems[]"/>';
//                    },
//                    targets: 0
//                }
            ],

            pagingType: "full_numbers",
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
                infoFiltered: ""
            },
            createdRow: function(row,data,index) {
                var prNo = data.PRNumber;
                var lineID = data.LineItemID;
                var className = prNo+'-'+lineID;
                $(row).attr('ID', 'X'+className);
            },
            initComplete: function(settings, json) {
                var checkbox = $('input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_square-red'
                });

                var a = $("input[type='checkbox'].checkSingle");
                var checkAll = $('#checkAll');
                checkAll.on('ifClicked',function (e) {

                    a.iCheck(checkAll.prop('checked')?'uncheck':'check');
                });

                $("input[type='checkbox'].checkSingle").on('ifChanged', function (e) {
                    if(a.length == a.filter(":checked").length){
                        $("#checkAll").iCheck('check');
                    }else {
                        $("#checkAll").iCheck('uncheck');
                    }
                });
            }
        } );

        // Array to track the ids of the details displayed rows
        var detailRows = [];

        $('#forQuoteItemsTable tbody').on( 'click', 'tr td.details-control', function (e) {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice( idx, 1 );

                tr.find('#toggle-menu').html('<a class="alert-link" class="toggle-menu"><i class="nav-icon fa fa-plus-circle"></i></a>');
            }
            else {
                tr.addClass( 'details' );
                console.log(row.data());
                row.child( format( row.data() ) ).show();


                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }

                tr.find('#toggle-menu').html('<a class="alert-link" class="toggle-menu"><i class="nav-icon fa fa-minus-circle"></i></a>');
            }
        } );

        // On each draw, loop over the `detailRows` array and show any child rows
        dt.on( 'draw', function () {
            $.each( detailRows, function ( i, id ) {
                var id = "#"+id;
                $(id+' td.details-control').trigger( 'click' );
            } );
        } );

        function format ( d ) {
            var x = $.ajax({type: "GET", url: "/order-item/lineitem/"+d.LineItemID+"/quote/view", async: false}).responseText;
            return x;
        }
    </script>
@endsection