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
            <th>Unique ID</th>
            <th>Description</th>
            <th class="text-right">Re-order Point</th>
            <th class="text-right">Current Quantity</th>
            <th class="text-right">Incoming Quantity</th>
            <th>Unit</th>
        </tr>
    </thead>
    <tbody>
    @forelse($products->get() as $product)
        @php($uom = $product->UOM()!=null?$product->UOM()->Abbreviation:"")
        <tr>
            <td>{{ $product->UniqueID }}</td>
            <td>{{ $product->Description }}</td>
            <td>{{ $product->ReOrderPoint }}</td>
            <td>{{ $product->Quantity }}</td>
            <td>{{ $product->getIncomingQuantity() }}</td>
            <td>{{ $uom }}</td>
        </tr>
    @empty
    <tr>
        <td colspan="100%" style="text-align: center; vertical-align: middle;">
            No Data Available
        </td>
    </tr>
    @endforelse
    </tbody>
</table>
</body>
</html>