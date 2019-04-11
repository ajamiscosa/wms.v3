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
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-icon" data-background-color="green">
                    <i class="material-icons">shopping_basket</i>
                    <h4 class="card-title pull-right" style="display: inline-block">Purchase Returns</h4>
                </div>
                <div class="card-content">
                    <div class="toolbar">
                    </div>
                    <div class="material-datatables">
                        <div id="datatables_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="roTable" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting" aria-controls="datatables">PR #</th>
                                            <th class="sorting">Date Received</th>
                                            <th class="sorting">PO #</th>
                                            <th class="sorting">Supplier</th>
                                            <th class="sorting">Warehouse</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>PR #</th>
                                            <th>Date Received</th>
                                            <th>PO #</th>
                                            <th>Supplier</th>
                                            <th>Warehouse</th>
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
        $('#roTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/purchase-return/data',
            dataSrc: 'data',
            columns: [
                { data:"OrderNumber" },
                { data:"ReceiveDate" },
                { data:"PurchaseOrder" },
                { data:"Supplier", orderable: false },
                { data:"Warehouse", orderable: false },
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        var $addon = "";
                        if(row['Status']=='V'){
                            $addon = $('<span class="badge badge-danger">Voided</span>')
                        }
                        return '<a class="alert-link" href="/purchase-return/view/'+data+'">'+data+'</a>'+$addon;
                    },
                    targets: 0
                }
            ],

            pagingType: "full_numbers",
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search Purchase Return",
                infoFiltered: ""
            }
        } );
    </script>
@endsection
