@extends('templates.content',[
    'title'=>'Purchase Request',
    'description'=>"View Purchase Request Details",
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Purchase Requests','/purchase-request'),
        \App\Classes\Breadcrumb::create("$data->OrderNumber")
    ]
])
@section('title',"Purchase Request $data->OrderNumber")
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icheck.square-red.css') }}">
    <style>
        .entry { display: none; }
        a {
            color: #000;
            text-decoration: none; /* no underline */
        }
        a:hover {
            color: #000;
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
        .collapsing {
            -webkit-transition: none;
            transition: none;
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="row">
<div class="col-lg-9 col-md-12">
    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
        <div class="card-header card-header-text">
            <div class="col-lg-12">
                <div class="row">
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;">
                        <strong>Purchase Request: </strong> {{ $data->OrderNumber }} &nbsp;
                    </h3>
                    @if($data->Status=='P')
                        <span class="badge flat badge-warning" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Pending First Approval</span>
                    @elseif($data->Status=='1')
                        <span class="badge flat badge-warning" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Pending for Approval</span>
                    @elseif($data->Status=='2')
                        <span class="badge flat badge-warning" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Pending First Approval</span>
                    @elseif($data->Status=='A')
                        <span class="badge flat badge-success" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Approved</span>
                    @elseif($data->Status=='Q')
                        <span class="badge flat badge-warning" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Pending Quotation/s</span>
                    @elseif($data->Status=='C')
                        <span class="badge flat badge-success" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Completed</span>
                    @elseif($data->Status=='O')
                        <span class="badge flat badge-success" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Ordered</span>
                    @elseif($data->Status=='X')
                        <span class="badge flat badge-dark" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Cancelled</span>
                    @else
                        <span class="badge flat badge-danger" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Voided</span>
                    @endif
                </div>
            </div>
        </div>
        @if($data->Status!='V')
            <div class="card-body clearfix">
                <div class="toolbar">
                    <!-- For Immediate Approver -->
                    @if((
                        $data->Approver1 == auth()->user()->ID
                        or
                        $data->Department()->Manager()->ID == auth()->user()->ID
                        or
                        auth()->user()->isAdministrator()
                        )
                        // and
                        // auth()->user()->ID != $data->ChargedTo()->Manager()->ID
                    )
                        @if($data->Status=='P')
                            <a class="btn flat btn-sm btn-simple" id="btnApprove1">
                                <span class="fa fa-check"></span>
                                <!---->Approve
                            </a>
                            <a href="/purchase-request/edit/{{ $data->OrderNumber }}" class="btn flat btn-sm btn-simple" style="color: black;" id="btnEdit">
                                <span class="fa fa-edit"></span>Edit
                            </a>
                        @endif
                    @endif
                    <!-- For Charged To Approver -->
                    @if(
                        $data->Approver2 == auth()->user()->Person()->ID
                        or
                        $data->ChargedTo()->Manager()->ID == auth()->user()->ID
                        or
                        auth()->user()->isAdministrator()
                    )
                        @if ($data->Status=='1' and 
                                ( $data->Approver1 == $data->Department()->Manager()->ID or 
                                  auth()->user()->isPurchasingManager() or
                                  $data->Approver1 == auth()->user()->ID
                                )
                            )
                            <a class="btn btn-sm flat btn-simple" id="btnApprove2">
                                <span class="fa fa-check"></span>
                                <!---->Approve
                            </a>
                        {{-- --}}
                        @endif
                    @endif
                    <!-- For Plant Manager -->
                    @if(auth()->user()->isPurchasingManager() and $data->isFullyQuoted())
                        @if($data->Status=='2')
                            <a class="btn btn-sm flat btn-simple" id="btnApprove3" style="color: #000;">
                                <span class="fa fa-check"></span>
                                <!---->Approve
                            </a>
                        @endif
                    @endif

                    @if($data->isFullyQuoted())
                        <a class="btn btn-sm flat btn-simple" id="btnDownload">
                            {{--target="_blank" href="/purchase-request/{{ $data->OrderNumber }}/canvasreport"--}}
                            <span class="fa fa-download"></span>
                            <!---->Download / View Canvass Report
                        </a>
                    @endif

                    @if($data->Status!='A' && $data->Status!='X')
                        <a class="btn btn-sm btn-flat btn-simple" id="btnVoid">
                            <span class="fa fa-ban"></span>
                            <!---->Cancel
                        </a>
                    @endif
                </div>
            </div>
        @endif
        <div class="card-body">

            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Requesting Department</label><br/>
                                <span>{{ $data->Department()->Name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Approver</label><br/>
                                <span>{{ $data->Approver1()->Name() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Charge To</label><br/>
                                <span>{{ $data->ChargedTo()->Name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Approver</label><br/>
                                <span>{{ $data->Approver2()->Name() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Filed By</label><br/>
                                <span>{{ $data->Requester()->Name() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Date Filed</label><br/>
                                <span>{{ $data->Date->format("M. d, Y") }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Purpose</label><br/>
                                <span>{{ $data->Purpose }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="mydiv">
                <div class="col-lg-12">
                    <table id="poTable" class="table table-striped table-no-bordered dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                        <thead>
                        <tr role="row">
                            @if(\Illuminate\Support\Facades\Auth::user()->isPurchasingManager())
                                <th></th>
                            @endif
                            <th style="width: 40%;">Item</th>
                            <th style="width: 25%" class="text-right">Preferred Quote</th>
                            {{--<th style="width: 30%">GL Code</th>--}}
                            <th class="text-right">Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tbody class="productTable">
                        @foreach($data->LineItems() as $lineItem)
                            @php
                                $product = $lineItem->Product();
                                $name = explode(' ', $product->Name);
                                $name = implode('-', $name);

                            @endphp
                            <tr>
                                @if(\Illuminate\Support\Facades\Auth::user()->isPurchasingManager())
                                    <td class="align-middle"><a class="alert-link" data-toggle="collapse" data-target="#demo{{$loop->index}}" id="toggle-menu"><i class="nav-icon fa fa-expand details"></i></a></td>
                                @endif
                                <td class="align-middle">
                                    <a href="/product/view/{{ $lineItem->Product()->UniqueID }}">
                                        [{{ $lineItem->Product()->UniqueID }}] {{ $lineItem->Product()->Description }}
                                    </a>
                                </td>
                                <td class="text-right align-middle">
                                    @php
                                        if($lineItem->Quoted) {
                                            $quote = $lineItem->OrderItem()->SelectedQuote();
                                            echo "{$quote->Currency()->Code} {$quote->Amount}";
                                        }
                                        else {
                                            if($quote = $lineItem->Product()->PreferredQuote()) {
                                                echo "Awaiting Preferred Quote";
                                            } else {
                                                echo "No Quote Available";
                                            }
                                        }

                                    @endphp
                                </td>
                                {{--<td class="align-middle">[{{ $lineItem->GeneralLedger()->Code }}] {{ $lineItem->GeneralLedger()->Description }}</td>--}}
                                <td class="text-right align-middle">{{ round($lineItem->Quantity, 2) }} {{ $lineItem->Product()->UOM()->Abbreviation }}</td>
                            </tr>
                            <tr id="demo{{$loop->index}}" class="collapse">
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
                                                    <a href="/quote/document/{{ $quote->FileName }}" class="" target="_blank">View / Download</a>
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Remarks" class="control-label">Remarks</label>
                                <div class="col-lg-12">
                                    @php
                                        $remarks = json_decode($data->Remarks, true);
                                    @endphp
                                    @if(isset($remarks['data']))
                                        @foreach($remarks['data'] as $entry)
                                            <div class="row">
                                                [{{ \Carbon\Carbon::parse($entry['time'])->format("M. d, Y | h:i A") }}]
                                                [{{ \App\User::find($entry['userid'])->Username }}]:
                                                {{ $entry['message'] }}
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
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
                        {{ \App\Classes\IssuanceHelper::ParseLog($log) }}
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
@endsection
@section('scripts')
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script type="text/javascript">

        $('input[type="radio"]').iCheck({
            radioClass: 'iradio_square-red'
        });
        $('#btnApprove1').on('click',function(){
            swal({
                html: true,
                title: 'Confirm Action',
                text: "<html>Do you wish to approve<br/> Purchase Request [{{ $data->OrderNumber }}]?<br/><br/>"+
                "<textarea " +
                "id='Remarks'" +
                "class='form-control flat' " +
                "placeholder='Add some notes here.' " +
                "style='resize: none;' " +
                "rows='3'></textarea>" +
                "</html>",
                type: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonColor: '#DC3545',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },function(x){
                if(x) {
                    var remarks = $("#Remarks").val();
                    var request = $.ajax({
                        method: "POST",
                        url: "/purchase-request/{{ $data->OrderNumber }}/toggle",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { Remarks: remarks }
                    });

                    request.done(function(x){
                        console.log(x);
                        window.location = window.location.pathname;
                    });
                } else {

                }
            });
        });


        $('#btnApprove2').on('click', function(){
            swal({
                html: true,
                title: 'Confirm Action',
                text: "<html>Do you wish to approve<br/> Purchase Request [{{ $data->OrderNumber }}]?<br/><br/>"+
                "<textarea " +
                "id='Remarks'" +
                "class='form-control flat' " +
                "placeholder='Add some notes here.' " +
                "style='resize: none;' " +
                "rows='3'></textarea>" +
                "</html>",
                type: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonColor: '#DC3545',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },function(x){
                if(x) {
                    var remarks = $("#Remarks").val();
                    var request = $.ajax({
                        method: "POST",
                        url: "/purchase-request/{{ $data->OrderNumber }}/toggle",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { Remarks: remarks }
                    });

                    request.done(function(x){
                        console.log(x);
                        window.location = window.location.pathname;
                    });
                } else {

                }
            });
        });


        $('#btnApprove3').on('click', function(){
            swal({
                html: true,
                title: 'Confirm Action',
                text: "<html>Do you wish to give <strong><span style='color: red;'>final approval</span></strong> for<br/>Requisition Request [{{ $data->OrderNumber }}]?<br/><br/>"+
                "<textarea " +
                "id='Remarks'" +
                "class='form-control flat' " +
                "placeholder='Add some notes here.' " +
                "style='resize: none;' " +
                "rows='3'></textarea>" +
                "</html>",
                type: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonColor: '#DC3545',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },function(x){
                if(x) {

                    var remarks = $("#Remarks").val();
                    var request = $.ajax({
                        method: "POST",
                        url: "/purchase-request/{{ $data->OrderNumber }}/toggle",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { Remarks: remarks }
                    });

                    request.done(function(x){
                        console.log(x);
                        window.location = window.location.pathname;
                    });
                } else {

                }
            });
        });

        $('#btnVoid').on('click', function(){
            swal({
                title: 'Cancel PO {{ $data->OrderNumber }}?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
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
                    $.post("/purchase-request/{{ $data->OrderNumber }}/void")
                        .done(function(){
                            window.location = window.location.pathname;
                        });
                }
            });
        });

        $("#btnDownload").on("click",function(){
            window.open('/purchase-request/{{ $data->OrderNumber }}/download','_blank');
        });
    </script>
@endsection