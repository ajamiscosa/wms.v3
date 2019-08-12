@extends('templates.content',[
    'title'=>'New Product',
    'description'=>'Add a new product to the database.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Product','/product'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title',"New Product")
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
@endsection
@section('content')
    <div class="row">

        <div class="col-lg-6">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <form method="post" action="/product/store">
                    {{ csrf_field() }}
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Create New Product</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="control-label">Location</label>
                                <div class="form-group">
                                    <select required class="location-select form-control" name="Location">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input required class="form-control" name="Name" type="text" placeholder="I.E. BELT" style="text-transform:uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <textarea required rows="3" class="form-control flat" style="resize: none; text-transform:uppercase;" name="Description" placeholder="I.E. BELT POLYMAX 5M 1280 SINGLE"></textarea>
                                    <span class="small-box-footer"><i>Please observe the following format when creating the Item Description.</i></span>
                                </div>
                            </div>
                        </div>
                        {{--<div class="row">--}}
                            {{--<div class="col-lg-12">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label class="control-label">Category</label>--}}
                                    {{--<select required class="category-select form-control" name="Category">--}}
                                        {{--<option></option>--}}
                                        {{--@foreach(\App\Category::where('Status','=',1)->get() as $category)--}}
                                            {{--<option value="{{ $category->ID }}">[{{ $category->Identifier }}] {{ $category->Description }}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-lg-12">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label class="control-label">Product Line</label>--}}
                                    {{--<select required class="productline-select form-control" name="ProductLine">--}}
                                        {{--<option></option>--}}
                                        {{--@foreach(\App\ProductLine::where('Status','=',1)->get() as $productLine)--}}
                                            {{--<option value="{{ $productLine->ID }}">[{{ $productLine->Identifier }}] {{ $productLine->Description }}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">G/L Inventory Account</label>
                                    <select required class="invgl-select form-control" name="InventoryGL">
                                        <option></option>
                                        @foreach(\App\GeneralLedger::getGeneralLedgerCodesFor('v') as $gl)
                                            <option value="{{ $gl->Code }}">[{{ $gl->Code }}] {{ $gl->Description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">G/L COGS/Salary Account</label>
                                    <select required class="cogsgl-select form-control" name="IssuanceGL">
                                        <option></option>
                                        @foreach(\App\GeneralLedger::getGeneralLedgerCodesFor('i') as $gl)
                                            <option value="{{ $gl->Code }}">[{{ $gl->Code }}] {{ $gl->Description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Unit of Measurement</label>
                                    <select required class="uom-select form-control" name="UOM">
                                        <option></option>
                                        @foreach(\App\UnitOfMeasure::where('Status','=',1)->get() as $uom)
                                            <option value="{{ $uom->ID }}" data-uomtype="{{$uom->Type}}" >{{ $uom->Name }} ({{ $uom->Abbreviation }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Minimum Quantity (MIN)</label>
                                    <input required class="form-control text-right numeric-input" name="MinimumQuantity" type="number" step="0.001" min="0">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Maximum Quantity (MAX)</label>
                                    <input required class="form-control text-right numeric-input" name="MaximumQuantity" type="number" step="0.001" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Safety Stocks Quantity</label>
                                    <input required class="form-control text-right numeric-input" name="SafetyStockQuantity" type="number" step="0.001" min="0">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Re-order Point</label>
                                    <input required class="form-control text-right numeric-input" name="ReOrderPoint" type="number" step="0.001" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row float-right">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="/product" class="btn btn-flat btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-text">
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Guidelines</h3>
                </div>
                <div class="card-body">
                    <p>
                        1. Choose the appropriate location of the new product to be added.
                    </p>
                    <hr/>
                    <p>
                        2. Make sure that the specific name of the product to be added is properly
                        entered in the 'NAME' section and should be in all caps.
                        <br/>
                        <strong>I.E. BELT POLYMAX 5M 1280 SINGLE</strong>
                    </p>
                    <hr/>
                    <p>
                        3. <strong>BELT</strong> should be entered in the name section.
                    </p>
                    <hr/>
                    <p>
                        4. To be followed by <strong>BELT POLYMAX 5M 1280 SINGLE</strong>
                        at description section.
                    </p>
                    <hr/>
                    <p>
                        5. Choose the appropriate <strong>G/L Inventory Account</strong> of the new product.
                    </p>
                    <hr/>
                    <p>
                        6. Choose the appropriate <strong>G/L COGS/Salary Account</strong> of the new product.
                    </p>
                    <hr/>
                    <p>
                        7. Choose the appropriate <strong>Unit of Measurement</strong> of the new product.
                    </p>
                    <hr/>
                    <p>
                        8. Enter the
                        <strong>Minimum Quantity</strong>,
                        <strong>Maximum Quantity</strong>,
                        <strong>Safety Stock Quantity</strong>, and
                        <strong>Critical Quantity</strong>
                        based on the submitted warehouse request form.
                    </p>
                    <hr/>
                    <p>
                        9. Double check the completeness of the data.
                    </p>
                    <hr/>
                    <p>
                        10. Click "Save".
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(function() {

            var $locationSelect = $('.location-select');
            $locationSelect.select2({
                width: '100%',
                ajax: {
                    url: '/location/select-data',
                    dataType: 'json',
                    success: function(x) {
                        var source = $('#Source').val();
                        x.results.splice( $.inArray(source, x.results), 1 );
                    }
                },
                matcher: matchCustom,
                placeholder: "Select Destination Location"
            });
            
            
            
            var $categorySelect = $('.category-select');
            $categorySelect.select2({
                placeholder: 'Select Category',
                minimumResultsForSearch: -1
            });
            var $productLineSelect = $('.productline-select');
            $productLineSelect.select2({
                placeholder: 'Select Product Line',
                minimumResultsForSearch: -1
            });

            var $uomSelect = $('.uom-select');
            $uomSelect.select2({
                placeholder: 'Select UOM'
            });

            $uomSelect.on('change', function () {
                var selected = $(this).find('option:selected');
                var extra = selected.data('uomtype'); 
                
                $( ".numeric-input" ).attr( "step", extra===1?0.001:1 );
            });

            var $invGLSelect = $('.invgl-select');
            $invGLSelect.select2({
                placeholder: 'Select Inventory G/L Account'
            });

            var $cogsGLSelect = $('.cogsgl-select');
            $cogsGLSelect.select2({
                placeholder: 'Select COGS/Salary G/L Account'
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