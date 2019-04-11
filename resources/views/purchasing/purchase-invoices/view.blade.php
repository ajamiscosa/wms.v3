@extends('app')
@section('styles')

    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
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
        .middle-center {

        }
        .btn-simple {
            border: 1px solid #D7D7D7;
        }

        .badge {
            padding: 5px 5px 5px 5px;
        }

    </style>
@endsection
@php
    $supplier = explode(' ',$data->PurchaseOrder()->Supplier()->Name);
    $supplier = implode('-',$supplier);
    $supplier = sprintf('%s-%s',$data->PurchaseOrder()->Supplier()->ID,$supplier);

    $warehouse = explode(' ',$data->PurchaseOrder()->Warehouse()->Name);
    $warehouse = implode('-',$warehouse);
    $warehouse = sprintf('%s-%s',$data->PurchaseOrder()->Warehouse()->ID,$warehouse);

@endphp
@section('content')
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-icon" data-background-color="red">
                    <i class="material-icons">contacts</i>
                </div>
                <div class="card-header card-header-text">
                    <div class="col-lg-12">
                        <div class="row">
                            <h3 class="card-title" style="padding-top: 0; margin-top: 0;">
                                <strong>Purchase Invoice: </strong>{{ $data->OrderNumber }}
                            </h3>
                            @if($data->Status=='V')
                                <span class="badge badge-danger">Voided</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if($data->PurchaseOrder()->Status!='V' && $data->Status!='V')
                    <div class="card-content clearfix">
                        <div class="toolbar">
                            <a class="btn btn-xs btn-simple" href="/purchase-order/{{ $data->PurchaseOrder()->OrderNumber }}/edit">
                                <span class="fa fa-pencil"></span>
                                <!---->Edit
                            </a>
                            <a class="btn btn-xs btn-simple" id="btnVoid">
                                <span class="fa fa-ban"></span>
                                <!---->Void
                            </a>
                            @if($data->Status=='P')
                                <a class="btn btn-xs btn-simple" id="btnDelete">
                                    <span icon="trash-o" class="fa fa-trash-o"></span>
                                    <!---->Delete
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
                <div class="card-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Vendor</label>
                                        <span><a href="/stakeholder/view/{{ $supplier }}">{{ $data->PurchaseOrder()->Supplier()->Name }}</a></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Warehouse</label>
                                        <span><a href="/warehouse/view/{{ $warehouse }}">{{ $data->PurchaseOrder()->Warehouse()->Name }}</a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Purchase Order</label>
                                        <span><a href="/purchase-order/view/{{ $data->PurchaseOrder()->OrderNumber }}">{{ $data->PurchaseOrder()->OrderNumber }}</a></span>
                                        <input type="hidden" value="{{ $data->PurchaseOrder()->OrderNumber }}" name="PurchaseOrder">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Date Billed</label>
                                        <span>{{ $data->Date->format('F d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="mydiv">
                        <div class="col-lg-12">
                            <table id="roTable" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                                <thead>
                                <tr role="row">
                                    <th style="width: 50%;">Item</th>
                                    <th class="text-right">Quantity&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    <th class="text-right">Unit Cost</th>
                                    <th class="text-right">Line Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tbody class="variantTable">

                                @foreach($data->LineItems() as $item)
                                    @php
                                        $product = $item->Variant()->Product();
                                        $name = explode(' ', $product->Name);
                                        $name = implode('-', $name);

                                        $attr = sprintf("%s: %s | %s: %s | %s: %s",
                                                $item->Variant()->Product()->Attribute1, $item->Variant()->Value1,
                                                $item->Variant()->Product()->Attribute2, $item->Variant()->Value2,
                                                $item->Variant()->Product()->Attribute3, $item->Variant()->Value3
                                                );
                                        $attr = trim($attr, "| : ");
                                        $var = sprintf("<a href='/product/%s-%s/variant'>%s (%s)</a>",
                                                $item->Variant()->Product()->ID,
                                                $name,
                                                $item->Variant()->Product()->Name,
                                                $attr
                                                );
                                    @endphp
                                    <tr>
                                        <td>
                                            {!! $var !!}
                                        </td>
                                        <td class="text-right">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">{{ $item->Quantity  }} {{ $item->Variant()->Product()->UOM()->Abbreviation }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            ₱ {{ number_format($item->Variant()->BuyingPrice,2,'.',',') }}
                                        </td>
                                        <td class="text-right">
                                            ₱ {{ number_format(($item->Variant()->BuyingPrice * $item->Quantity), 2,'.',',') }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">&nbsp;</div>
                    <div class="row">&nbsp;</div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Remarks" class="control-label">Remarks</label>
                                        <span>{{ $data->Remarks }} </span>
                                    </div>
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
                                    @if($data->PurchaseOrder()->created_at == $data->PurchaseOrder()->updated_at)
                                        @if($data->PurchaseOrder()->updated_at == \Carbon\Carbon::today())
                                            Created: Today @ {{ $data->PurchaseOrder()->created_at->format('h:i:s A') }} by {{\App\User::find($data->PurchaseOrder()->created_by)->first()->Username }}
                                        @else
                                            Created: {{ $data->PurchaseOrder()->created_at->toFormattedDateString() }} by {{ \App\User::find($data->PurchaseOrder()->created_by)->first()->Username }};
                                        @endif
                                    @else
                                        @if($data->PurchaseOrder()->updated_at->diffInDays(\Carbon\Carbon::now())>1)
                                            Last Updated: {{ $data->PurchaseOrder()->updated_at->toFormattedDateString() }} by {{ \App\User::find($data->PurchaseOrder()->updated_by)->first()->Username }}
                                        @else
                                            Last Updated: Today @ {{ $data->PurchaseOrder()->updated_at->format('h:i:s A') }} by {{\App\User::find($data->PurchaseOrder()->updated_by)->first()->Username }}
                                        @endif
                                    @endif
                                </i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(function(){
            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $("input[type='checkbox'].item").change(function(){
                var a = $("input[type='checkbox'].item");
                if(a.length == a.filter(":checked").length){
                    $("#checkAll").prop('checked', true);
                }else {
                    $("#checkAll").prop('checked', false);
                }
            });

            $('#ReceiveDate').datetimepicker({
                format: "MMMM DD, YYYY"
            });

        })
    </script>
@endsection