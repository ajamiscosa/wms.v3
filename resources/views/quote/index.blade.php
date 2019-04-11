@extends('templates.content',[
    'title'=>'Categories',
    'description'=>'List of Item Categories',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Product','/product/view/'.$data->UniqueID),
        \App\Classes\Breadcrumb::create('Quote'),
    ]
])
@section('styles')
@endsection
@php
    $url = \Illuminate\Support\Facades\URL::current();
@endphp
@section('content')
    <div class="col-lg-12">
    @include('inventory.products.quote', ['data'=>$data])
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script>
        $('#warehouseTable').DataTable( {
            serverSide: false,
            processing: true,
            searching: true,
            ajax: '{{ $url }}/data',
            dataSrc: 'data',
            columns: [
                { data:"Supplier" },
                { data:"ValidFrom" },
                { data:"Amount" },
                { data:"FileName" }
            ],
            columnDefs: [
                {
                    render: function ( data, type, row ) {
                        var ID = row['ID'];
                        var Name = data.split(' ').join('-');
                        return '<a class="alert-link" href="/category/view/'+ID+'-'+Name+'">'+data+'</a>';
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