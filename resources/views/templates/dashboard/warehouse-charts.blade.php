<div class="col-md-6">
    <div class="card card-danger">
        <div class="card-header border-transparent">
            <h3 class="card-title">Inventory Items</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0" style="display: block;">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Description</th>
                        <th class='text-center'>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($counter = 0)
                    @php($products = \App\Product::orderBy('ID','desc')->get())
                    @foreach($products as $product)
                        @if($counter<3)
                            <tr>
                                <td><a href="/product/view/{{ $product->UniqueID }}">{{ $product->UniqueID }}</a></td>
                                <td>{{ $product->Description }}</td>
                                <td>{{ $product->getAvailableQuantity() }}</td>
                            </tr>
                            @php($counter++)
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix" style="display: block;">
            <a href="/product" class="btn btn-sm btn-danger float-right">View All Items</a>
        </div>
        <!-- /.card-footer -->
    </div>
</div>

<div class="col-md-6">
    <div class="card card-info">
        <div class="card-header border-transparent">
            <h3 class="card-title">Approved Issuances</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0" style="display: block;">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Requested By</th>
                        <th>Approved Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($counter = 0)
                    @forelse(\App\Requisition::where([
                        ['Type','=','IR'],
                        ['Status','=','A'],
                        ])->get() as $issuance)
                        @if($counter<3)
                            <tr>
                                <td><a href="/product/view/{{ $issuance->OrderNumber }}">{{ $issuance->OrderNumber }}</a></td>
                                <td>{{ $issuance->Department()->Name }}</td>
                                <td>{{ Carbon\Carbon::parse($issuance->updated_at) }}</td>
                                {{-- <td>{{ $product->getAvailableQuantity() }}</td> --}}
                            </tr>
                            @php($counter++)
                        @endif
                    @empty
                        <tr>
                            <td colspan=3>No data available</td>
                            {{-- <td>{{ $product->getAvailableQuantity() }}</td> --}}
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix" style="display: block;">
            <a href="/issuance" class="btn btn-sm btn-info float-right">View All Issuances</a>
        </div>
        <!-- /.card-footer -->
    </div>
</div>
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header border-transparent">
            <h3 class="card-title">Received Items</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0" style="display: block;">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Item</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>

                    @php($counter = 0)
                    @foreach(\App\ReceiveOrder::orderBy('OrderNumber','desc')->get() as $receive)
                        @if($counter<3)
                                <tr>
                                    <td><a href="/issuance-request/view/{{ $receive->OrderNumber }}">{{ $receive->OrderNumber }}</a></td>
                                    <td>{{ $receive->OrderItem()->LineItem()->Product()->UniqueID }} - {{ $receive->OrderItem()->LineItem()->Product()->Description }}</td>
                                    <td class='text-center'>
                                        <span class="badge flat badge-success">Shipped</span>
                                    </td>
                                </tr>
                                @php($counter++)
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix" style="display: block;">
            <a href="/reports/receiving-log" class="btn btn-sm btn-primary float-right">View All Orders</a>
        </div>
        <!-- /.card-footer -->
    </div>
</div>



<div class="col-lg-6">
    <div class="card card-primary">
        <div class="card-header border-transparent">
            <h3 class="card-title">Latest Purchase Orders</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0" style="display: block;">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Requested By</th>
                        <th class='text-center'>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\PurchaseOrder::all() as $po)
                        @php($counter = 0)
                        @if($counter<3)
                            @if($po->Status != 'D')
                            <tr>
                                <td><a href="/purchase-order/view/{{ $po->OrderNumber }}">{{ $po->OrderNumber }}</a></td>
                                <td>{{ $po->Requester()->Person()->Name() }}</td>
                                <td class='text-center'><span class="badge flat badge-success">Shipped</span></td>
                            </tr>
                            @endif
                            @php($counter++)
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix" style="display: block;">
            <a href="/purchase-order" class="btn btn-sm btn-primary float-right">View All Orders</a>
        </div>
        <!-- /.card-footer -->
    </div>
</div>


<div class="col-lg-6">
    <div class="card card-secondary">
        <div class="card-header border-transparent">
            <h3 class="card-title">Latest Issuance Requests</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0" style="display: block;">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Item</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach(\App\Requisition::IssuanceRequests() as $ir)
                        @php($counter = 0)
                        @if($counter<3)
                            @if($ir->Status != 'D')
                                <tr>
                                    <td><a href="/issuance-request/view/{{ $ir->OrderNumber }}">{{ $ir->OrderNumber }}</a></td>
                                    <td>{{ $ir->Requester()->Name() }}</td>
                                    <td class='text-center'>
                                        <span class="badge flat badge-success">Shipped</span>
                                    </td>
                                </tr>
                            @endif
                            @php($counter++)
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix" style="display: block;">
            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
        </div>
        <!-- /.card-footer -->
    </div>
</div>