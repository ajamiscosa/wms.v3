<div class="row d-flex flex-column" style="width: 100%; display: table-cell; vertical-align: center; text-align: left; height: 40px;">
    @if($date!==null)
        <img src="{{ asset('/img/approved.png') }}" style="height: 100%; width: 100%; object-fit: contain;"/>
    @else
        @if($isApprover and ($status==$expected))
            <button id="btnApprovePO{{$status}}" style="height: 100%;">Approve</button>
        @endif
    @endif
</div>
<div class="row" style="display: block; vertical-align: middle; text-align: center;">
    @if($date!==null)
        {{  $date->format('F d, Y') }}
    @else
        Pending Approval
    @endif
</div>
<script></script>
