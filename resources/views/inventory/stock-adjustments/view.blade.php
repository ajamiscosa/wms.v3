@extends('templates.content',[
    'title'=>'View Stock Adjustment',
    'description'=>"View Stock Adjustment for Product [{$data->Product()->UniqueID}] {$data->Product()->Description}",
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Stock Adjustment','/stock-adjustment'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title',"Stock Adjustment $data->Number")
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
@endsection
@php
$url = \Illuminate\Support\Facades\URL::current();
$app_url = env('APP_URL');
$edit_path = str_replace($app_url, "", $url);
$edit_path = str_replace("view", "update", $edit_path);

$name = explode(' ', $data->Name);
$name = implode('-', $name);
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-text">
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Stock Adjustment: </strong>{{ $data->Number }}
                        @if($data->Status=='V')
                            <span class="badge badge-danger text-center align-middle flat" style="font-size: 11px;">Voided</span>
                        @endif
                    </h3>
                </div>
                <div class="card-body" style="padding-bottom: 0px;">
                    <div class="row">
                        <div class="col-md-12">
                            @if(auth()->user()->isAuthorized('StockAdjustments','A') && $data->Status == 'P')
                                <button type="submit" class="btn btn-flat btn-fill btn-success btn-sm" id="btnApprove">Approve</button>
                            @endif
                            @if($data->Status!='V')
                                <button type="submit" class="btn btn-flat btn-fill btn-danger btn-sm" id="btnVoid">Void</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding-top: 4px;">
                    @if($data->Status!='V')
                        <hr>
                    @endif
                    <strong><i class="fa fa-braille mr-1"></i> Product</strong>
                    <p class="text-muted">
                        <a href="/product/view/{{ $data->Product()->UniqueID }}">[{{ $data->Product()->UniqueID }}] {{ $data->Product()->Description }}</a>
                    </p>
                    <hr>
                    <strong><i class="fa fa-calendar-alt mr-1"></i> Date</strong>
                    <p class="text-muted">
                        {{ $data->created_at->format('F d, Y') }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-edit mr-1"></i> Description</strong>
                    <p class="text-muted">
                        @php
                            $diff = $data->Final - $data->Initial;
                            if($diff>0) {
                                echo sprintf('Stock increased by %s.', $diff);
                            } else {
                                echo sprintf('Stock decreased by %s.', $diff*-1);
                            }
                        @endphp
                    </p>
                    <hr>
                    <strong><i class="fa fa-comment-alt mr-1"></i> Reason</strong>
                    <p class="text-muted">
                        {{ $data->Reason?$data->Reason:"No Reason Provided" }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-user-edit mr-1"></i> Adjustment by</strong>
                    <p class="text-muted">
                        {{ $data->Adjuster()->Person()->Name() }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-exclamation mr-1"></i> Status</strong>
                    <p class="text-muted">
                        {{ $data->Status() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script>
        $(function(){
            $('#btnApprove').on('click',function(){
                var result = swal({
                    html: true,
                    title: 'Approve {{ $data->Number }}?',
                    text:
                    "<html>Do you wish to approve<br/>Stock Adjustment Request [{{ $data->Number }}]?<br/><br/>"+
                    "<textarea " +
                    "id='Remarks'" +
                    "class='form-control flat' " +
                    "placeholder='Add some notes here.' " +
                    "style='resize: none;' " +
                    "rows='3'></textarea>" +
                    "</html>",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                },function(x){
                    if(x) {
                        var remarks = $("#Remarks").val();
                        var request = $.ajax({
                            method: "POST",
                            url: "/stock-adjustment/{{ $data->Number }}/approve",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: { Remarks: remarks }
                        });

                        request.done(function(x){
                            console.log(x);
                            window.location = window.location.pathname;
                        });

                    } else {

                    }
                });
            });

            $('#btnVoid').on('click',function(){
                var result = swal({
                    html: true,
                    title: 'Void {{ $data->Number }}?',
                    text:
                    "<html>You won't be able to revert this!<br/><br/>" +
                    "<textarea " +
                    "id='Remarks' " +
                    "class='form-control flat' " +
                    "placeholder='Please state your reason here.' " +
                    "style='resize: none;' " +
                    "rows='3'></textarea>" +
                    "</html>",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                },function(x){
                    if(x) {
                        var remarks = $("#Remarks").val();
                        var request = $.ajax({
                            method: "POST",
                            url: "/stock-adjustment/{{ $data->Number }}/void",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: { Remarks: remarks }
                        });

                        request.done(function(x){
                            console.log(x);
                            window.location = window.location.pathname;
                        });

                    } else {

                    }
                });
            });
        });
    </script>
@endsection