@extends('templates.content',[
    'title'=>'Issuance Request',
    'description'=>"View Issuance Request Details",
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Issuance Requests','/issuance-request'),
        \App\Classes\Breadcrumb::create("$data->OrderNumber")
    ]
])
@section('title',"Issuance $data->OrderNumber")
@section('styles')
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
                        <strong>Issuance Request: </strong> {{ $data->OrderNumber }} &nbsp;
                    </h3>
                    @if($data->Status=='P')
                        <span class="badge flat badge-warning" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Pending First Approval</span>
                    @elseif($data->Status=='1')
                        <span class="badge flat badge-warning" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Pending Approval</span>
                    @elseif($data->Status=='A')
                        <span class="badge flat badge-success" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Approved</span>
                    @elseif($data->Status=='X')
                        <span class="badge flat badge-dark" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Expired</span>
                    @else
                        <span class="badge flat badge-danger" style="margin-top: 5px; padding-top: 0; vertical-align: middle; height: 18px; line-height: 18px; text-align: center;">Voided</span>
                    @endif
                </div>
            </div>
        </div>
        @if($data->Status!='V')
            <div class="card-body clearfix">
                <div class="toolbar">
                    @if(
                        auth()->user()->Person()->ID == $data->Approver1 // check if user is one of the approvers.
                        or
                        auth()->user()->isAdministrator() //admins can overrule anybody.
                    )
                        @if($data->Status=='P')
                            <a class="btn flat btn-sm btn-simple" id="btnApprove1">
                                <span class="fa fa-check"></span>Approve
                            </a>
                            <a href="/issuance-request/edit/{{ $data->OrderNumber }}" class="btn flat btn-sm btn-simple" style="color: black;" id="btnEdit">
                                <span class="fa fa-edit"></span>Edit
                            </a>
                            <a class="btn flat btn-sm btn-simple" id="btnCancel">
                                <span class="fa fa-ban pr-1"></span>Cancel
                            </a>
                        @endif

                    @endif
                    @if(
                        auth()->user()->Person()->ID == $data->Approver1 // check if user is one of the approvers.
                        or
                        auth()->user()->isAdministrator() //admins can overrule anybody.
                        or
                        auth()->user()->isAuthorized('BypassTransactions','M') // overrule bypass Role
                    )
                        @if($data->Status=='1')
                            <a class="btn btn-sm flat btn-simple" id="btnApprove2">
                                <span class="fa fa-check"></span>
                                <!---->Approve
                            </a>
                            {{--<a href="/issuance-request/edit/{{ $data->OrderNumber }}" class="btn flat btn-sm btn-simple" style="color: black;" id="btnEdit">--}}
                                {{--<span class="fa fa-edit"></span>Edit--}}
                            {{--</a>--}}

                            <a class="btn flat btn-sm btn-simple" id="btnCancel">
                                <span class="fa fa-ban pr-1"></span>Cancel
                            </a>
                        @endif

                    @endif

                    @if(auth()->user()->isAuthorized('Products','M'))
                        <a class="btn flat btn-sm btn-simple" id="btnCancel">
                            <span class="fa fa-ban pr-1"></span>Cancel
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
                                <label class="control-label">Department</label><br/>
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
                                <span>{{ $data->Date->format("M. d, Y | h:i A") }}</span>
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
                    <table id="poTable" class="table table-no-bordered dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                        <thead>
                        <tr role="row">
                            <th style="width: 50%;">Item</th>
                            <th>G/L Code</th>
                            <th class="text-right">Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tbody class="productTable">
                        @foreach($data->LineItems() as $item)
                            <tr>
                                <td>
                                    <a href="/product/view/{{ $item->Product()->UniqueID }}">
                                        [{{ $item->Product()->UniqueID }}] {{ $item->Product()->Description }}
                                    </a>
                                </td>
                                <td>[{{ $item->GeneralLedger()->Code }}] {{ $item->GeneralLedger()->Description }}</td>
                                <td class="text-right">{{ round($item->Quantity, 2) }} {{ $item->Product()->UOM()->Abbreviation }}</td>
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
                                    @if(count($remarks['data'])>0)
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
        <div class="card-footer">
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
    <script type="text/javascript">
        $('#btnApprove1').on('click',function(){
            swal({
                html: true,
                title: 'Confirm Action',
                text: "<html>Do you wish to approve<br/> Requisition Request [{{ $data->OrderNumber }}]?<br/><br/>"+
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
                        url: "/issuance-request/{{ $data->OrderNumber }}/toggle",
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
                text: "<html>Do you wish to approve this Issuance Requisition Request [{{ $data->OrderNumber }}]?"+
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
                        url: "/issuance-request/{{ $data->OrderNumber }}/toggle",
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

        $('#btnCancel').on('click', function(){
            swal({
                html: true,
                title: 'Cancel Issuance {{ $data->OrderNumber }}?',
                text:
                "<html>You won't be able to revert this!<br/><br/>" +
                "<textarea " +
                "id='Remarks'" +
                "class='form-control flat' " +
                "placeholder='Please state your reason here.' " +
                "style='resize: none;' " +
                "rows='3'></textarea>" +
                "</html>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }, function(x){
                if(x) {
                    var remarks = $("#Remarks").val();
                    var request = $.ajax({
                        method: "POST",
                        url: "/issuance-request/{{ $data->OrderNumber }}/void",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { Remarks: remarks }
                    });

                    request.done(function(x){
                        console.log(x);
                        window.location = window.location.pathname;
                    });
                }
            });
        });
    </script>
@endsection