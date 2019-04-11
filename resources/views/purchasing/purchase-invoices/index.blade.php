@extends('app')
@section('styles')
    <style>
        a {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        a:hover {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        .card-title {
            padding-top: 4px;
            height: 27px;
            line-height: 27px;
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="green">
                    <i class="material-icons">shopping_basket</i>
                    <h4 class="card-title pull-right" style="display: inline-block">Purchase Invoices (Bills)</h4>
                </div>
                <div class="card-content">
                    <div class="material-datatables">
                        <div id="datatables_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="billTable" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting" aria-controls="datatables" style="width: 128px;">PO #</th>
                                            <th class="sorting">Date</th>
                                            <th class="sorting">Due Date</th>
                                            <th class="sorting">PO #</th>
                                            <th class="sorting">Vendor</th>
                                            <th>Paid</th>
                                            <th class="sorting text-right">Total</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th>Due Date</th>
                                            <th>PO #</th>
                                            <th>Supplier</th>
                                            <th>Paid</th>
                                            <th>Total</th>
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
                <!-- end content-->
            </div>
            <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
    </div>
@endsection
@section('scripts')
    <script src="js/jquery.datatables.js"></script>

    <script>
        $('#billTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/purchase-invoice/data',
            dataSrc: 'data',
            columns: [
                { data:"OrderNumber" },
                { data:"OrderDate" },
                { data:"DueDate" },
                { data:"PurchaseOrder" },
                { data:"Supplier" },
                { data:"Paid", orderable: false },
                { data:"Total" }

            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return '<a class="alert-link" href="/purchase-invoice/view/'+data+'">'+data+'</a>';
                    },
                    targets: 0
                },
                {
                    render: function(d,t,r) {
                        return d+'%';
                    },
                    targets: [ 5 ]
                },
                { className: "text-right", "targets": [ 6 ] }
            ],

            pagingType: "full_numbers",
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search Purchase Order",
                infoFiltered: ""
            }
        } );
    </script>
@endsection
