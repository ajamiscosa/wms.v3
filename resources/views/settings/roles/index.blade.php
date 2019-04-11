@extends('templates.content',[
    'title'=>'User Roles',
    'description'=>'View all available user roles',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('User Roles')
    ]
])
@section('styles')
    <link href="{{ asset('css/sweetalert2.css') }}" rel="stylesheet" />
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
        .card-title {
            padding-top: 4px;
            height: 27px;
            line-height: 27px;
            text-align: center;
        }
    </style>
@endsection
@section('content')
<div class="card card-danger card-outline flat"> <!--  collapsed-card-->
    <div class="card-header card-header-icon" data-background-color="green">
        <h4 class="card-title" style="display: inline-block">User Roles</h4>
    </div>
    <div class="card-body">
        <a href="/role/new" id="add-brand" class="btn btn-flat pull-right btn-fill btn-danger btn-md" style="margin-left: 8px;">Add New Role</a>
    </div>
    <div class="card-body">
        <div class="toolbar">
        </div>
        <div class="material-datatables">
            <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="uomTable" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="datatables" rowspan="1" colspan="1" style="width: 128px;" aria-sort="ascending" aria-label="Name: activate to sort column descending">Name</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">Name</th>
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
        $('#uomTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/role/data',
            dataSrc: 'data',
            columns: [
                { data:"Name" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        addon = '';
                        if(row['Status']==0) {
                            addon = '<span class="badge badge-default">Disabled</span>';
                        }

                        var ID = row['ID'];
                        var Name = data.split(' ').join('-');
                        return '<a class="alert-link" href="/role/view/'+ID+'-'+Name+'">'+data+'</a> '+addon;
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