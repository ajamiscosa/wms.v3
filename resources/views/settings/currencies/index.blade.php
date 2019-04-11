@extends('templates.content',[
    'title'=>'Currencies',
    'description'=>'List of Currencies',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Currency')
    ]
])
@section('title','Currencies')
@section('styles')
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
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-icon">
                    <h4 class="card-title" style="display: inline-block">Currencies</h4>
                </div>
                <div class="card-body">
                    <h3 class="card-title">
                        {{-- <a href="/currency/new" id="add-warehouse" class="btn btn-flat btn-fill btn-danger btn-md" style="margin-left: 8px;">Update Exchange Rate</a> --}}
                        <button id='update-forex' class="btn btn-flat btn-fill btn-danger btn-md" style="margin-left: 8px;">Update Exchange Rate</button>
                        <button id='update-usd' class="btn btn-flat btn-fill btn-danger btn-md" style="margin-left: 8px;">Upload New USD Rates</button>
                        <input type="file" id="usdrates" style="display: none;" accept=".csv"/>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="material-datatables">
                        <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="warehouseTable" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                                        <thead>
                                        <tr role="row">
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th class="text-right">USD</th>
                                            <th class="text-right">PHP</th>
                                            <th>Last Updated</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>USD</th>
                                            <th>PHP</th>
                                            <th>Last Updated</th>
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
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script>
        $('#warehouseTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '/currency/data',
            dataSrc: 'data',
            columns: [
                { data:"Code" },
                { data:"Name" },
                { data:"USD", class: "text-right"},
                { data:"PHP", class: "text-right"},
                { data:"updated_at"}
            ],
            // columnDefs: [
            //     {
            //         render: function ( data, type, row ) {
            //             return '<a class="alert-link" href="/currency/view/'+data+'">'+data+'</a>';
            //         },
            //         targets: 0
            //     }
            // ],
            pagingType: "full_numbers",
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
                infoFiltered: ""
            }
        } );

        $('#update-forex').on('click', function(){
            var result = swal({
                html: true,
                title: 'Enter New Rate',
                text:
                "<html>Please enter new exchange rate for USD to PHP.<br/>"+
                "1 USD = <center><input type='number' " +
                "id='Rate'" +
                "class='form-control flat' " +
                "maxlength='10' style='width: 150px;'></center>"+
                "</html>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC3545',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Update',
                cancelButtonText: 'Cancel'
            },function(x){
                if(x) {
                    var rate = $("#Rate").val();
                    var request = $.ajax({
                        method: "POST",
                        url: "/currency/update",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { Rate: rate }
                    });

                    request.done(function(x){
                        console.log(x);
                        window.location = window.location.pathname;
                    });
                    
                }
            });
        });

        $('#update-usd').on('click', function() {
            $('#usdrates').trigger('click');
        });

        $('#usdrates').on('change', function(){
            var file = $('#usdrates').prop('files')[0];
            var formData = new FormData();
            formData.append("file", file);
            if (file) {
                var reader = new FileReader();
                reader.readAsText(file, "UTF-8");
                reader.onload = function (evt) {
                    var lines = evt.target.result.split('\n');
                    console.log(lines.length);
                    for(var i=0;i<lines.length;i++) {
                        var data = lines[i].split(',');
                        console.log(data);
                        $.ajax({
                            async: false,
                            url: "/currency/update-rate",
                            method: "POST",
                            data: {
                                Code: data[0],
                                Rate: data[1],
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(datax) {
                            },
                            error: function(xhr, status, error) {
                                console.log(data);
                                console.log(xhr.responseText);
                            }
                        });
                    }
                };
                reader.onerror = function (evt) {
                    console.log(evt.target.result);
                };
            }
            
            window.location = window.location.pathname;
        });
    </script>
@endsection