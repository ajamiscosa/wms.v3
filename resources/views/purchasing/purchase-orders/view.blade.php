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
                            <div class="col-lg-6 col-md-12 pr-0">
                                <a class="btn btn-simple btn-sm btn-flat float-right" id="downloadPO">Download Purchase Order Form</a>
                            </div>
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
                                                $gl = $gl->where('ID','=',$data->APAccount)->firstOrFail();
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

                                        @endphp
                                        <tr>
                                            <td class="align-middle">
                                                <a href="/product/view/{{ $product->UniqueID }}">
                                                    {{ $product->Description }}
                                                </a>
                                            </td>
                                            <td class="text-right align-middle">
                                                @php
                                                    if($quote = $product->PreferredQuote()) {
                                                        $quote = $product->PreferredQuote();
                                                        echo "{$quote->Currency()->Code} {$quote->Amount}";
                                                    } else {
                                                        echo "No Quote Available";
                                                    }
                                                @endphp
                                            </td>
                                            <td class="align-middle">[{{ $lineItem->GeneralLedger()->Code }}] {{ $lineItem->GeneralLedger()->Description }}</td>
                                            <td class="text-right align-middle">{{ round($lineItem->Quantity, 2) }} {{ $product->UOM()->Abbreviation }}</td>
                                            <td class="text-right align-middle">{{ $quote->Currency()->Code }} {{ number_format(($quote->Amount*$lineItem->Quantity),2,'.',',') }}</td>
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
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <p style="font-size: 8pt;">
                                    <i>
                                        @if($data->created_at == $data->updated_at)
                                            @if($data->updated_at == \Carbon\Carbon::today())
                                                Created: Today @ {{ $data->created_at->format('h:i:s A') }} by {{\App\User::find($data->created_by)->first()->Username }}
                                            @else
                                                Created: {{ $data->created_at->toFormattedDateString() }} by {{ \App\User::find($data->created_by)->first()->Username }};
                                            @endif
                                        @else
                                            @if($data->updated_at->diffInDays(\Carbon\Carbon::now())>1)
                                                Last Updated: {{ $data->updated_at->toFormattedDateString() }} by {{ \App\User::find($data->updated_by)->first()->Username }}
                                            @else
                                                Last Updated: Today @ {{ $data->updated_at->format('h:i:s A') }} by {{\App\User::find($data->updated_by)->first()->Username }}
                                            @endif
                                        @endif
                                    </i>
                                </p>
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

    <script>
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
        })

        $('#downloadPO').on('click', function(){
            window.open('/purchase-order/{{ $data->OrderNumber }}/download','_blank');
        });
    </script>
@endsection