@extends('templates.content',[
    'title'=>'General Ledger',
    'description'=>'List of General Ledger Codes used throughout.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('General Ledger')
    ]
])
@section('title',"General Ledger Accounts")
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
        <h4 class="card-title" style="display: inline-block">General Ledger</h4>
    </div>
    <div class="card-body">
        <h3 class="card-title">
            <a href="/gl/new" class="btn btn-flat pull-right btn-fill btn-danger btn-md mr-15" style="margin-left: 8px;">Add New General Ledger Code</a>
        </h3>
    </div>
    <div class="card-body">
        <div class="toolbar">
        </div>
        <div class="material-datatables">
            <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="glTable" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 128px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">Code</th>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">Code</th>
                                <th>Description</th>
                                <th>Status</th>
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
@endsection
@section('scripts')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script>
        $('#glTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/gl/data',
            dataSrc: 'data',
            columns: [
                { data:"Code" },
                { data:"Description" },
                { data:"Status" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        var ID = row['ID'];
                        var Name = data.split(' ').join('-');
                        return '<a class="alert-link" href="/gl/view/'+data+'">'+data+'</a>';
                    },
                    targets: 0
                },
                {
                    render: function ( data, type, row ) {
                        var Status = row['Status'];
                        return Status==1?"Active":"Inactive";
                    },
                    targets: 2
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