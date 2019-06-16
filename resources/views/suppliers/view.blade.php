@extends('templates.content',[
    'title'=>'View VendorDetails',
    'description'=>'Display information about the vendor.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Vendors','/vendor'),
        \App\Classes\Breadcrumb::create('View')
    ]
])
@section('title',sprintf('[%s] %s | VendorView', $data->Code, $data->Name))
@section('styles')
    <style>
        a {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        a:hover {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
    </style>
@endsection
@php
    $url = \Illuminate\Support\Facades\URL::current();
    $app_url = env('APP_URL');
    $edit_path = str_replace($app_url, "", $url);
    $edit_path = str_replace("view", "update", $edit_path);

    $name = explode(' ', $data->Name);
    $name = implode('-', $name);

@endphp
@section('content')

<div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
            <div class="card-header card-header-text">
                <h3 class="card-title"><strong>Vendor: </strong>[{{ $data->Code }}] {{ $data->Name }}</h3>
            </div>
            <div class="card-body" style="padding-bottom: 0px;">
                <div class="row">
                    <div class="col-md-12">
                        <form action="/category/toggle/{{$data->Identifier}}" method="post">
                            {{ csrf_field() }}
                            <a href="{{ $edit_path }}" class="btn btn-flat btn-fill btn-danger btn-sm">Edit</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <hr class="pt-0 mt-0">
                <strong><i class="fa fa-braille mr-1"></i> Code</strong>
                <p class="text-muted">
                    {{ $data->Code }}
                </p>
                <hr>
                <strong><i class="fa fa-edit mr-1"></i> Name</strong>
                <p class="text-muted">
                    {{ $data->Name }}
                </p>
                <hr>
                <strong><i class="fa fa-qrcode mr-1"></i> TIN</strong>
                <p class="text-muted">
                    {{ $data->TIN }}
                </p>
                <hr>
                <div class="row mb-0 pb-0">
                    <div class="col-lg-6 col-md-6">
                        <strong><i class="fa fa-store-alt mr-1"></i> VendorType</strong>
                        <p class="text-muted mb-0 pb-0">
                            {{ $data->SupplierType()->Description }}
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <strong><i class="fa fa-dollar-sign mr-1"></i> Currency</strong>
                        <p class="text-muted mb-0 pb-0">
                            {{ $data->Currency()->Code }}
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row mb-0 pb-0">
                    <div class="col-lg-6 col-md-6">
                        <strong><i class="fa fa-door-open mr-1"></i> Classification</strong>
                        <p class="text-muted mb-0 pb-0">
                            {{ $data->Classification=='L'?'Local':'Foreign' }} Vendor
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <strong><i class="fa fa-calendar-alt mr-1"></i> Term and Credit</strong>
                        <p class="text-muted mb-0 pb-0">
                            {{ $data->PaymenTerm()->Description }}
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row mb-0 pb-0">
                    <div class="col-lg-6 col-md-6">
                        <strong><i class="far fa-calendar-alt mr-1"></i> Ship Via</strong>
                        <p class="text-muted mb-0 pb-0">
                            {{ $data->ShippingMethod()->Description }}
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <strong><i class="fa fa-truck-loading mr-1"></i> Delivery Lead Time</strong>
                        <p class="text-muted">
                            {{ $data->DeliveryLeadTime }} days
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-12">
        <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
            <div class="card-header card-header-text">
                <h3 class="card-title"><strong>Additional Details: </strong>[{{ $data->Code }}] {{ $data->Name }}</h3>
            </div>
            <div class="card-body" style="padding-bottom: 0px;">
                <strong><i class="fa fa-user-circle mr-1"></i> Contact Person</strong>
                <p class="text-muted">
                    {{ $data->Contact }}
                </p>
                <hr>
                <strong><i class="fa fa-address-card mr-1"></i> Address</strong>
                <p class="text-muted">
                    {{ $data->AddressLine1 }} @if($data->AddressLine2), {{ $data->AddressLine2 }} @endif
                </p>
                <hr>
                <div class="row mb-0 pb-0">
                    <div class="col-lg-4 col-md-4">
                        <strong><i class="fa fa-flag-checkered mr-1"></i> City</strong>
                        <p class="text-muted mb-0">
                            {{ $data->City }}
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <strong><i class="fa fa-expand mr-1"></i> State</strong>
                        <p class="text-muted mb-0">
                            {{ $data->State }}
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <strong><i class="fa fa-map-pin mr-1"></i> Zip</strong>
                        <p class="text-muted mb-0">
                            {{ $data->Zip }}
                        </p>
                    </div>
                </div>
                <hr>
                <strong><i class="fa fa-flag mr-1"></i> Country</strong>
                <p class="text-muted">
                    {{ $data->Country }}
                </p>
                <hr>
                <div class="row mb-0 pb-0">
                    <div class="col-lg-4 col-md-4">
                        <strong><i class="fa fa-phone mr-1"></i> Telephone1</strong>
                        <p class="text-muted mb-0">
                            {{ $data->Telephone1 }}
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <strong><i class="fa fa-phone mr-1"></i> Telephone2</strong>
                        <p class="text-muted mb-0">
                            {{ $data->Telephone2 }}
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <strong><i class="fa fa-fax mr-1"></i> Fax Number</strong>
                        <p class="text-muted mb-0">
                            {{ $data->FaxNumber }}
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row mb-0 pb-0">
                    <div class="col-lg-6 col-md-6">
                        <strong><i class="fa fa-calendar-alt mr-1"></i> Email Address</strong>
                        <p class="text-muted mb-0">
                            {{ $data->Email }}
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <strong><i class="far fa-calendar-alt mr-1"></i> Website URL</strong>
                        <p class="text-muted mb-0">
                            {{ $data->WebSite }}
                        </p>
                    </div>
                </div>
                <hr>
                <strong><i class="fa fa-toggle-on mr-1"></i> Status</strong>
                <p class="text-muted">
                    {{ $data->Status?"Active":"Inactive" }}
                </p>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection