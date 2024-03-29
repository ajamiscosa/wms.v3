<div class="tab-pane flat active show" id="details">
    @if($data->Status!='V')
        <div class="toolbar">
            @if(auth()->user()->isAuthorized('Products','M'))
                <a class="btn flat btn-sm btn-simple" id="btnCancel">
                    <span class="fa fa-ban pr-1"></span>Cancel
                </a>
            @endif
        </div>
        <hr/>
    @endif
    <form method="POST" action="/purchase-order/{{$data->OrderNumber}}/receiving/update">
    {{ csrf_field() }}
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
                    <tbody class="productTable">
                    @php($totalRemaining = 0)
                    @foreach($data->OrderItems() as $item)
                        @php
                            $lineItem = $item->LineItem();
                            $product = $lineItem->Product();
                            $totalRemaining+=$lineItem->getRemainingDeliverableQuantity();

                        @endphp
                    <input type="hidden" name="OrderItem[]" value="{{ $item->ID }}">
                        <tr>
                            <td class=" pt-0 pb-0 mt-0 mb-0 align-middle">
                                <a href="/product/view/{{ $product->UniqueID }}">
                                    [{{ $product->UniqueID }}] {{ $product->Description }}
                                </a>
                            </td>
                            <td class=" pt-0 pb-0 mt-0 mb-0 align-middle">[{{ $lineItem->GeneralLedger()->Code }}] {{ $lineItem->GeneralLedger()->Description }}</td>
                            <td>
                                <div class="input-group my-colorpicker2 colorpicker-element float-right">
                                    @if($lineItem->getRemainingDeliverableQuantity()>0)
                                    <input 
                                        class="form-control text-right middle-dis" 
                                        step="{{ $product->UOM()->Type==1?"0.001":"1" }}" 
                                        type="number" 
                                        name="Quantity[]" 
                                        min="0"
                                        max="{{$lineItem->getRemainingDeliverableQuantity()}}" 
                                        style="max-width: 100px;" 
                                        required/>
                                    <div class="input-group-append middle-dis xwrapper">
                                        <span class="middle-dis ml-3">/ {{ round($lineItem->getRemainingDeliverableQuantity(), 2) }} {{ $product->UOM()->Abbreviation }}</span>
                                    </div>
                                    @else
                                        <span>Completed</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($totalRemaining>0)
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
<script type="text/javascript">
    $(document).on('click','#btnReceive',function(e){
        if($('#submitReceiveForm')[0].checkValidity()) { // force validation. hax. :D
            e.preventDefault();
            swal({
                html: true,
                title: 'Receive '+poNumber+'?',
                text:
                "<html>Do you wish to receive<br/>Purchase Order?<br/><br/>"+
                "</html>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC3545',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }, function(x) {
                if(x) {
                       $('#submitReceiveForm').submit();
                    //    window.location = "/receive-order";
                } else {
                    return false;
                }
            });
        }
    });
</script>