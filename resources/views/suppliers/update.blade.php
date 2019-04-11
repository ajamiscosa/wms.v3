@extends('templates.content',[
    'title'=>'Update Vendor Details',
    'description'=>'Update the Vendor Details.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Vendors','/vendor'),
        \App\Classes\Breadcrumb::create($data->Code,'/vendor/view/'.$data->Code),
        \App\Classes\Breadcrumb::create('Update')
    ]
])
@section('title',sprintf('Create New Supplier'))

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
@endsection

@section('content')
    <form method="post" action="/vendor/update/{{$data->Code}}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title"><strong>Vendor Details</strong> <small style="font-style: italic"><small>*required</small></small></h3>
                    </div>
                    <div class="card-body">
                        <strong class="mt-0 pt-0"><i class="fa fa-braille mr-1"></i> Code</strong>
                        <p class="text-muted">
                            <input type="text" class="form-control" name="Code" value="{{ $data->Code }}" readonly/>
                        </p>
                        <strong><i class="fa fa-edit mr-1"></i> Name</strong>
                        <p class="text-muted">
                            <input type="text" class="form-control" name="Name" value="{{ $data->Name }}" readonly/>
                        </p>
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6">
                                <strong><i class="fa fa-store-alt mr-1"></i> Supplier Type</strong>
                                <select class="supplierType-select form-control" name="SupplierType" required>
                                    <option></option>
                                    @foreach(\App\SupplierType::all() as $supplierType)
                                        <option value="{{ $supplierType->ID }}" {{ $supplierType->ID==$data->SupplierType?"selected":"" }}>{{ $supplierType->Description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <strong><i class="fa fa-dollar-sign mr-1"></i> Currency</strong>
                                <select class="currency-select form-control" name="Currency" required>
                                    <option></option>
                                    @foreach(\App\Currency::all() as $currency)
                                        <option value="{{ $currency->ID }}" {{ $currency->ID==$data->Currency?"selected":"" }}>{{ $currency->Code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6">
                                <strong><i class="fa fa-calendar-alt mr-1"></i> Classification</strong>
                                <select class="classification-select form-control" name="Classification" required>
                                    <option></option>
                                    <option value="L" {{ $data->Classification=='L'?"selected":"" }}>Local Vendor</option>
                                    <option value="F" {{ $data->Classification=='F'?"selected":"" }}>Foreign Vendor</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <strong><i class="fa fa-calendar-alt mr-1"></i> Term and Credit</strong>
                                <select class="term-select form-control" name="Term" required>
                                    <option></option>
                                    @foreach(\App\Term::all() as $term)
                                        <option value="{{ $term->ID }}" {{ $term->ID==$data->Term?"selected":"" }}>{{ $term->Description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6">
                                <strong><i class="far fa-calendar-alt mr-1"></i> Shipping Method</strong>
                                <select class="term-select form-control" name="ShipVia" required>
                                    <option></option>
                                    @foreach(\App\ShippingMethod::all() as $shipVia)
                                        <option value="{{ $shipVia->ID }}" {{ $shipVia->ID==$data->ShippingMethod?"selected":"" }}>{{ $shipVia->Description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <strong><i class="fa fa-truck-moving mr-1"></i> Delivery Lead Time</strong>
                                <p class="text-muted mb-0 pb-0">
                                    <input type="number" class="form-control" name="DeliveryLeadTime" value="{{ $data->DeliveryLeadTime }}" required/>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <strong><i class="far fa-calendar-alt mr-1"></i> Status: </strong><span id="lblStatus">{{ $data->Status?"Active":"Inactive" }}</span>
                                <input type="hidden" id="Status" name="Status" value="{{ $data->Status }}"/>
                                <div class="material-switch pull-right pt-2" style="align-content: center;">
                                    <input id="switchStatus" name="someSwitchOption001" type="checkbox" {{ $data->Status?"checked":"" }}/>
                                    <label for="switchStatus" class="label-danger"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-8 pr-1">
                                <button type="submit" class="btn btn-flat btn-fill btn-block btn-danger">Save</button>
                             </div>
                            <div class="col-md-4 pl-0">
                                <a href="/vendor/view/{{ $data->Code }}" class="btn btn-flat btn-fill btn-block btn-default">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title"><strong>Additional Details</strong> <small style="font-style: italic"><small>*optional</small></small></h3>
                    </div>
                    <div class="card-body" style="padding-bottom: 0px;">
                        <strong><i class="fa fa-user-circle mr-1"></i> Contact Person</strong>
                        <p class="text-muted">
                            <input type="text" class="form-control" name="Contact" value="{{ $data->Contact }}" />
                        </p>
                        <strong><i class="fa fa-address-card mr-1"></i> Address</strong>
                        <p class="text-muted">
                            <input type="text" class="form-control mb-1" name="AddressLine1" placeholder="Address Line 1" value="{{ $data->AddressLine1 }}"/>
                            <input type="text" class="form-control" name="AddressLine2" placeholder="Address Line 2" value="{{ $data->AddressLine2 }}"/>
                        </p>
                        <div class="row mb-3">
                            <div class="col-lg-4 col-md-4">
                                <strong><i class="fa fa-flag-checkered mr-1"></i> City</strong>
                                <p class="text-muted mb-0">
                                    <input type="text" class="form-control" name="City" value="{{ $data->City }}"/>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <strong><i class="fa fa-expand mr-1"></i> State</strong>
                                <p class="text-muted mb-0">
                                    <input type="text" class="form-control" name="State" value="{{ $data->State }}"/>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <strong><i class="fa fa-map-pin mr-1"></i> Zip</strong>
                                <p class="text-muted mb-0">
                                    <input type="text" class="form-control" name="Zip" value="{{ $data->Zip }}"/>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <strong><i class="fa fa-flag mr-1"></i> Country</strong>
                                <p class="text-muted">
                                    <input type="text" class="form-control" name="Country" value="{{ $data->Country }}"/>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4 col-md-4">
                                <strong><i class="fa fa-phone mr-1"></i> Telephone1</strong>
                                <p class="text-muted mb-0">
                                    <input type="text" class="form-control" name="Telephone1" value="{{ $data->Telephone1 }}"/>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <strong><i class="fa fa-phone mr-1"></i> Telephone2</strong>
                                <p class="text-muted mb-0">
                                    <input type="text" class="form-control" name="Telephone2" value="{{ $data->Telephone2 }}"/>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <strong><i class="fa fa-fax mr-1"></i> Fax Number</strong>
                                <p class="text-muted mb-0">
                                    <input type="text" class="form-control" name="FaxNumber" value="{{ $data->FaxNumber }}"/>
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6">
                                <strong><i class="fa fa-calendar-alt mr-1"></i> Email Address</strong>
                                <p class="text-muted mb-0">
                                    <input type="email" class="form-control" name="Email" value="{{ $data->Email }}"/>
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <strong><i class="far fa-calendar-alt mr-1"></i> Website URL</strong>
                                <p class="text-muted mb-0">
                                    <input type="text" class="form-control" name="WebSite" value="{{ $data->WebSite }}"/>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(function () {

            var $supplierType = $('.supplierType-select');
            $supplierType.select2({
                placeholder: 'Select Supplier Type',
                minimumResultsForSearch: -1
            });

            var $currency = $('.currency-select');
            $currency.select2({
                placeholder: 'Select Currency',
                minimumResultsForSearch: -1
            });

            var $term = $('.term-select');
            $term.select2({
                placeholder: 'Select Term',
                minimumResultsForSearch: -1
            });


            var $class = $('.classification-select');
            $class.select2({
                placeholder: 'Select Classification',
                minimumResultsForSearch: -1
            });

            $('#switchStatus').on('change', function(){
                $('#Status').val($(this).prop('checked')?1:0);
                $('#lblStatus').html($(this).prop('checked')?"Active":"Inactive");
            });
        });

    </script>
@endsection