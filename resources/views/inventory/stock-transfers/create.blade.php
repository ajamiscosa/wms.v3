@extends('templates.content',[
    'title'=>'New Stock Transfers',
    'description'=>'Create New Stock Transfer Request',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Stock Transfer','/stock-transfer'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title','New Stock Transfer')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <style>
        .form-group .select2-container {
            float: left;
            width: 100%;
            display: table;
            table-layout: fixed;
            margin-bottom: 15px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <form method="post" action="/stock-transfer/store" id="transferForm">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">New Stock Transfer</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="control-label">Product</label>
                                <div class="form-group">
                                    <select class="product-select form-control" name="Product" id="Product">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="control-label">Source Location</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="SourceLabel" placeholder="Source Location" readonly>
                                    <input type="hidden" class="form-control" name="Source" id="Source">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="control-label">Destination Location</label>
                                <div class="form-group">
                                    <select class="destination-select form-control" name="Destination" id="Destination" disabled>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Remarks</label>
                                <div class="form-group" style="margin-bottom: 8px;">
                                    <textarea id="Remarks" name="Remarks" class="form-control flat" style="resize: none;" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button id="btnSave" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="/category" class="btn btn-flat btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(function() {

            var $destinationSelect = $('.destination-select');
            $destinationSelect.select2({
                width: '100%',
                ajax: {
                    url: '/stock-transfer/location-data',
                    dataType: 'json',
                    success: function(x) {
                        var source = $('#Source').val();
                        x.results.splice( $.inArray(source, x.results), 1 );
                    }
                },
                matcher: matchCustom,
                placeholder: "Select Destination Location"
            });

            var $productSelect = $('.product-select');
            $productSelect.select2({
                width: '100%',
                ajax: {
                    url: '/stock-transfer/product-data',
                    dataType: 'json'
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                matcher: matchCustom,
                placeholder: "Select Product"
            });

            $('#btnSave').on('click', function(){
                var pid = $productSelect.val();
                var sid = $('#Source').val();
                var did = $destinationSelect.val();
                var rem = $('#Remarks').val();
                if(sid==did) {
                    alert('error');
                    return false;
                } else {
                    $('#transferForm').submit();
                }
            });


            $productSelect.on('change', function(){
                var productid = $(this).val();
                console.log(productid);
                if(productid > 0) {
                    $('#Destination').prop('disabled','');
                    $.ajax({
                        url: '/stock-transfer/location-data/'+productid,
                        dataType: 'json',
                        success: function(x){
                            $('#Source').val(x.results.ID);
                            $('#SourceLabel').val(x.results.Name);
                        }
                    });
                }
            });

            function matchCustom(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                    return null;
                }

                // `params.term` should be the term that is used for searching
                // `data.text` is the text that is displayed for the data object
                if (data.text.indexOf(params.term) > -1) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.text += ' (matched)';

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }
        });

    </script>
@endsection