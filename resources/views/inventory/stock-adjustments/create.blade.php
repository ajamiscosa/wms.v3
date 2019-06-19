@extends('templates.content',[
    'title'=>'Stock Adjustments',
    'description'=>'Create New Stock Adjustment Request',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Stock Adjustment','/stock-adjustment'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title','New Stock Adjustment')
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
            <form method="post" action="/stock-adjustment/store">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">New Stock Adjustment</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="control-label">Product</label>
                                <div class="form-group">
                                    <select class="product-select form-control" name="Product" id="Product" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Unit Of Measure</label>
                                <div class="form-group" style="margin-bottom: 8px;">
                                    <input type="text" class="form-control uom" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Quantity On Hand</label>
                                <div class="form-group" style="margin-bottom: 8px;">
                                    <input type="number" id="Initial" name="Initial" class="form-control text-right" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Adjust Quantity By</label>
                                <div class="form-group" style="margin-bottom: 8px;">
                                    <input type="number" step=".01" id="Adjustment" name="Adjustment" class="form-control text-right" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">New Quantity</label>
                                <div class="form-group" style="margin-bottom: 8px;">
                                    <input type="number" id="Final" name="Final" class="form-control text-right" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label">Reason</label>
                                <div class="form-group" style="margin-bottom: 8px;">
                                    <textarea name="Reason" class="form-control flat" style="resize: none;" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row float-right">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="/stock-adjustment" class="btn btn-flat btn-default btn-sm">Cancel</a>
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
            var $productSelect = $('.product-select');
            $productSelect.select2({
                width: '100%',
                ajax: {
                    url: '/stock-adjustment/product-data',
                    dataType: 'json'
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                matcher: matchCustom,
                placeholder: "Select Product"
            });

            $productSelect.on('change',function(){
                var productID = $('#Product').val();
                if(productID>0) {
                    getCurrentStocks(productID);
                }
            });


            $('#Adjustment').on('change', function(){
                var adjustment = parseFloat($(this).val());
                var initial = parseFloat($("#Initial").val());
                var final = initial + adjustment;
                $('#Final').val(final.toFixed(2).toLocaleString('en'));
            });

            function getCurrentStocks(product) {
                if(product>0){
                    $.ajax({
                        url: "/product/"+product+"/current-stocks/",
                        success: function(data) {
                            $('#Initial').val(data.Quantity);
                            $('.uom').val(data.UOM);
                            $( "#Adjustment" ).attr( "step", data.UOMType===1?0.001:1 );
                        }
                    });
                }
            }

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