<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Module Invoice</title>
    <style>
        table, th, td {
            border: 1px solid #000;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<table>
    <thead>
        <tr>
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
    @if($data->count()>0)
        @foreach($data as $request)
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
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>{{ $product->UniqueID }}</td>
                        <td>{{ $product->getGeneralLedger()->Code }}</td>
                        <td class="text-right">{{ $lineItem->Quantity }}</td>
                        <td>{{ $product->UOM()->Abbreviation }}</td>
                        <td>{{ $product->Description }}</td>
                    @endif

                    @if($orderItem = $lineItem->OrderItem())
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
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>{{ $rr->OrderNumber }}</td>
                                        <td>{{ \Carbon\Carbon::parse($rr->Received)->format('m/d/Y') }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($po->OrderDate)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($rr->Received)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                    </tr>
                                    @endif
                                @empty
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($po->OrderDate)->diffInDays(\Carbon\Carbon::parse($request->Date)) }}</td>
                                    <td>&nbsp;</td>
                                @endforelse
                            @else
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            @endif
                        @else
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        @endif
                    @else
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    @endif
                    @php($count++)
                </tr>
                @else
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                @endif
            @empty
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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
</body>
</html>