<table>
    <thead>
        <tr role="row">
            <th>PR #</th>
            <th>Department</th>
            <th>PR Date</th>
            <th>Item ID</th>
            <th>G/L Account</th>
            <th class="text-right">Quantity</th>
            <th>Unit</th>
            <th>Description</th>
            <th>PO #</th>
            <th>PO Date</th>
            <th>Vendor</th>
            <th class="text-right">Unit Cost</th>
            <th class="text-right">PO Amount</th>
            <th>RR No.</th>
            <th>RR Date</th>
            <th>PR to PO</th>
            <th>PR to RR</th>
        </tr>
    </thead>

    <tbody>
        @php
            $pr = $data;
        @endphp
        @if($pr->count()>0)
            @foreach($pr as $request)
                <tr>
                    <td>{{ $request->OrderNumber }}</td>
                    <td>{{ $request->Department()->Name }}</td>
                    <td>{{ \Carbon\Carbon::parse($request->Date)->format('m/d/Y') }}</td>
                    @php($count=0)
                @forelse($request->LineItems() as $lineItem)
                    @if($lineItem)
                        @php
                            // $lineItem = $orderItem->LineItem();
                            $product = $lineItem->Product();
                        @endphp
                        @if($count==0)
                            <td>{{ $product->UniqueID }}</td>
                            <td>{{ $product->getGeneralLedger()->Code }}</td>
                            <td class="text-right">{{ $lineItem->Quantity }}</td>
                            <td>{{ $product->UOM()->Abbreviation }}</td>
                            <td>{{ $product->Description }}</td>
                        @else
                            <td colspan="3"></td>
                            <td>{{ $product->UniqueID }}</td>
                            <td>{{ $product->getGeneralLedger()->Code }}</td>
                            <td class="text-right">{{ $lineItem->Quantity }}</td>
                            <td>{{ $product->UOM()->Abbreviation }}</td>
                            <td>{{ $product->Description }}</td>
                        @endif

                        @php($count++)
                        @forelse($request->OrderItems() as $orderItem)
                            @if($orderItem)
                                @if($po = $orderItem->PurchaseOrder())
                                    @if($po->Status != 'D')
                                        <td>{{ $po->OrderNumber }}</td>
                                        <td>{{ $po->OrderDate->format('m/d/Y') }}</td>
                                        <td>{{ $po->Supplier()->Name }}</td>
                                        <td class="text-right">{{ $orderItem->SelectedQuote()->Amount }}</td>
                                        <td class="text-right">{{ $po->Total }}</td>
                                        @forelse($orderItem->getReceivingReceipts() as $rr)
                                            @php
                                                $purchaseOrder = $rr->PurchaseOrder();
                                                $quote = $orderItem->SelectedQuote();
                                                $supplier = $quote->Supplier();
                                            @endphp
                                            
                                            @if ($loop->first)
                                                <td>{{ $rr->OrderNumber }}</td>
                                                <td>{{ \Carbon\Carbon::parse($rr->Received)->format('m/d/Y') }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($po->OrderDate)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($rr->Received)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td colspan="13"></td>
                                                <td>{{ $rr->OrderNumber }}</td>
                                                <td>{{ \Carbon\Carbon::parse($rr->Received)->format('m/d/Y') }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($po->OrderDate)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($rr->Received)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                            </tr>
                                            @endif
                                        @empty
                                            <td colspan="4"></td>
                                        @endforelse
                                    @else
                                        <td colspan="9"></td>
                                    @endif
                                @else
                                    <td colspan="9"></td>
                                @endif
                            @else
                            <td colspan="9"></td>
                            @endif
                        @empty
                            <td colspan="9"></td>
                        @endforelse
                    </tr>
                    @else
                    <td colspan="14"></td>
                    @endif
                @empty
                    <td colspan="14"></td>
                @endforelse
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="100%" style="text-align: center; vertical-align: middle;">
                    No Data Available
                </td>
            </tr>
        @endif
    </tbody>
</table>