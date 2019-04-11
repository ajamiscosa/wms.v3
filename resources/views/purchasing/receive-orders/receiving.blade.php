@extends('templates.content',[
    'title'=>"Receiving of Purchase Orders",
    'description'=>"Acknowledge Receipt of Items for Purchase Order",
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Receive Orders','/receive-order'),
        \App\Classes\Breadcrumb::create('Receiving')
    ]
])
@section('title',"Receiving")
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <style>
        .entry { display: none; }
        a {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        a:hover {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        .card-title {
            padding-top: 4px;
            height: 27px;
            line-height: 27px;
        }

        .btn-simple {
            border: 1px solid #D7D7D7;
        }

        .badge {
            padding: 5px 5px 5px 5px;
        }

        .xwrapper {
            display : flex;
            align-items : center;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-10" id="content">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->

                <div class="card-header p-2">
                    <h4 class="card-title" style="display: inline-block">Purchase Order</h4>
                </div><!-- /.card-header -->


                <div class="card-body">
                    <form method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-user-tag mr-1"></i> Filed By</strong>
                                    <span class="xwrapper">
                                        <p class="text-muted pt-2 mb-0" id="Requester">

                                        </p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-calendar-alt mr-1"></i> Date Filed</strong>
                                    <span class="xwrapper">
                                        <p class="text-muted pt-2 mb-0" id="DateFiled">

                                        </p>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-money-check-alt mr-1"></i> AP G/L Account</strong>
                                    <span class="xwrapper">
                                        <p class="text-muted pt-2 mb-0" id="GLAccount">

                                        </p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-truck-loading mr-1"></i> Expected Delivery Date</strong>
                                    <span class="xwrapper">
                                        <p class="text-muted pt-2 mb-0" id="DeliveryDate">

                                        </p>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-clipboard-list mr-1"></i> Payment Term</strong>
                                    <span class="xwrapper">
                                        <p class="text-muted pt-2 mb-0" id="PaymentTerm">

                                        </p>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-money-check-alt mr-1"></i> Charge Type</strong>
                                    <span class="xwrapper">
                                        <p class="text-muted pt-2 mb-0" id="ChargeType">

                                        </p>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="mydiv">
                            <div class="col-lg-12">
                                <table id="poTable" class="table table-no-bordered dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="width: 50%;">Item</th>
                                        <th>G/L Code</th>
                                        <th>Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--<tbody class="productTable">--}}
                                    {{--@php($totalRemaining = 0)--}}
                                    {{--@foreach($data->OrderItems() as $item)--}}
                                        {{--@php--}}
                                            {{--$lineItem = $item->LineItem();--}}
                                            {{--$product = $lineItem->Product();--}}
                                            {{--$totalRemaining+=$lineItem->getRemainingDeliverableQuantity();--}}

                                        {{--@endphp--}}
                                        {{--<input type="hidden" name="OrderItem[]" value="{{ $item->ID }}">--}}
                                        {{--<tr>--}}
                                            {{--<td class=" pt-0 pb-0 mt-0 mb-0 align-middle">--}}
                                                {{--<a href="/product/view/{{ $product->UniqueID }}">--}}
                                                    {{--[{{ $product->UniqueID }}] {{ $product->Description }}--}}
                                                {{--</a>--}}
                                            {{--</td>--}}
                                            {{--<td class=" pt-0 pb-0 mt-0 mb-0 align-middle">[{{ $lineItem->GeneralLedger()->Code }}] {{ $lineItem->GeneralLedger()->Description }}</td>--}}
                                            {{--<td>--}}
                                                {{--<div class="input-group my-colorpicker2 colorpicker-element float-right">--}}
                                                    {{--@if($lineItem->getRemainingReceivableQuantity()>0)--}}
                                                        {{--<input class="form-control text-right middle-dis" type="number" name="Quantity[]" max="{{$lineItem->getRemainingReceivableQuantity()}}" style="max-width: 100px;" required/>--}}
                                                        {{--<div class="input-group-append middle-dis xwrapper">--}}
                                                            {{--<span class="middle-dis ml-3">/ {{ round($lineItem->getRemainingDeliverableQuantity(), 2) }} {{ $product->UOM()->Abbreviation }}</span>--}}
                                                        {{--</div>--}}
                                                    {{--@else--}}
                                                        {{--<span>Completed</span>--}}
                                                    {{--@endif--}}
                                                {{--</div>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}
                                    {{--@endforeach--}}
                                    {{--</tbody>--}}
                                </table>
                            </div>
                        </div>
                        @if($totalRemaining=0)
                            <hr class="pt-0 mt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="Receiver" class="control-label">Received By</label>
                                                <input type="text" class="form-control flat" name="Receiver" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                                <label for="Receiver" class="control-label">Invoice DR / Reference No.</label>
                                                <input type="text" class="form-control flat" name="ReferenceNumber" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Remarks" class="control-label">Remarks</label>
                                                <textarea class="form-control flat" style="resize: none;" rows="3" name="Remarks"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row float-right">
                                <div class="col-md-12">
                                    <input type="submit" class="btn flat btn-danger btn-md" value="Save">
                                    <a href="/rs" class="btn btn-flat btn-default btn-md">Cancel</a>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->

                <div class="card-header p-2">
                    <h4 class="card-title" style="display: inline-block">Pending Purchase Order</h4>
                </div><!-- /.card-header -->

                <div class="card-body">
                    <select style="width: 100%; overflow: auto; font-size: 18px; outline: none;" size="10" id="pendingOrderSelect">
                        @foreach(\App\PurchaseOrder::all() as $po)
                            @if($po->Status == 'A' and $po->getRemainingDeliverableQuantity()>0)
                                <option value="{{ $po->OrderNumber }}">{{ $po->OrderNumber }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('js/loadingoverlay.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ajaxStart(function(){
            $.LoadingOverlay("show");
        });
        $(document).ajaxStop(function(){
            $.LoadingOverlay("hide");
        });

        $("#pendingOrderSelect").on('change', function() {
            var orderNumber = $(this).val();

            var x = $.ajax({type: "GET", url: "/purchase-order/"+orderNumber+"/data", async: false}).responseText;
            $('#content').html(x);
        });

//        $(document).on('submit', '#submitReceiveForm', function(e) {
//            e.preventDefault();
//
//        });

        $('#submitReceiveForm').submit();
//
//        $(document).on('click', '#btnReceive', function(e){
//            e.preventDefault();
//            swal({
//                type: 'success',
//                title: 'Success',
//                text: "Transaction Processed Successfully",
//                confirmButtonColor: '#DC3545',
//                allowOutsideClick: false,
//                closeOnConfirm : true
//            }, function(x) {
//                if(x) {
//                    $('#submitReceiveForm').submit();
//                    window.location = "/receive-order";
//                } else {
//                    return false;
//                }
//            });
//        });
    </script>
@endsection