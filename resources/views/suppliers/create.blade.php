@extends('templates.content',[
    'title'=>'Create New Vendor',
    'description'=>'Add a new vendor.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Vendor','/vendor'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title',sprintf('New Vendor'))

@section('styles')
    <style>
        .custom-file-upload input[type="file"] {
            display: none;
        }
        .custom-file-upload .custom-file-upload {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
@endsection

@section('content')
<form method="post" action="/vendor/store">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-text" style="display: inline-block">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6" style="display: table; margin: 0 auto;">
                                <h3 class="card-title mt-1" style="vertical-align: middle;"><strong>Vendor Details</strong> <small style="font-style: italic"><small>*required</small></small></h3>
                            </div>
                            <div class="col-lg-6 pr-0">
                                <label for="file-upload" class="btn btn-sm btn-fill btn-danger btn-flat float-right mb-0 mr-0">
                                <i class="fa fa-cloud-upload"></i> Upload Vendor Data
                                </label>
                                <input id="file-upload" type="file" style="display: none;" class="float-right" accept=".csv"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <strong class="mt-0 pt-0"><i class="fa fa-braille mr-1"></i> Code</strong>&ensp;<small id="code-error" style="color: red;"></small>
                    <p class="text-muted">
                        <input type="text" class="form-control" id="Code" name="Code" required/>
                    </p>
                    <strong><i class="fa fa-edit mr-1"></i> Name</strong>
                    <p class="text-muted">
                        <input type="text" class="form-control" name="Name" required/>
                    </p>
                    <strong><i class="fa fa-qrcode mr-1"></i> TIN #</strong>
                    <p class="text-muted">
                        <input type="text" class="form-control" name="TIN" required/>
                    </p>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6">
                            <strong><i class="fa fa-store-alt mr-1"></i> Vendor Type</strong>
                            <select class="supplierType-select form-control" name="SupplierType" required>
                                <option></option>
                                @foreach(\App\SupplierType::all() as $supplierType)
                                    <option value="{{ $supplierType->ID }}">{{ $supplierType->Description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <strong><i class="fa fa-dollar-sign mr-1"></i> Currency</strong>
                            <select class="currency-select form-control" name="Currency" required>
                                <option></option>
                                @foreach(\App\Currency::all() as $currency)
                                    <option value="{{ $currency->ID }}">{{ $currency->Code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6">
                            <strong><i class="fa fa-calendar-alt mr-1"></i> Classification</strong>
                            <select class="classification-select form-control" name="Classification" required>
                                <option></option>
                                <option value="L">Local</option>
                                <option value="F">Foreign</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <strong><i class="fa fa-calendar-alt mr-1"></i> Term and Credit</strong>
                            <select class="term-select form-control" name="Term" id="Term" required>
                                <option></option>
                                @foreach(\App\Term::all() as $term)
                                    <option value="{{ $term->ID }}">{{ $term->Description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <strong><i class="far fa-calendar-alt mr-1"></i> Ship Via</strong>

                            <select class="ship-via-select form-control" name="ShipVia" id="ShipVia" required>
                                <option></option>
                                @foreach(\App\ShippingMethod::all() as $shipVia)
                                    <option value="{{ $shipVia->ID }}">{{ $shipVia->Description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <strong><i class="fa fa-truck-moving mr-1"></i> Delivery Lead Time</strong>
                            <p class="text-muted mb-0 pb-0">
                                <input type="number" class="form-control" name="DeliveryLeadTime" required/>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-flat btn-fill btn-block btn-danger btn shadow" id='btnSave'>Save</button>
                        </div>
                        <div class="col-md-3">
                            <a href="/vendor" class="btn btn-flat btn-fill btn-block btn-secondary shadow">Cancel</a>
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
                        <input type="text" class="form-control" name="Contact"/>
                    </p>
                    <strong><i class="fa fa-address-card mr-1"></i> Address</strong>
                    <p class="text-muted">
                        <input type="text" class="form-control mb-1" name="AddressLine1" placeholder="Address Line 1"/>
                        <input type="text" class="form-control" name="AddressLine2" placeholder="Address Line 2"/>
                    </p>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-4">
                            <strong><i class="fa fa-flag-checkered mr-1"></i> City</strong>
                            <p class="text-muted mb-0">
                                <input type="text" class="form-control" name="City"/>
                            </p>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <strong><i class="fa fa-expand mr-1"></i> State</strong>
                            <p class="text-muted mb-0">
                                <input type="text" class="form-control" name="State"/>
                            </p>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <strong><i class="fa fa-flag mr-1"></i> Country</strong>
                            <p class="text-muted">
                                <input type="text" class="form-control" name="Country"/>
                            </p>
                        </div>
                        <div class="col-lg-3 col-md-1">
                            <strong><i class="fa fa-map-pin mr-1"></i> Zip</strong>
                            <p class="text-muted mb-0">
                                <input type="text" class="form-control" name="Zip"/>
                            </p>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-lg-4 col-md-4">
                            <strong><i class="fa fa-phone mr-1"></i> Telephone1</strong>
                            <p class="text-muted mb-0">
                                <input type="text" class="form-control" name="Telephone1"/>
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <strong><i class="fa fa-phone mr-1"></i> Telephone2</strong>
                            <p class="text-muted mb-0">
                                <input type="text" class="form-control" name="Telephone2"/>
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <strong><i class="fa fa-fax mr-1"></i> Fax Number</strong>
                            <p class="text-muted mb-0">
                                <input type="text" class="form-control" name="FaxNumber"/>
                            </p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6">
                            <strong><i class="fa fa-calendar-alt mr-1"></i> Email Address</strong>
                            <p class="text-muted mb-0">
                                <input type="email" class="form-control" name="Email"/>
                            </p>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <strong><i class="far fa-calendar-alt mr-1"></i> Website URL</strong>
                            <p class="text-muted mb-0">
                                <input type="text" class="form-control" name="WebSite"/>
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
<script src="{{ asset('js/papaparse.min.js') }}"></script>
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

        var $shipVia = $('.ship-via-select');
        $shipVia.select2({
            placeholder: 'Select Shipping Method',
            minimumResultsForSearch: -1
        });

        var $class = $('.classification-select');
        $class.select2({
            placeholder: 'Select Classification',
            minimumResultsForSearch: -1
        });


        $('#Code').on('input', function() {
            var code = $(this).val();
            if(code.length > 0) {
                $.get({
                    url: "/vendor/check/"+$(this).val(),
                    success: function(msg) {
                        if(msg) {
                            $('#Code').addClass('is-invalid');
                            $('#code-error').html('<b>'+code+'</b> already exists in the database.');
                            $('#btnSave').attr('disabled','disabled');
                        }
                        else {
                            $('#Code').removeClass('is-invalid');
                            $('#code-error').text('');
                            $('#btnSave').removeAttr('disabled');
                        }
                    }
                });
            }
            else {
                $('#Code').removeClass('is-invalid');
                $('#code-error').text('');
            }
        });








        $('#file-upload').on('change',function(file) {
//            var formData = new FormData();
//            formData.append('file', $('#file')[0].files[0]);
//
//
//            $.ajax({
//                url : 'upload.php',
//                type : 'POST',
//                data : formData,
//                processData: false,  // tell jQuery not to process the data
//                contentType: false,  // tell jQuery not to set contentType
//                success : function(data) {
//                    document.write(data);
//                    alert(data);
//                }
//            });

            var f = $(this)[0].files[0];
            Papa.parse(f, {
                complete: function(results) {
                    var Code = results.data[1][0];
                    var Name = results.data[1][1];
                    var Status = results.data[1][2];
                    var Contact = results.data[1][3];
                    var AddressLine1 = results.data[1][4];
                    var AddressLine2 = results.data[1][5];
                    var City = results.data[1][6];
                    var State = results.data[1][7];
                    var Zip = results.data[1][8];
                    var Country = results.data[1][9];
                    var SupplierType = results.data[1][10];
                    var Telephone1 = results.data[1][12];
                    var Telephone2 = results.data[1][13];
                    var FaxNumber = results.data[1][14];
                    var Email = results.data[1][15];
                    var WebSite = results.data[1][16];
                    var TIN = results.data[1][18];
                    //
                    var isCOD = results.data[1][22];
                    var isPrepaid = results.data[1][23];
                    //
                    var Term = results.data[1][24];
                    var Due = results.data[1][25];
                    console.log(Code);
                    console.log(Name);
                    console.log(isCOD);
                    console.log(isPrepaid);
                    parseDueForTerm(Due, isCOD, isPrepaid);
                    parseSupplierType(SupplierType);
                    $("input[name='Code']").val(Code);
                    $("input[name='Name']").val(Name);
                    $("input[name='Contact']").val(Contact);
                    $("input[name='AddressLine1']").val(AddressLine1);
                    $("input[name='AddressLine2']").val(AddressLine2);
                    $("input[name='City']").val(City);
                    $("input[name='State']").val(State);
                    $("input[name='Zip']").val(Zip);
                    $("input[name='Country']").val(Country);
                    $("input[name='Telephone1']").val(Country);
                    $("input[name='Telephone2']").val(Country);
                    $("input[name='FaxNumber']").val(FaxNumber);
                    $("input[name='Email']").val(Email);
                    $("input[name='WebSite']").val(WebSite);
                    $("input[name='TIN']").val(TIN);
                    $("input[name='Term']").val(Term);
                    $("input[name='Due']").val(Due);
                }
            });

        });

    });

    function parseDueForTerm(Due, isCOD, isPrepaid) {
        var out = "";
        if(Due==0 && isCOD=="TRUE") {
            out = "C.O.D.";
        }
        else if(Due==0 && isPrepaid=="TRUE") {
            out = "Prepaid";
        }
        else if(Due==0 && isPrepaid!="TRUE" && isCOD!="TRUE") {
            out = "Net Due"
        }
        else {
            out = "Net "+Due+" days";
        }

        var values = {
            "C.O.D." : 1,
            "Net 2 Days" : 2,
            "Net 7 Days" : 3,
            "Net 15 Days" : 4,
            "Net 30 Days" : 5,
            "Net Due" : 6,
            "Prepaid" : 7,
            "T/T In Advance" : 8,
            "Upon Completion" : 9,
        };

        $(".term-select").select2("val", values[out]);
    }

    function parseSupplierType(supplierType) {
        var values = {
            "AP P": 1,
            "AP $": 2,
            "AP LEWER": 3,
            "INTERCO": 4,
            "FREIGHT": 5,
            "REG EMP": 6,
            "RES EMP": 7,
            "OTHERS": 8
        };
        $(".supplierType-select").select2("val", values[supplierType]);
    }
</script>
@endsection