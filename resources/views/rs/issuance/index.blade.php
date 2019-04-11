@extends('templates.content',[
    'title'=>'Issuance Request',
    'description'=>'Shows the list of Issuance Requests',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Issuances')
    ]
])
@section('title','Issuance Request List')
@section('styles')
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
    </style>
@endsection
@section('content')
    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active show" href="#pending" data-toggle="tab">Pending</a></li>
                <li class="nav-item"><a class="nav-link" href="#approved" data-toggle="tab">Approved</a></li>
                <li class="nav-item"><a class="nav-link" href="#cancelled" data-toggle="tab">Cancelled</a></li>
                <li class="nav-item"><a class="nav-link" href="#all" data-toggle="tab">All</a></li>
            </ul>
        </div><!-- /.card-header -->
        <div class="card-body">


            <div class="tab-content">
                <div class="tab-pane flat active show" id="pending">
                    @include('templates.datatable',
                        array("table"=> [
                                'Name' => 'pendingTable',
                                'Classes'=> "",
                                'Headers'=>
                                [
                                    ['Text'=>'Number', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Date', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Requested By', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Charged To', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Status', 'Sorting'=>false,'Classes'=>""]
                                ]
                            ]
                    ))
                </div>
                <div class="tab-pane flat" id="approved">
                    @include('templates.datatable',
                        array("table"=> [
                                'Name' => 'approvedTable',
                                'Classes'=> "",
                                'Headers'=>
                                [
                                    ['Text'=>'Number', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Date', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Requested By', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Charged To', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Status', 'Sorting'=>false,'Classes'=>""]
                                ]
                            ]
                    ))
                </div>
                <div class="tab-pane flat" id="cancelled">
                    @include('templates.datatable',
                        array("table"=> [
                                'Name' => 'cancelledTable',
                                'Classes'=> "",
                                'Headers'=>
                                [
                                    ['Text'=>'Number', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Date', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Requested By', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Charged To', 'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Status', 'Sorting'=>false,'Classes'=>""]
                                ]
                            ]
                    ))
                </div>
                <div class="tab-pane flat" id="all">
                    <div class="material-datatables">
                        @include('templates.datatable',
                            array("table"=> [
                                    'Name' => 'allIssuanceTable',
                                    'Classes'=> "",
                                    'Headers'=>
                                    [
                                        ['Text'=>'Number', 'Sorting'=>false,'Classes'=>""],
                                        ['Text'=>'Date', 'Sorting'=>false,'Classes'=>""],
                                        ['Text'=>'Requested By', 'Sorting'=>false,'Classes'=>""],
                                        ['Text'=>'Charged To', 'Sorting'=>false,'Classes'=>""],
                                        ['Text'=>'Status', 'Sorting'=>false,'Classes'=>""]
                                    ]
                                ]
                        ))
                    </div>
                </div>
            </div>





        </div>
        <!-- end content-->
    </div>
    <!--  end card  -->
@endsection
@section('scripts')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>

    <script>
        $('#allIssuanceTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/issuance-request/data/Z',
            dataSrc: 'data',
            columns: [
                { data:"OrderNumber" },
                { data:"Date" },
                { data:"Requester" },
                { data:"ChargeTo" },
                { data:"Status" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        addon = '';
                        if(row['Status']=='V') {
                            addon = '<span class="badge badge-danger">Voided</span>';
                        }
                        return '<a class="alert-link" href="/issuance-request/view/'+data+'">'+data+'</a> '+addon;
                    },
                    targets: 0

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

        $('#pendingTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/issuance-request/data/P',
            dataSrc: 'data',
            columns: [
                { data:"OrderNumber" },
                { data:"Date" },
                { data:"Requester" },
                { data:"ChargeTo" },
                { data:"Status" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        addon = '';
                        if(row['Status']=='V') {
                            addon = '<span class="badge badge-danger">Voided</span>';
                        }
                        return '<a class="alert-link" href="/issuance-request/view/'+data+'">'+data+'</a> '+addon;
                    },
                    targets: 0

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

        $('#approvedTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/issuance-request/data/A',
            dataSrc: 'data',
            columns: [
                { data:"OrderNumber" },
                { data:"Date" },
                { data:"Requester" },
                { data:"ChargeTo" },
                { data:"Status" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        addon = '';
                        if(row['Status']=='V') {
                            addon = '<span class="badge badge-danger">Voided</span>';
                        }
                        return '<a class="alert-link" href="/issuance-request/view/'+data+'">'+data+'</a> '+addon;
                    },
                    targets: 0

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

        $('#cancelledTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/issuance-request/data/C',
            dataSrc: 'data',
            columns: [
                { data:"OrderNumber" },
                { data:"Date" },
                { data:"Requester" },
                { data:"ChargeTo" },
                { data:"Status" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        addon = '';
                        if(row['Status']=='V') {
                            addon = '<span class="badge badge-danger">Voided</span>';
                        }
                        return '<a class="alert-link" href="/issuance-request/view/'+data+'">'+data+'</a> '+addon;
                    },
                    targets: 0

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
    </script>
@endsection