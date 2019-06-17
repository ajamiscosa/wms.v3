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
            
    <!-- Product Detail Box -->
    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
        <div class="card-header flat">
            <h3 class="card-title"><strong>Product Details: </strong> qwe</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
                <div class="row float-right">
                    <div class="col-md-12">
                        <form action="" method="post">
                            {{ csrf_field() }}
                                <a href="#" class="btn btn-flat btn-fill btn-danger btn-sm">Edit</a>
                                <button type="submit" class="btn btn-flat btn-fill btn-default btn-sm">Disable</button>
                                <button type="submit" class="btn btn-flat pull-right btn-fill btn-success btn-sm">Enable</button>
                                <a role="button" class="btn btn-flat pull-right btn-fill btn-warning btn-sm" id="btnDelete">Delete</a>
                        </form>
                    </div>
                </div>
                <hr class="mt-5">
            <strong><i class="fa fa-qrcode mr-1"></i> QR Code</strong><span class="float-right"><a href="" target="_blank" class="btn btn-flat btn-default"><i class="fa fa-print"></i></a></span>
            <p class="text-muted">
            </p>
            <hr>
            <strong><i class="fa fa-edit mr-1"></i> Name</strong>
            <p class="text-muted">
                13231
            </p>
            <hr>
            <strong><i class="fa fa-book mr-1"></i> Description</strong>
            <p class="text-muted">
                qwe
            </p>
            <hr class="pb-0 mt-0">
            <strong><i class="fab fa-delicious mr-1"></i> Category</strong>
            <p class="text-muted">
                asd
            </p>
            <hr class="pb-0 mt-0">
            <strong><i class="fab fa-dropbox mr-1"></i> Product Line</strong>
            <p class="text-muted">
                zcxc
            </p>
            <hr class="pb-0 mt-0">
            <strong><i class="fa fa-shopping-bag mr-1"></i> Unit of Measurement</strong>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
        </div>
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