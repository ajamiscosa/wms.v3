@extends('templates.content',[
    'title'=>'View Product',
    'description'=>'View Product Details.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Product','/product'),
        \App\Classes\Breadcrumb::create(''.$data->UniqueID)
    ]
])
@section('title',"[$data->UniqueID] $data->Name")
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icheck.square-red.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-12">
        @include('inventory.products.details', ['data'=>$data])
        </div>
        @if(auth()->user()->isAuthorized('Quotes','V'))
            <div class="col-lg-8 col-md-12">
            @include('inventory.products.quote', ['data'=>$data])
            </div>
        @endif
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script>
        $(function() {

            $('.btn-delete').on('click', function(){
                var id = $(this).val();
                var name = $('#supplier-name'+id).val();
                var result = swal({
                    title: "Delete Quote",
                    text: "Do you wish to delete quote from "+name+"?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
//                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                },function(x){
                    if(x) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.post("/quote/"+id+"/delete")
                            .done(function(){
                                window.location = window.location.pathname;
                            });
                    } else {

                    }
                });
            });

            var checkbox = $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_square-red'
            });

            var $categorySelect = $('.category-select');
            $categorySelect.select2({
                placeholder: 'Select Category',
                minimumResultsForSearch: -1
            });
            var $productLineSelect = $('.productlines-select');
            $productLineSelect.select2({
                placeholder: 'Select Product Line',
                minimumResultsForSearch: -1
            });
            var $itemtypeSelect = $('.itemtype-select');
            $itemtypeSelect.select2({
                placeholder: 'Select Item Type',
                minimumResultsForSearch: -1
            });

            var $uomSelect = $('.uom-select');
            $uomSelect.select2({
                placeholder: 'Select UOM'
            });

            $('#btnDelete').on('click', function() {
                swal({
                    title: "Delete {{ $data->UniqueID }}?",
                    text: "Do you wish to delete {{ $data->UniqueID }} from the database?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
//                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                },function(x){
                    if(x) {
                        swal({
                           text: "Deleted"
                        });
                    } else {

                    }
                });
            });
        });

    </script>
@endsection