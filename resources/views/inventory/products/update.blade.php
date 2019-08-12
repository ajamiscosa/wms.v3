@extends('templates.content',[
    'title'=>'Update Product',
    'description'=>'Update item details in database.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Product','/product'),
        \App\Classes\Breadcrumb::create('Update')
    ]
])
@section('title',"Updating [$data->UniqueID] $data->Name")
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
@endsection
@php
$url = \Illuminate\Support\Facades\URL::current();
$app_url = env('APP_URL');
$edit_path = str_replace($app_url, "", $url);
$edit_path = str_replace("view", "update", $edit_path);
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <form method="post" action="{{ $edit_path }}">
                    {{ csrf_field() }}
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">
                            <strong>Updating Product: </strong>{{ $data->UniqueID }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input class="form-control" name="Name" type="text" placeholder="Name" value="{{ $data->Name }}" readonly required style="text-transform:uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <textarea rows="3" class="form-control flat" style="resize: none;" name="Description" required style="text-transform:uppercase">{{ $data->Description }}</textarea>
                                    <span class="small-box-footer"><i>Please observe the following format when creating the Item Description.</i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">G/L Inventory Account</label>
                                    <select required class="invgl-select form-control" name="InventoryGL">
                                        <option></option>
                                        @foreach(\App\GeneralLedger::getGeneralLedgerCodesFor('v') as $gl)
                                            <option value="{{ $gl->Code }}" {{ $gl->ID==$data->InventoryGL?"selected":"" }}>[{{ $gl->Code }}] {{ $gl->Description }}</option>
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
                                            <option value="{{ $gl->Code }}" {{ $gl->ID==$data->IssuanceGL?"selected":"" }}>[{{ $gl->Code }}] {{ $gl->Description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Unit of Measure</label>
                                    <select class="uom-select form-control" name="UOM" data-size="3" data-style="btn select-with-transition" title="- Select Base UOM -" {{ $data->UOM==0?"":"readonly" }} required>
                                        <option></option>
                                        @foreach(\App\UnitOfMeasure::Active() as $uom)
                                            <option value="{{ $uom->ID }}" data-uomtype="{{$uom->Type}}" {{ $uom->ID==$data->UOM?"selected":"" }}>{{ $uom->Name }} ({{ $uom->Abbreviation }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Minimum Quantity (MIN)</label>
                                    <input class="form-control text-right" name="ReorderPoint" type="number" step="0.001" min="0" value="{{ $data->MinimumQuantity }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Maximum Quantity (MAX)</label>
                                    <input class="form-control text-right" name="ReorderQuantity" type="number" step="0.001" min="0" value="{{ $data->MaximumQuantity }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Safety Stocks Quantity</label>
                                    <input class="form-control text-right" name="MinimumQuantity" type="number" step="0.001" min="0" value="{{ $data->SafetyStockQuantity }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Re-order Point</label>
                                    <input class="form-control text-right" name="ReOrderPoint" type="number" step="0.001" min="0" value="{{ $data->ReOrderPoint }}">
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
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(function() {
            var $categorySelect = $('.category-select');
            $categorySelect.select2({
                placeholder: 'Select Category',
                minimumResultsForSearch: -1,
                disabled: true
            });
            var $productLineSelect = $('.productlines-select');
            $productLineSelect.select2({
                placeholder: 'Select Product Line',
                minimumResultsForSearch: -1,
                disabled: true
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

        });

    </script>
@endsection