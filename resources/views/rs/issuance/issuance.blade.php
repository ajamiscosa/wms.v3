@extends('templates.content',[
    'title'=>"Issuance Receiving",
    'description'=>"Fulfill Issuance Request",
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Issuance Receiving')
    ]
])
@section('title',"Issuance Receiving")
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <style>
        .entry { display: none; }
        a {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        a:hover {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        .card-title {
            padding-top: 4px;
            height: 27px;
            line-height: 27px;
        }

        .btn-simple {
            border: 1px solid #D7D7D7;
        }

        .badge {
            padding: 5px 5px 5px 5px;
        }

        .xwrapper {
            display : flex;
            align-items : center;
        }
    </style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-10" id="content">
        <div class="card card-danger card-outline flat"> <!--  collapsed-card-->

            <div class="card-header p-2">
                <h4 class="card-title" style="display: inline-block">Issuance Request</h4>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Requesting Department</label><br/>
                                    <span>&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Approver</label><br/>
                                    <span>&nbsp;</span>
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
                                    <label class="control-label">Charged Department</label><br/>
                                    <span>&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Approver</label><br/>
                                    <span>&nbsp;</span>
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
                                    <span>&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Date Requested</label><br/>
                                    <span>&nbsp;</span>
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
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="mydiv">

                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="card card-danger card-outline flat"> <!--  collapsed-card-->

            <div class="card-header p-2">
                <h4 class="card-title" style="display: inline-block">Pending Issuance Requests</h4>
            </div><!-- /.card-header -->

            <div class="card-body">
                <select style="width: 100%; overflow: auto; font-size: 18px; outline: none;" size="10" id="pendingOrderSelect">
                    @foreach(\App\Requisition::IssuanceRequests() as $ir)
                        @if($ir->Status == 'A' and $ir->getRemainingIssuableQuantity()>0)
                            <option value="{{ $ir->OrderNumber }}">{{ $ir->OrderNumber }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>

    <script src="{{ asset('js/loadingoverlay.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ajaxStart(function(){
            $.LoadingOverlay("show");
        });
        $(document).ajaxStop(function(){
            $.LoadingOverlay("hide");
        });

        $("#pendingOrderSelect").on('change', function() {
            var orderNumber = $(this).val();

            var x = $.ajax({type: "GET", url: "/issuance-request/"+orderNumber+"/data", async: false}).responseText;
            $('#content').html(x);
        });

        $('#submitIssuanceForm').submit();
//        $(document).on('click', '#btnIssue', function(e){
//            e.preventDefault();
//            swal({
//                html: true,
//                type: 'success',
//                title: 'Success',
//                text: "Transaction Issued Successfully",
//                confirmButtonColor: '#DC3545',
//                allowOutsideClick: false,
//                closeOnConfirm : true
//            }, function(x) {
//                if(x) {
//                } else {
//                    return false;
//                }
//            });
//        });
    </script>
@endsection