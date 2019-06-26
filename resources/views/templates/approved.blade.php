<div class="row d-flex flex-column" style="width: 100%; display: table-cell; vertical-align: center; text-align: left; height: 40px;">
    @if($date!==null or $status=='A')
        <img src="{{ asset('/img/approved.png') }}" style="height: 100%; width: 100%; object-fit: contain;"/>
    @else
        @if(($isApprover and ($status==$expected)) or (auth()->user()->isGeneralManager()))
        <div class="row">
            <div class="col-lg-8 pr-1">
                <button class="btn btn-block btn-flat btn-success" id="btnApprovePO{{$status}}" style="height: 100%;">Approve</button>
            </div>
            <div class="col-lg-4 pl-1">
                <input type="button" class="btn btn-block btn-flat btn-dark" id="btnRejectPO" style="height: 100%;" value="Reject"/>
            </div>
        </div>
        @endif
    @endif
</div>
<div class="row" style="display: block; vertical-align: middle; text-align: center;">
    @if($date!==null or $status=='A')
        {{  $date->format('F d, Y') }}
    @else
        Pending Approval
    @endif
</div>
<script></script>
