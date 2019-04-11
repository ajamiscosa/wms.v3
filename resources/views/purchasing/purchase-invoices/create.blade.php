@extends('app')
@php
        @endphp
@section('styles')

    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-icon" data-background-color="red">
                    <i class="material-icons">contacts</i>
                </div>
                <div class="card-header card-header-text">
                    <div class="col-lg-12">
                        <div class="row">
                            <h3 class="card-title" style="padding-top: 0; margin-top: 0;">
                                <strong>New Purchase Invoice (Bill)</strong>
                            </h3>
                        </div>
                    </div>
                </div>
                <form action="/purchase-invoice/store" method="post">
                    {{csrf_field()}}
                    <div class="card-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Supplier</label>
                                            <br class="input-lining"/>
                                            <span>{{ $data->Supplier()->Name }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Payment Term (in days)</label>
                                            <input type="text" class="form-control" name="PaymentTerm" style="max-width: 120px;" value="{{ $data->PaymentTerm  }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Purchase Order</label>
                                            <br class="input-lining"/>
                                            <span>{{ $data->OrderNumber }}</span>
                                            <input type="hidden" value="{{ $data->OrderNumber }}" name="PurchaseOrder">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Date Billed</label>
                                                    <input type="text" class="form-control datepicker" id="DateBilled" name="DateBilled" value="{{ \Carbon\Carbon::today()->format('M d, Y') }}">
                                                </div>
                                            </div>
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
                                        <th width="5%">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="checkAll">
                                                </label>
                                            </div>
                                        </th>
                                        <th style="width: 50%;">Item</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Unit Cost</th>
                                        <th class="text-right">Line Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tbody class="variantTable">
                                    @php
                                        $variants = array();
                                        $items = array();
                                        $outVars = array();
                                    @endphp
                                    @php
                                        foreach($data->LineItems() as $item) {
                                            if(!in_array($item->Variant()->ID, $variants)) {
                                                array_push($variants, $item->Variant()->ID);
                                                array_push($items, $item);
                                            }
                                            else {
                                                $index = array_search($item->Variant()->ID, $variants);
                                                $items[$index]->Quantity = $items[$index]->Quantity+$item->Quantity;
                                            }
                                        }

                                        foreach($data->Bills() as $return){
                                            foreach($return->LineItems() as $item) {
                                                $index = array_search($item->Variant()->ID, $variants);
                                                $items[$index]->Quantity = $items[$index]->Quantity-$item->Quantity;
                                                if($items[$index]->Quantity<1) {
                                                    unset($items[$index]);
                                                }
                                            }
                                        }

                                    @endphp
                                    @foreach($items as $item)
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
                                        @if($item->Quantity > 0)
                                            <tr>
                                                <td>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="item" name="Selected[]" value="{{ $loop->index }}">
                                                            <input type="hidden" value="{{ $item->Variant()->ID }}" name="Variant[]">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    {!! $var !!}
                                                </td>
                                                <td class="text-center">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6 text-right" style="padding-right: 0px; margin-right: 0px;">
                                                                <input style="max-width: 200px;" class="custom-form-control quantity-input text-right key-numeric" max="{{ $item->Quantity  }}" min="0" name="Quantity[]" type="number" step="1.00" value="{{ round($item->Quantity,2)  }}">
                                                            </div>
                                                            <div class="col-md-6" style="max-width: 150px;">
                                                                <input class="custom-form-control text-center" type="text" value="{{ $item->Variant()->Product()->UOM()->Name }}" readonly>
                                                                <input type="hidden" value="{{ $item->Variant()->Product()->UOM()->ID }}" name="UOM[]">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <input type="hidden" class="unit-cost" value="{{ $item->Variant()->BuyingPrice }}">
                                                    <div>₱ {{ number_format($item->Variant()->BuyingPrice,2,'.',',') }}</div>
                                                </td>
                                                <td class="text-right">
                                                    <input type="hidden" class="line-total" name="LineTotal[]" value="{{ $item->Variant()->BuyingPrice*$item->Quantity }}">
                                                    <div class="line-total-div">₱ {{ number_format(($item->Variant()->BuyingPrice*$item->Quantity),2,'.',',') }}</div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-9">
                                &nbsp;
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" class="total-amount" name="TotalAmount" value="0.00">
                                        <strong>Total: </strong>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span class="total-amount">₱ 0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Remarks" class="control-label">Remarks</label>
                                            <textarea class="form-control" rows="3" name="Remarks"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <a href="/purchase-order" class="btn btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
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
                calcTotal();
            });

            $("input[type='checkbox'].item").change(function(){
                var a = $("input[type='checkbox'].item");
                if(a.length == a.filter(":checked").length){
                    $("#checkAll").prop('checked', true);
                    calcTotal();
                }else {
                    $("#checkAll").prop('checked', false);
                    calcTotal();
                }


            });

            $('.quantity-input').on('keyup', function(){
                var quantityInput = parseFloat($(this).closest('tr').find('.quantity-input').val());
                var unitCost = parseFloat($(this).closest('tr').find('.unit-cost').val());
                var totalAmount = parseFloat(quantityInput * unitCost);

                var $lineTotal = $(this).closest('tr').find('.line-total');
                var $lineTotalDiv = $(this).closest('tr').find('.line-total-div');
                $lineTotal.val(totalAmount);

                $lineTotalDiv.html('₱ ' + parseFloat(totalAmount).toFixed(2).toLocaleString('en'));

                calcTotal();
            });


            $('.key-numeric').keypress(function(e) {
                var verified = (e.which == 8 || e.which == 46 || e.which == undefined || e.which == 0) ? null : String.fromCharCode(e.which).match(/[^0-9.]/);
                if (verified) { e.preventDefault();}
            });

            $('#DateBilled').datetimepicker({
                format: "MMMM DD, YYYY"
            });

            function calcTotal() {
                var total = parseFloat(0);
                $("input[type='checkbox'].item").each(function(){
                    if($(this).prop('checked')) {

                        var $lineTotal = $(this).closest('tr').find('.line-total');
                        total += parseFloat($lineTotal.val());

                    }
                });

                $('.total-amount').val(total);
                $('.total-amount').html('₱ ' + parseFloat(total).toFixed(2).toLocaleString('en'));
            }
        })
    </script>
@endsection