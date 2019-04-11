
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Description</th>
            <th>Beginning</th>
            <th>Received</th>
            <th>Issued</th>
            <th>Ending</th>
            <th>Pending for Issue</th>
            <th>Incoming</th>
        </tr>
    </thead>
    <tbody>

    @php
        $products = new \App\Product();
        if(request()->has('s')) {
            $products = $products->
            where('Name','like','%'.request('s').'%')->
            orWhere('Description','like','%'.request('s').'%')->
            orWhere('UniqueID','like','%'.request('s').'%');
        }

        $products = $products->where('Status','=',1);


    @endphp
    @if($products->get()->count()>0)
        @foreach($products->get() as $product)
            @php($uom = $product->UOM()!=null?$product->UOM()->Abbreviation:"")
            <tr role="row" class="{{ $loop->index % 2 ? "odd":"even" }}">
                <td><a href="/product/view/{{ $product->UniqueID }}">{{ $product->UniqueID }}</a></td>
                <td>{{ $product->Description }}</td>
                <td>{{ $product->Quantity + $product->getIssuedQuantity() - $product->getReceivedQuantity() }}</td>
                <td>{{ $product->getReceivedQuantity() }}</td>
                <td>{{ $product->getIssuedQuantity() }}</td>
                <td>{{ $product->Quantity }}</td>
                <td>{{ $product->getReservedQuantity() }}</td>
                <td>{{ $product->getIncomingQuantity() }}</td>
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