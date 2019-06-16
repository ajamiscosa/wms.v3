<div class="card card-danger card-outline flat"> <!--  collapsed-card-->
    <div class="card-header p-2">
        <h4 class="card-title" style="display: inline-block">Purchase Order</h4>
    </div><!-- /.card-header -->
    <div class="card-body">
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
        <form method="POST" action="/issuance/{{$data->OrderNumber}}/receiving/update" id="submitIssuanceForm">
        {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Department</label><br/>
                                <span>{{ $data->Department()->Name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Approver</label><br/>
                                <span>{{ $data->Approver1()->Name() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Charge To</label><br/>
                                <span>{{ $data->ChargedTo()->Name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Approver</label><br/>
                                <span>{{ $data->Approver2()->Name() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Filed By</label><br/>
                                <span>{{ $data->Requester()->Name() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Date Filed</label><br/>
                                <span>{{ $data->Date->format('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Remarks" class="control-label">Remarks</label>
                                <div class="col-lg-12">
                                    @php
                                        $remarks = json_decode($data->Remarks, true);
                                    @endphp
                                    @foreach($remarks['data'] as $entry)
                                        <div class="row">
                                            [{{ \Carbon\Carbon::parse($entry['time'])->format("M. d, Y | h:i A") }}]
                                            [{{ \App\User::find($entry['userid'])->Username }}]:
                                            {{ $entry['message'] }}
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
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
                        @php($totalRemaining = $data->getRemainingIssuableQuantity())
                        @foreach($data->LineItems() as $item)
                        <input type="hidden" name="LineItem[]" value="{{ $item->ID }}">
                            <tr>
                                <td class=" pt-0 pb-0 mt-0 mb-0 align-middle">
                                    <a href="/product/view/{{ $item->Product()->UniqueID }}">
                                        [{{ $item->Product()->UniqueID }}] {{ $item->Product()->Description }}
                                    </a>
                                </td>
                                <td class=" pt-0 pb-0 mt-0 mb-0 align-middle">[{{ $item->GeneralLedger()->Code }}] {{ $item->GeneralLedger()->Description }}</td>
                                <td>
                                    <div class="input-group my-colorpicker2 colorpicker-element float-right">
                                        @if($item->getRemainingReceivableQuantity()>0)
                                        <input class="form-control text-right middle-dis" type="number" step="0.001" name="Quantity[]" max="{{$item->getRemainingReceivableQuantity()}}" style="max-width: 100px;" required/>
                                        <div class="input-group-append middle-dis xwrapper">
                                            <span class="middle-dis ml-3">/ {{ round($item->getRemainingReceivableQuantity(), 2) }} {{ $item->Product()->UOM()->Abbreviation }}</span>
                                        </div>
                                        @else
                                            <span>Completed</span>
                                            <input type="hidden" name="Quantity[]" value=0 />
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Remarks" class="control-label">Remarks</label>
                                <textarea class="form-control flat" style="resize: none;" rows="3" name="Remarks"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Receiver" class="control-label">Received By</label>
                                <input type="text" class="form-control flat" name="Receiver" required/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row float-right">
                <div class="col-md-12">
                    <input type="submit" class="btn flat btn-danger btn-md" value="Save" id="btnIssue">
                    <a href="/issuance" class="btn btn-flat btn-default btn-md">Cancel</a>
                </div>
            </div>
            @endif
        </form>
        </div>
    </div>
</div>