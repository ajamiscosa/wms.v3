
<div class="tab-pane flat" id="transactions">
    <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
        <div class="row">
            <div class="col-sm-12">
                @include('templates.datatable',
                    array("table"=> [
                        'Name' => 'transactionsTable',
                        'Classes'=> "",
                        'Checkbox'=> false,
                        'Headers'=>
                        [
                            ['Text'=>'Item',             'Classes'=>""],
                            ['Text'=>'Quantity',         'Classes'=>""],
                            ['Text'=>'Date Received',    'Classes'=>"sorting_asc"],
                            ['Text'=>'Received By',      'Classes'=>""],
                            ['Text'=>'Remarks',          'Classes'=>""]
                        ]
                    ]
                ))
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>

    <script>
        $('#transactionsTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: "/issuance/{{ $data->OrderNumber }}/transactions",
            dataSrc: 'data',
            ordering: false,
            columns: [
                { data:"Item" },
                { data:"Quantity" },
                { data:"Received" },
                { data:"Receiver" },
                { data:"Message" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        return '<a class="alert-link" href="/product/view/'+row['UniqueID']+'">'+data+'</a>';
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
        


    @if(session()->has('message'))
    @php
    echo "$.notify({ title: '<i class=\"fa fa-check\"></i>&nbsp;&nbsp;',message: \"".session('message')."\"},{ delay: 2500, type: 'success' });";
    @endphp
    @endif
    </script>
@endsection