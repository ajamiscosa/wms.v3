@section('title')
    Items For Quotation
@endsection
@extends('templates.content',[
    'title'=>'Items For Quotation',
    'description'=>'List of Items that Needs Quotations',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Order For Quotation')
    ]
])
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/icheck.square-red.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
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
    </style>
@endsection
@section('content')
<div class="card card-danger card-outline flat"> <!--  collapsed-card-->
    <div class="card-header card-header-icon" data-background-color="green">
        <h4 class="card-title" style="display: inline-block">Products that needs Quotations</h4>
    </div>
    <div class="card-body flat">
        <div class="tab-pane flat active show" id="draft">
            <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="noQuoteItemsTable" class="table table-striped table-no-bordered dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                            <thead>
                            <tr role="row">
                                <th>Order Number</th>
                                <th>Product</th>
                                <th>Date Filed</th>
                                <th>Available Quote/s</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Order Number</th>
                                <th>Product</th>
                                <th>Date Filed</th>
                                <th>Available Quote/s</th>
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
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">
        $('#noQuoteItemsTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/order-item/quote-items',
            dataSrc: 'data',
            columns: [
                { data:"PRNumber" },
                { data:"Product" },
                { data:"RequiredBy" },
                { data:"QuoteCount", class: "text-center"},
                {
                    class:          "details-control text-center",
                    data:           null
                }
            ],
            columnDefs: [
                { orderable: false, targets: [0,3,4] },
                {
                    render: function ( data, type, row ) {
                        return '<a class="details-control alert-link" id="toggle-menu" href="/product/view/'+row.UniqueID+'"><i class="nav-icon fa fa-external-link-alt"></i></a>';
                    },
                    targets: 4
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
            ],

            pagingType: "full_numbers",
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
                infoFiltered: ""
            },
            createRow: function(row,data,index) {
                console.log("row: "+index);
            }
        } );
    </script>
@endsection