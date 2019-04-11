<td style="padding-bottom: 0; margin-bottom: 0;">
    <div class="card flat collapsed-card">
        <div class="card-header">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-2">
                        <a class="btn btn-flat btn-danger btn-sm shadow title-button" href="/issuance-request/view/{{ $issuance->OrderNumber }}"><i class="fa fa-copy"></i>&nbsp;<strong>{{ $issuance->OrderNumber }}</strong></a><br/>
                        <span style="font-size: 14px;">&nbsp;&nbsp;&nbsp;<strong>Line Items: </strong>{{ count($issuance->LineItems()) }}</span><br/>
                        <button class="btn btn-tool" data-widget="collapse">
                            View Details
                        </button>
                    </div>
                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-lg-3">
                                REQUESTED BY
                            </div>
                            <div class="col-lg-9">
                                <strong>{{ $issuance->Requester()->Name() }}</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                DEPARTMENT
                            </div>
                            <div class="col-lg-9">
                                <strong>{{ $issuance->Department()->Name }}</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                DATE FILED
                            </div>
                            <div class="col-lg-9">
                                <strong>{{ $issuance->Date->format('F d, Y') }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-lg-3">
                                APPROVER
                            </div>
                            <div class="col-lg-9">
                                <strong>{{ \App\Person::where('ID','=',$issuance->Approver1)->first()->Name() }}</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                CHARGED TO
                            </div>
                            <div class="col-lg-9">
                                <strong>{{ $issuance->ChargedTo()->Name }}</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                STATUS
                            </div>
                            <div class="col-lg-9">
                                <strong>{{ \App\Classes\IssuanceHelper::ParseStatus($issuance->Status) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
        </div>
    </div>
</td>