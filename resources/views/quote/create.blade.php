@php
    $url = \Illuminate\Support\Facades\URL::current();
@endphp
@section('title',"New Quote for [$data->UniqueID] $data->Name")
@extends('templates.content',[
    'title'=>'New Quote',
    'description'=>'Add Quote for Product ('.$data->UniqueID.')',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Product','/product'),
        \App\Classes\Breadcrumb::create($data->UniqueID,'/product/view/'.$data->UniqueID),
        \App\Classes\Breadcrumb::create('Quote','/product/'.$data->UniqueID.'/quote'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <style>
        .currency-select {
            width: 75px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <form method="post" action="/quote/store" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Add New Quote</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Product</label>
                                    <input type="text" class="form-control" name="Product" readonly value="{{ $data->UniqueID }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <input type="text" class="form-control" name="Description" readonly value="{{ $data->Description }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Vendor</label>
                                    <select required class="supplier-select form-control" name="Supplier" data-size="3" data-style="btn select-with-transition" data-live-search="true" title="- Select Vendor -">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Amount</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select class="currency-select" name="Currency" id="Currency">
                                                @foreach(\App\Currency::all() as $currency)
                                                <option value="{{ $currency->ID }}" {{ $currency->Code == "PHP"?"selected":"" }}>{{ $currency->Code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input class="form-control text-right" name="Amount" type="number" step="{{ $data->UOM()->Type==1?"0.001":"1" }}" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Valid From</label>
                                    <input type="text" class="form-control datepicker" data-date-format="MM dd, yyyy" id="ValidFrom" name="ValidFrom" value="{{ \Carbon\Carbon::today()->format('F d, Y') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Validity (in days)</label>
                                    <input class="form-control text-right" name="Validity" type="number" step="1" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quoteFile">Attachment</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="FileName" class="custom-file-input flat" id="quoteFile" accept=".pdf, .doc, .docx, .xls, .xlsx|Document Files/*">
                                    <label class="custom-file-label flat" id="quoteFileLabel" for="quoteFile">Select PDF File</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row float-right">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="/product/view/{{$data->UniqueID}}" class="btn btn-flat btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.js') }}"></script>
    <script>
        $(function(){
            var validFrom = $('#ValidFrom').datepicker({
                format: 'MM dd, yyyy',
                autoclose: true
            });


            //validFrom.inputmask('MMMM dd, yyyy', { 'placeholder': 'MMMM dd, yyyy' });

            $('#quoteFile').on('change', function () {
                var path = $('#quoteFile').val();
                var filename = path.replace(/^.*\\/, "");
                console.log(filename);

                $('#quoteFileLabel').html(filename);
            });

            $('.currency-select').select2({
                minimumResultsForSearch: -1
            });

            var $supplierSelect = $('.supplier-select');
            $supplierSelect.select2({
                placeholder: 'Select Vendor',
                width: '100%',
                ajax: {
                    url: function (params) {
                        return '/vendor/selectdata?term='+params.term;
                    },
                    dataType: 'json'
                },
                templateResult: function (data) {
                    var $result = $("<span></span>");

                    $result.text(data.text);
                    $result.append('<input type="hidden" value="'+data.currency+'" id="currencyID"/>')

                    return $result;
                },
                matcher: matchCustom
            });

            $supplierSelect.on('change',function(){
                var currencyID = $('#currencyID').val();
                $("#Currency").select2().select2('val',currencyID);
            });

            function matchCustom(params, data) {
                console.log(data);
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