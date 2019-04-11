@extends('templates.content',[
    'title'=>'Department',
    'description'=>'View Departments',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Department')
    ]
])
@section('title','Departments')
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
        <h4 class="card-title">Departments</h4>
    </div>
    <div class="card-body">
        <h3 class="card-title">
            <a href="/department/new" id="add-brand" class="btn btn-flat pull-right btn-fill btn-danger btn-md" style="margin-left: 8px;">Add New Department</a>
        </h3>
    </div>
    <div class="card-body">
        <div class="material-datatables">
            <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="brandTable" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                            <thead>
                            <tr>
                                <th>Name</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Name</th>
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
        $('#brandTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/department/data',
            dataSrc: 'data',
            columns: [
                { data:"Name" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        var ID = row['ID'];
                        var Name = data.split(' ').join('-');
                        return '<a class="alert-link" href="/department/view/'+ID+'-'+Name+'">'+data+'</a>';
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