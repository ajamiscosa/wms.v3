@php
@endphp

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
            <div class="card-header">
                <i class="far fa-clock"></i>&nbsp;&nbsp;<strong>Reserved</strong>
            </div>
            <div class="card-body">
                <table class="table table-secondary table-bordered table-responsive-lg">
                    <tr>
                        <th>Issuance #</th>
                        <th>Requisitioned By</th>
                        <th>Purpose</th>
                        <th>Quantity/UOM</th>
                    </tr>
                    @php($count=0)
                    @if(count($data->LineItems())>0)
                        @foreach($data->LineItems() as $lineItem)
                            @if($lineItem->Requisition()->Type=='IR' and $lineItem->Requisition()->Status=='A')
                                <tr>
                                    <td><a href="/issuance-request/view/{{ $lineItem->OrderNumber }}">{{ $lineItem->OrderNumber }}</a></td>
                                    <td>{{ $lineItem->Requisition()->Requester()->Name() }}</td>
                                    <td>{{ $lineItem->Requisition()->Purpose }}</td>
                                    <td>{{ $lineItem->getRemainingReceivableQuantity() }} {{ $lineItem->Product()->UOM()->Abbreviation }}</td>
                                </tr>
                                @php($count++)
                            @endif
                        @endforeach
                        @if($count==0)
                            <tr>
                                <td colspan="4">No Available Data</td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td colspan="4">No Available Data</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
            <div class="card-header">
                <i class="fa fa-shipping-fast"></i>&nbsp;&nbsp;<strong>Incoming</strong>
            </div>
            <div class="card-body">
                <table class="table table-secondary table-bordered table-responsive-lg">
                    <tr>
                        <th>Purchase Order #</th>
                        <th>Estimated Arrival</th>
                        <th>Quantity</th>
                        <th>Unit of Measure</th>
                    </tr>
                    <tr>
                        <td colspan="4">No Available Data</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>