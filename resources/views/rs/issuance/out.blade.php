@extends('templates.content',[
    'title'=>'Issuance Receiving',
    'description'=>'View list of Receivable Issuance Requests.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Issuance Receiving')
    ]
])
@section('title','Issuance Receiving')
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
        <div class="card-header card-header-icon" data-background-color="green">
            <h4 class="card-title" style="display: inline-block">Receivable Issuance Requests</h4>
        </div>
        <div class="card-body">
            <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">

                        @include('templates.datatable',
                            array("table"=> [
                                'Name' => 'issuanceTable',
                                'Classes'=> "",
                                'Headers'=>
                                [
                                    ['Text'=>'Number',          'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Date',            'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Requested By',    'Sorting'=>false,'Classes'=>""],
                                    ['Text'=>'Charged To',      'Sorting'=>false,'Classes'=>""]
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
        $('#issuanceTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/issuance/data',
            dataSrc: 'data',
            columns: [
                { data:"OrderNumber" },
                { data:"Date" },
                { data:"Requester" },
                { data:"ChargeTo" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return '<a class="alert-link" href="/issuance/'+data+'/receiving">'+data+'</a>';
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