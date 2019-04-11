@extends('templates.content',[
    'title'=>'Form Numbers',
    'description'=>'View Form Numbers Setup',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Form Numbers')
    ]
])
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
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
@endsection
@section('content')
<div class="card card-danger card-outline flat"> <!--  collapsed-card-->
    <div class="card-header card-header-icon" data-background-color="green">
        <h4 class="card-title" style="display: inline-block">Form Numbers</h4>
    </div>
    <div class="card-body">
        <div class="material-datatables">
            <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="formTable" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                            <thead>
                            <tr role="row">
                                <th>Name</th>
                                <th>Current</th>
                                <th style="width: 128px;">&nbsp;</th>
                                </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Current</th>
                                <th>&nbsp;</th>
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
        $('#formTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/form-number-setup/data',
            dataSrc: 'data',
            columns: [
                { data:"Name" },
                { data:"Current" },
                { data:"Controls"}
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets: [1,2]
                },
                {
                    render: function ( data, type, row ) {
                        var ID = row['ID'];
                        return row['Module'];
                    },
                    targets: 0
                },
                {
                    render: function ( data, type, row ) {
                        var ID = row['ID'];
                        return row['Prefix']+'-'+pad(row['Current'],row['Digits']);
                    },
                    targets: 1
                },
                {
                    render: function ( data, type, row ) {
                        var ID = row['ID'];
                        return '<a role="button" href="/form-number-setup/update/' + ID + '-' + row["Module"] + '" class="btn btn-flat btn-sm btn-info" style="margin: 0 0 0 0px">Update</a>';
                    },
                    orderable: false,
                    targets: -1
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

        function pad (str, max) {
            str = str.toString();
            return str.length < max ? pad("0" + str, max) : str;
        }
    </script>
@endsection