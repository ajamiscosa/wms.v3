@php
    $url = \Illuminate\Support\Facades\URL::current();
    $app_url = env('APP_URL');
    $edit_path = str_replace($app_url, "", $url);
    $edit_path = str_replace("view", "update", $edit_path);

$isReport = $data->IsReport;
@endphp
    <!-- Product Detail Box -->
    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
        <div class="card-header flat">
            <h3 class="card-title"><strong>Product Details: </strong> {{ $data->UniqueID }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if(auth()->user()->isAuthorized('Products','M'))
                @if(!$data->IsReport)
                <div class="row float-right">
                    <div class="col-md-12">
                        <form action="/product/toggle/{{ $data->UniqueID }}" method="post">
                            {{ csrf_field() }}
                            @if($data->Status)
                                <a href="{{ $edit_path }}" class="btn btn-flat btn-fill btn-danger btn-sm">Edit</a>
                                <button type="submit" class="btn btn-flat btn-fill btn-default btn-sm">Disable</button>
                            @else
                                <button type="submit" class="btn btn-flat pull-right btn-fill btn-success btn-sm">Enable</button>
                            @endif
                            @if(auth()->user()->isMaterialsControl())
                                <a role="button" class="btn btn-flat pull-right btn-fill btn-warning btn-sm" id="btnDelete">Delete</a>
                            @endif
                        </form>
                    </div>
                </div>
                <hr class="mt-5">
                @endif
            @endif
            <strong><i class="fa fa-qrcode mr-1"></i> QR Code</strong><span class="float-right"><a href="/product/{{$data->UniqueID}}/qrcode" target="_blank" class="btn btn-flat btn-default"><i class="fa fa-print"></i></a></span>
            <p class="text-muted">
                {!!  \App\Classes\BarcodeHelper::GenerateQRDataFromString($data->UniqueID,false) !!}
            </p>
            <hr>
            <strong><i class="fa fa-edit mr-1"></i> Name</strong>
            <p class="text-muted">
                {{ $data->Name }}
            </p>
            <hr>
            <strong><i class="fa fa-book mr-1"></i> Description</strong>
            <p class="text-muted">
                {{ $data->Description }}
            </p>
            <hr class="pb-0 mt-0">
            <strong><i class="fab fa-delicious mr-1"></i> Category</strong>
            <p class="text-muted">
                [{{ $data->Category()->Identifier }}] {{ $data->Category()->Description }}
            </p>
            <hr class="pb-0 mt-0">
            <strong><i class="fab fa-dropbox mr-1"></i> Product Line</strong>
            <p class="text-muted">
                [{{ $data->ProductLine()->Identifier }}] {{ $data->ProductLine()->Description }}
            </p>
            <hr class="pb-0 mt-0">
            <strong><i class="fa fa-shopping-bag mr-1"></i> Unit of Measurement</strong>
            <p class="text-muted">
                @php
                    $uom = $data->UOM();
                    if($uom) {
                        $title = $uom->Name;
                        $abbr = $uom->Abbreviation;
                    } else {
                        $title = "N/A";
                        $abbr = "N/A";
                    }
                @endphp
                {{ $title }} ({{ $abbr }})
            </p>
            @if($data->isTemporary())
            <hr class="pb-0 mt-0">
            <div class="row mb-0 pb-0">
                <div class="col-lg-6 col-md-6">
                    <strong><i class="fa fa-cubes mr-1"></i> Minimum Quantity (ROP)</strong>
                    <p class="text-muted">
                        {{ $data->MinimumQuantity }}
                    </p>
                </div>
                <div class="col-lg-6 col-md-6">
                    <strong><i class="fa fa-exclamation-triangle mr-1"></i> Maximum Quantity</strong>
                    <p class="text-muted">
                        {{ $data->MaximumQuantity }}
                    </p>
                </div>
            </div>
            <hr class="pb-0 mt-0">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <strong><i class="fa fa-ellipsis-h mr-1"></i> Safety Stocks Quantity</strong>
                    <p class="text-muted">
                        {{ $data->SafetyStockQuantity }}
                    </p>
                </div>
                <div class="col-lg-6 col-md-6">
                    <strong><i class="fa fa-exclamation mr-1"></i> Critical Quantity</strong>
                    <p class="text-muted">
                        {{ $data->CriticalQuantity }}
                    </p>
                </div>
            </div>
            @endif
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->