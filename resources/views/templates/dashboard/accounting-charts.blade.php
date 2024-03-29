<div class="col-md-6">
    <div class="card card-success">
        <div class="card-header border-transparent">
            <h3 class="card-title">Approved Stock Adjustments</h3>
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
                    @foreach(\App\StockAdjustment::orderBy('ID','desc')->get() as $stockadj)
                        @if($counter<3)
                            @if($stockadj->Status=='A')
                                <tr>
                                    <td><a href="/issuance-request/view/{{ $stockadj->Number }}">{{ $stockadj->Number }}</a></td>
                                    <td>{{ $stockadj->Product()->UniqueID }} - {{ $stockadj->Product()->Description }}</td>
                                    <td class='text-center'>
                                        <span class="badge flat badge-success">Shipped</span>
                                    </td>
                                </tr>
                                @php($counter++)
                            @endif
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix" style="display: block;">
            <a href="/stock-adjustment" class="btn btn-sm btn-success float-right">View All Stock Adjustments</a>
        </div>
        <!-- /.card-footer -->
    </div>
</div>

<div class="col-md-6">
    <div class="card card-info">
        <div class="card-header border-transparent">
            <h3 class="card-title">Issued Items</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0" style="display: block;">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Reference </th>
                        <th>Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($counter = 0)
                    @foreach(\App\IssuanceReceipt::orderBy('ID','desc')->get() as $issuance)
                        @if($counter<3)
                            @php 
                                $product = $issuance->getLineItem()->Product();
                            @endphp
                            <tr>
                                <td>{{ $product->UniqueID }}</td>
                                <td>{{ $issuance->OrderNumber }}</td>
                                <td>{{ $issuance->Quantity }} </td>
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
            <a href="/reports/issuance-log" class="btn btn-sm btn-info float-right">View Issued Items</a>
        </div>
        <!-- /.card-footer -->
    </div>
</div>
