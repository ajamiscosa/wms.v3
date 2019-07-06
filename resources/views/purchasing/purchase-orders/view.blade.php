@extends('templates.content',[
    'title'=>"Purchase Order : $data->OrderNumber",
    'description'=>"View Purchase Order Details",
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Purchase Order','/purchase-order'),
        \App\Classes\Breadcrumb::create("$data->OrderNumber")
    ]
])
@section('title',"Purchase Order: $data->OrderNumber")
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icheck.square-red.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker3.css') }}">
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
        .bar {
            width: 8px;
            margin: 1px;
            display: inline-block;
            position: relative;
            vertical-align: baseline;
        }
    </style>
@endsection
@section('content')
    <input type="hidden" id="OrderNumber" value="{{ $data->OrderNumber }}">
    <form method="post" action="/purchase-order/{{$data->OrderNumber}}/approve" id="poForm">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-9 col-md-12">
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-8 pt-2 pb-1">
                                    <div class="row">
                                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">
                                            <strong>Purchase Order: </strong> {{ $data->OrderNumber }} &nbsp;
                                        </h3>
                                        @if($data->Status=='P')
                                            <span class="badge flat badge-warning" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Pending Purchasing Manager's Approval</span>
                                        @elseif($data->Status=='1')
                                            <span class="badge flat badge-warning" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Pending Operations Manager's Approval</span>
                                        @elseif($data->Status=='2')
                                            <span class="badge flat badge-warning" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Pending Plant Manager's Approval</span>
                                        @elseif($data->Status=='3')
                                            <span class="badge flat badge-warning" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Pending General Manager's Approval</span>
                                        @elseif($data->Status=='A')
                                            <span class="badge flat badge-success" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Approved</span>
                                        @elseif($data->Status=='D')
                                            <span class="badge flat badge-danger" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Draft</span>
                                        @elseif($data->Status=='X')
                                            <span class="badge flat badge-dark" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Rejected</span>
                                        @else
                                            <span class="badge flat badge-danger" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Voided</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header card-header-text">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 xwrapper">
                                <strong><i class="fa fa-store-alt mr-1"></i> Vendor :</strong><div class="bar" style=""></div>
                                <a href="/vendor/view/{{$data->Supplier()->Code}}">
                                    [<strong>{{$data->Supplier()->Code}}</strong>] {{ $data->Supplier()->Name }}
                                </a>
                            </div>
                            
                            @if($data->Status == 'A')
                                <div class="col-lg-6 col-md-12 pr-0">
                                    {{-- <a class="btn btn-simple btn-sm btn-flat float-right" id="downloadPO" rel="{{ $data->OrderNumber }}">Download Purchase Order Form</a> --}}
                                    <a 
                                        class="btn btn-simple btn-sm btn-flat float-right" 
                                        id="downloadPO" 
                                        rel="{{ $data->OrderNumber }}"
                                        href="/purchase-order/{{ $data->OrderNumber }}/download"
                                        target="_new"
                                    >Download Purchase Order Form
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-user-tag mr-1"></i> Filed By</strong>
                                    <span class="xwrapper">
                                    <p class="text-muted pt-2 mb-0">
                                        {{ $data->Requester()->Person()->Name() }}
                                    </p>
                                </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-calendar-alt mr-1"></i> Date Filed</strong>
                                    <span class="xwrapper">
                                    <p class="text-muted pt-2 mb-0">
                                        <span>{{ $data->OrderDate->format('F d, Y') }}</span>
                                    </p>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-money-check-alt mr-1"></i> AP G/L Account</strong>
                                    <p class="text-muted">
                                        <span>
                                            @php
                                                $gl = new \App\GeneralLedger();
                                                $gl = $gl->where('ID','=',$data->APAccount)->first();
                                                echo "[$gl->Code] $gl->Description";
                                            @endphp
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-truck-loading mr-1"></i> Expected Delivery Date</strong>
                                    <p class="text-muted">
                                        <span>{{ $data->DeliveryDate->format('F d, Y') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-clipboard-list mr-1"></i> Payment Term</strong>
                                    <p class="text-muted">
                                        <span>
                                            @php
                                                $term = new \App\Term();
                                                $term = $term->where('ID','=',$data->PaymentTerm)->firstOrFail();
                                                echo "$term->Description";
                                            @endphp
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong><i class="fa fa-money-check-alt mr-1"></i> Charge Type</strong>
                                    <p class="text-muted">
                                        <span>
                                            {{$data->ChargeType=="S"?"Stock":"Department"}}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 pl-1 pr-1">
                                <table id="poTable" class="table table-striped table-no-bordered dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                                    <thead>
                                    <tr role="row">
                                        <th>&nbsp;</th>
                                        <th style="width: 25%;">Item</th>
                                        <th style="width: 15%" class="text-right">Approved Quote</th>
                                        <th style="width: 30%">GL Code</th>
                                        <th class="text-right">Quantity</th>
                                        <th class="text-right" style="white-space: nowrap;">Sub-total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tbody class="productTable">
                                    @foreach($data->OrderItems() as $orderItem)
                                        @php
                                            $lineItem = $orderItem->LineItem();
                                            $product = $lineItem->Product();
                                            $name = explode(' ', $product->Name);
                                            $name = implode('-', $name);
                                            $uom = $product->UOM()!=null?$product->UOM()->Abbreviation:"";
                                        @endphp
                                        <tr>
                                            <td>
                                                <a class="alert-link toggle-buttonshit" data-toggle="collapse" data-target="#demo{{$loop->index}}" id="toggle-menu">
                                                    <i class="nav-icon fa fa-angle-right details"></i>
                                                </a>
                                            </td>
                                            <td class="align-middle">
                                                <a href="/product/view/{{ $product->UniqueID }}">
                                                    {{ $product->Description }}
                                                </a>
                                            </td>
                                            <td class="text-right align-middle">
                                                @php
                                                    if($orderItem->SelectedQuote()) {
                                                        $quote = $orderItem->SelectedQuote();
                                                        echo "{$quote->Currency()->Code} {$quote->Amount}";
                                                    } else {
                                                        echo "No Quote Available";
                                                    }
                                                @endphp
                                            </td>
                                            <td class="align-middle">[{{ $lineItem->Product()->getGeneralLedger()->Code }}] {{ $lineItem->Product()->getGeneralLedger()->Description }}</td>
                                            <td class="text-right align-middle">{{ round($lineItem->Quantity, 2) }} {{ $product->UOM()->Abbreviation }}</td>
                                            <td class="text-right align-middle">{{ $quote->Currency()->Code }} {{ number_format(($quote->Amount*$lineItem->Quantity),2,'.',',') }}</td>
                                        </tr>
                                        <tr id="demo{{$loop->index}}" class="collapse">
                                            <td colspan="100%">
                                                <div class="row">
                                                    <div class="col-lg-6 col-sm-12 pr-0 pt-0 pl-0 pb-0">
                                                        <table width="100%">
                                                            <tr>
                                                                <th class="text-right">Available</th>
                                                                <th class="text-right">Reserved</th>
                                                                <th class="text-right" style="white-space: nowrap;">Incoming</th>
                                                            </tr>
                                                            <tr>               
                                                                <td class="text-right">{{ sprintf('%d %s',($product->getAvailableQuantity()), $uom) }}</td>
                                                                <td class="text-right">{{ sprintf('%d %s',($product->getReservedQuantity()), $uom) }}</td>
                                                                <td class="text-right">{{ sprintf('%d %s',($product->getIncomingQuantity()), $uom) }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-12 pr-0 pt-0 pl-1 pb-0">
                                                        <table width="100%">
                                                            <tr>
                                                                <th class="text-center" colspan="3">Last Date of Purchase</th>
                                                            </tr>
                                                            <tr>
                                                                @php
                                                                    $thisPO = \App\PurchaseOrder::findPObyOrderNumber($data->OrderNumber);
                                                                    $lastPO = null;
                                                                    $poList = $product->getPurchaseOrders();
                                                                    \App\Classes\Helper::removeObjectFromArray($poList, 'OrderNumber', $thisPO->OrderNumber);
                                                                    
                                                                    if(count($poList)>0) {
                                                                        for($i=0;$i<count($poList);$i++) {
                                                                            if($i-1>=0) {
                                                                                $lastPO = $poList[$i-1];
                                                                            }
                                                                            else {
                                                                                $lastPO = null;
                                                                            }
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if($lastPO)
                                                                    <td class="text-center">{{ $lastPO->Supplier()->Name }}</td>
                                                                    <td class="text-center">{{ $lastPO->OrderDate->format('F d, Y')??"N/A" }}</td>
                                                                    <td class="text-center">
                                                                        @foreach($lastPO->OrderItems() as $orderItem)
                                                                            @if($orderItem->LineItem()->Product()->ID == $product->ID)
                                                                                {{ $orderItem->SelectedQuote()->Currency()->Code }} {{ $orderItem->SelectedQuote()->Amount }}
                                                                            @else
                                                                                @continue
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">N/A</td>
                                                                @endif
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                                {{-- @include('templates.rsitemsub',['data'=>$product]) --}}
                                        </tr>
                                        {{-- <tr id="demo{{$loop->index}}" class="collapse">
                                            <td colspan="100%">
                                                <!-- WIP: -->
                                                @if(count($product->ValidQuotes())>0)
                                                    @foreach($product->ValidQuotes() as $quote)
                                                        <div class="row">
                                                            <div class="col-lg-5">
                                                                [{{ $quote->Supplier()->Code }}] {{ $quote->Supplier()->Name }}
                                                            </div>
                                                            <div class="col-lg-2 text-right">
                                                                {{ $quote->Currency()->Code }} {{ $quote->Amount }}
                                                            </div>
                                                            <div class="col-lg-2 text-right">
                                                                <a href="">Download</a>
                                                            </div>
                                                        </div>
                                                        @if(!$loop->last)
                                                            <hr/>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <div>
                                                        No Quote Available
                                                    </div>
                                                @endif
                                            </td>
                                        </tr> --}}
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($data->Status != 'X')
                        <hr>
                        <div class="row">
                            <div class="col-lg-12" style="display: inline-flex;">
                                <div class="col-md-3 col-lg-3">
                                    <div class="row pb-2">Prepared By:</div>
                                    @include('templates.approved', [
                                        'date'=>$data->PurchasingManager,
                                        'isApprover'=>auth()->user()->isPurchasingManager(),
                                        'status'=>$data->Status,
                                        'expected'=>'P'
                                    ])
                                    <div class="row" style="display: block; vertical-align: middle; text-align: center;">
                                        <strong>
                                            @php
                                                try {
                                                    $user = \App\Role::FindUserWithRole("PurchasingManager");
                                                    if($user!==null) {
                                                        $person = $user->Person();
                                                        echo "$person->FirstName $person->LastName";
                                                    } else {
                                                        echo "&nbsp;";
                                                    }
                                                }
                                                catch(Exception $exception) {
                                                    echo "N/A";
                                                }
                                            @endphp
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="row pb-2">Checked By:</div>
                                    @include('templates.approved', [
                                        'date'=>$data->OperationsManager,
                                        'isApprover'=>auth()->user()->isOperationsDirector(),
                                        'status'=>$data->Status,
                                        'expected'=>'1'
                                    ])
                                    <div class="row" style="display: block; vertical-align: middle; text-align: center;">
                                        <strong>
                                            @php
                                                try {
                                                    $user = \App\Role::FindUserWithRole("OperationsDirector");
                                                    if($user!==null) {
                                                        $person = $user->Person();
                                                        echo "$person->FirstName $person->LastName";
                                                    } else {
                                                        echo "&nbsp;";
                                                    }
                                                }
                                                catch(Exception $exception) {
                                                    echo "N/A";
                                                }
                                            @endphp
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="row pb-2">Approved By:</div>
                                    @include('templates.approved', [
                                        'date'=>$data->PlantManager,
                                        'isApprover'=>auth()->user()->isPlantManager(),
                                        'status'=>$data->Status,
                                        'expected'=>'2'
                                    ])
                                    <div class="row" style="display: block; vertical-align: middle; text-align: center;">
                                        <strong>
                                            @php
                                                try {
                                                    $user = \App\Role::FindUserWithRole("PlantManager");
                                                    if($user!==null) {
                                                        $person = $user->Person();
                                                        echo "$person->FirstName $person->LastName";
                                                    } else {
                                                        echo "&nbsp;";
                                                    }
                                                }
                                                catch(Exception $exception) {
                                                    echo "N/A";
                                                }
                                            @endphp
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="row pb-2">Approved By:</div>
                                    @include('templates.approved', [
                                        'date'=>$data->GeneralManager,
                                        'isApprover'=>auth()->user()->isGeneralManager(),
                                        'status'=>$data->Status,
                                        'expected'=>'3'
                                    ])
                                    <div class="row" style="display: block; vertical-align: middle; text-align: center;">
                                        <strong>
                                            @php
                                            try {
                                                $user = \App\Role::FindUserWithRole("GeneralManager");
                                                if($user!==null) {
                                                    $person = $user->Person();
                                                    echo "$person->FirstName $person->LastName";
                                                } else {
                                                    echo "&nbsp;";
                                                }
                                            }
                                            catch(Exception $exception) {
                                                echo "N/A";
                                            }
                                            @endphp
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <hr class="mb-2"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group remarks">
                                        <div class="row">
                                            <label for="Remarks" class="control-label">Remarks</label>
                                            <textarea id="Remarks" class="form-control flat" style="resize: none;" rows="3" name="Remarks" required></textarea>
                                        </div>

                                        @php
                                            $remarks = json_decode($data->Remarks, true);
                                        @endphp
                                        @foreach($remarks['data'] as $entry)
                                            <div class="row">
                                                [{{ \Carbon\Carbon::parse($entry['time'])->format("M. d, Y | h:i A") }}]
                                                [{{ \App\User::find($entry['userid'])->Username }}]:
                                                {{ $entry['message'] }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12">
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <div class="col-lg-12">
                            <div class="row">
                                <h3 class="card-title" style="padding-top: 0; margin-top: 0;">
                                    <strong>Logs</strong>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($data->Logs() as $log)
                            <div class="row">
                                <div class="col-lg-5 col-md-6 col-sm-6">
                                    {{ $log->created_at }}
                                </div>
                                <div class="col-lg-7 col-md-6 col-sm-6">
                                    {{ \App\Classes\PurchaseOrderHelper::ParseLog($log) }}
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr style="margin-top: 5px; margin-bottom: 5px;"/>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>

    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/html2canvas.min.js') }}"></script>
    <script src="{{ asset('js/jspdf.min.js') }}"></script>

    <script>

//         $(document).ready(function () {
//             $('#downloadPO').on('click', function(){
//                 var rr = $(this).attr('rel');
//                 $.ajax({
//                     url: "/purchase-order/"+rr+"/download",
//                     cache: false,
//                     success: function(content){
// //                        var win = window.open("", "Title",
// //                            "toolbar=no," +
// //                            "location=no," +
// //                            "directories=no," +
// //                            "status=no," +
// //                            "menubar=no," +
// //                            "scrollbars=yes," +
// //                            "resizable=yes," +
// //                            "width=765," +
// //                            "height=990,");
// //                        win.document.body.innerHTML = content;
//                         var win = PopupCenter("", "Print Preview", 850,768);
//                         win.document.body.innerHTML = content;
// //
//                         var $content = win.document.querySelector('#capture #capture2');

//                         html2canvas($content,{
//                             onrendered: function (canvas) {
//                                 win.document.body.innerHTML = "<html><head><title>"+rr+"</title><link rel='stylesheet' href='{{asset('css/custom.css')}}'/><link rel='stylesheet' href='{{asset('css/fontawesome-all.min.css')}}'/></head><a role='button' onclick='window.print(); return false;' class='float'><i class='fa fa-print my-float'></i></a></html>";
//                                 win.document.body.appendChild(canvas);
// //                                var imgData = canvas.toDataURL(
// //                                    'image/png');
// //                                var doc = new jsPDF('p', 'in', [8.5, 11]);
// //                                doc.addImage(imgData, 'PNG', 0, 0);
// //                                doc.save(rr+'.pdf');
//                             }
//                         });

//                     }
//                 });
//             });


//         });


        $('.toggle-buttonshit').on('click', function(){
            $(this).find('.fa').toggleClass('fa-angle-down fa-angle-right');
        });

        function PopupCenter(url, title, w, h) {
            // Fixes dual-screen position                         Most browsers      Firefox
            var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
            var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

            var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
            var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

            var systemZoom = width / window.screen.availWidth;
            var left = (width - w) / 2 / systemZoom + dualScreenLeft
            var top = (height - h) / 2 / systemZoom + dualScreenTop
            var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w / systemZoom + ', height=' + h / systemZoom + ', top=' + top + ', left=' + left);

            // Puts focus on the newWindow
            if (window.focus) newWindow.focus();
            return newWindow;
        }
        
        $(document).ready(function() {
            $("#poForm").on('submit', function(e){
                e.preventDefault();
                var x = swal({
                    title: 'Submit {{ $data->OrderNumber }}?',
                    text: "Do you wish to approve {{ $data->OrderNumber }}?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                },function(x){
                    if(x) {
                        $( "#poForm" )[0].submit();
                    } else {
                        e.preventDefault();
                    }
                });
            });

            $('#btnRejectPO').on('click', function(e){
                var orderNumber = $('#OrderNumber').val();
                var remark = $('#Remarks').val();
                if(remark.length>0) {
                    
                    e.preventDefault();
                    var x = swal({
                        title: 'Reject Order Number '+orderNumber+'?',
                        text: "Do you wish to reject "+orderNumber+"?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#DC3545',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    },function(x){
                        if(x) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.post("/purchase-order/"+orderNumber+"/reject")
                                .done(function(){
                                    window.location = window.location.pathname;
                                }
                            );
                        } else {
                            e.preventDefault();
                        }
                    });
                }
                else {
                    $("#poForm").get(0).reportValidity();
                }
            });
        })

        // $('#downloadPO').on('click', function(){
        //     window.open('/purchase-order/{{ $data->OrderNumber }}/download','_blank');
        // });
    </script>
@endsection