@php
    $quotes = $data->Quotes();
@endphp
<div class="card card-danger card-outline flat"> <!--  collapsed-card-->
    <div class="card-header flat">
        <h3 class="card-title"><strong>Product Quote Details: </strong>{{ $data->UniqueID }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @if(auth()->user()->isAuthorized('Quotes','M'))
        <div class="row">
            <div class="col-md-12">
                <a href="/product/{{ $data->UniqueID }}/quote/new" class="btn btn-flat pull-right btn-fill btn-danger btn-sm">Add Quote</a>
            </div>
        </div>
        <hr>
        @endif
        @if(count($quotes)>0)
            @foreach($quotes as $quote)
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header flat" style="background-color: #FFFFFF">
                        <h2 class="card-title" style="color: #000;">
                            <button type="button" class="btn btn-tool pl-0" data-widget="collapse" style="color: #7F7F7F;"><i class="fa fa-minus"></i></button>{{ \App\Supplier::find($quote['Supplier'])->Name }}
                        </h2>
                    </div>
                    <hr class="mt-0 mb-0">
                    <!-- /.card-header -->
                    <div class="card-body">
                        @foreach($quote['Data'] as $entry)
                            <div class="row">
                                <div class="col-lg-5 col-md-12">
                                    <strong><i class="fa fa-calendar mr-1"></i> Validity ({{ $entry->Validity }} days)</strong>
                                    <p class="text-muted">
                                        {{ $entry->ValidFrom->format('F d, Y') }} to {{ $entry->ValidFrom->addDays($entry->Validity)->format('F d, Y') }}
                                    </p>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <strong><i class="fa fa-dollar-sign mr-1"></i> Amount</strong>
                                    <p class="text-muted">
                                        {{ $entry->Currency()->Code }} {{ \App\Classes\Helper::currencyFormat($entry->Amount) }}
                                    </p>
                                </div>
                                <div class="col-lg-2 col-md-12">
                                    <strong><i class="fa fa-info mr-1"></i> Validity</strong>
                                    <p class="text-muted">
                                        @if($entry->Valid)
                                            Valid
                                        @else
                                            Invalid
                                        @endif
                                    </p>
                                </div>
                                <div class="col-lg-2 col-md-12">
                                    <strong><i class="fa fa-file-pdf mr-1"></i> Document</strong>
                                    <p class="text-muted">
                                        @if($entry->FileName=="N/A")
                                            No Attached File
                                        @else
                                            <a href="/quote/document/{{ $entry->FileName }}" class="" target="_blank">View / Download</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr class="mt-0">
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div>
                No Quote Available
            </div>
        @endif
    </div>
    <!-- /.card-body -->
</div>