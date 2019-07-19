@extends('templates.content',[
    'title'=>'Purchase Requests',
    'description'=>'List of Purchase Requests',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Purchase Requests')
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
@section('title',"Purchase Requests")
@section('content')

    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active show" href="#pending" data-toggle="tab">Pending</a></li>
                <li class="nav-item"><a class="nav-link" href="#approved" data-toggle="tab">Approved</a></li>
                <li class="nav-item"><a class="nav-link" href="#cancelled" data-toggle="tab">Cancelled</a></li>
                <li class="nav-item"><a class="nav-link" href="#forQuote" data-toggle="tab">For Quote</a></li>
                <li class="nav-item"><a class="nav-link" href="#all" data-toggle="tab">All</a></li>
            </ul>
        </div><!-- /.card-header -->
        <div class="card-body">

            <div class="tab-content">
                <div class="tab-pane flat active show" id="pending">
                    <form method="post" action="#" id="approveGroupPR">
                    {{ csrf_field() }}
                    @if(auth()->user()->isPurchasingManager())
                        <div class="toolbar" style="display: flex; justify-content: flex-end">
                            <input type="submit" id="generate-po" class="btn btn-flat btn-fill btn-danger btn-md" style="margin-left: 8px;" value="Approve Purchase Request"/>
                        </div><br/>
                    @endif
                        @include('templates.datatable',
                            array("table"=> [
                                    'Name' => 'pendingTable',
                                    'Classes'=> "",
                                    'Checkbox'=> true,
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
                    </form>
                </div>
                <div class="tab-pane flat" id="approved">
                    @include('templates.datatable',
                        array("table"=> [
                                'Name' => 'approvedTable',
                                'Classes'=> "",
                                'Checkbox'=> false,
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
                
                <div class="tab-pane flat" id="forQuote">
                    @include('templates.datatable',
                        array("table"=> [
                                'Name' => 'forQuoteTable',
                                'Classes'=> "",
                                'Checkbox'=> false,
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
                                'Checkbox'=> false,
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
                                    'Checkbox'=> false,
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
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>        
    <script type="text/javascript">
        $('#allIssuanceTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/purchase-request/data/Z',
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
                        return '<a class="alert-link" href="/purchase-request/view/'+data+'">'+data+'</a> '+addon;
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
            ajax: '/purchase-request/data/P',
            dataSrc: 'data',
            columns: [
                {
                    class:          "checkbox",
                    data:           null
                },
                { data:"OrderNumber" },
                { data:"Date" },
                { data:"Requester" },
                { data:"ChargeTo" },
                { data:"Status" }
            ],
            columnDefs: [
                { orderable: false, targets: [0] },
                {
                    render: function ( data, type, row ) {
                        addon = '';
                        if(row['Status']=='V') {
                            addon = '<span class="badge badge-danger">Voided</span>';
                        }
                        return '<a class="alert-link" href="/purchase-request/view/'+data+'">'+data+'</a> '+addon;
                    },
                    targets: 1
                },
                {
                    render: function ( data, type, row ) {
                        if(row['Status'] == "Pending Quotation"){
                            return "";
                        }else{
                            return '<input type="checkbox" class="checkSingle icheckbox_square-red" value="' + row['OrderNumber'] + '" name="SelectedItems[]"/>';
                        }
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

        $('#approvedTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/purchase-request/data/A',
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
                        return '<a class="alert-link" href="/purchase-request/view/'+data+'">'+data+'</a> '+addon;
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
            ajax: '/purchase-request/data/X',
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
                        return '<a class="alert-link" href="/purchase-request/view/'+data+'">'+data+'</a> '+addon;
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

        $('#orderedTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/purchase-request/data/O',
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
                        return '<a class="alert-link" href="/purchase-request/view/'+data+'">'+data+'</a> '+addon;
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


        $('#forQuoteTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/purchase-request/data/Q',
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
                        return '<a class="alert-link" href="/purchase-request/view/'+data+'">'+data+'</a> '+addon;
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

        $(document).on('submit','form#approveGroupPR',function(e){
            e.preventDefault();
            if($('input[type=checkbox]:not(#checkAll):checkbox:checked').length == 0){
                swal('Please select a request.');
            }else{
                swal({
                    html: true,
                    title: 'Confirm Action',
                    text: "<html>Do you wish to approve<br/> All checked Purchase Request?<br/><br/>"+
                    "<textarea " +
                    "id='Remarks'" +
                    "class='form-control flat' " +
                    "placeholder='Add some notes here.' " +
                    "style='resize: none;' " +
                    "rows='3'></textarea>" +
                    "</html>",
                    type: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                },function(x){
                    if(x) {
                        $('input[type=checkbox]:not(#checkAll)').each(function () {
                            if(this.checked){
                                var remarks = $("#Remarks").val();
                                var request = $.ajax({
                                    method: "POST",
                                    url: "/purchase-request/" + $(this).val() + "/toggle",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: { Remarks: remarks }
                                });
                            }
                        }).promise().done(function () { 
                            console.log(x);
                            window.location = window.location.pathname;
                        });

                    } else {

                    }
                });
            }
        });
    </script>
@endsection