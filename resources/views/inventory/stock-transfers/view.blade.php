@php
$product = $data->Product();
@endphp
@extends('templates.content',[
    'title'=>'View Stock Transfer',
    'description'=>"View Stock Transfer for Product [$product->UniqueID] $product->Description",
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Stock Transfer','/stock-transfer'),
        \App\Classes\Breadcrumb::create("View ($data->Number)")
    ]
])
@section('title',"Stock Transfer $data->Number")
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
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Stock Transfer: </strong>{{ $data->Number }}
                        @if($data->Status=='V')
                            <span class="badge badge-danger text-center align-middle flat" style="font-size: 11px;">Voided</span>
                        @endif
                    </h3>
                </div>
                <div class="card-body" style="padding-bottom: 0px;">
                    <div class="row">
                        <div class="col-md-12">
                            @if(auth()->user()->isAuthorized('StockTransfers','A') && $data->Status == 'P')
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
                    <strong><i class="fa fa-archive mr-1"></i> Movement</strong>
                    <p class="text-muted">
                        {{ $data->Source()->Name }} to {{ $data->Destination()->Name }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-calendar-alt mr-1"></i> Date</strong>
                    <p class="text-muted">
                        {{ $data->created_at->format('F d, Y') }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-user-edit mr-1"></i> Transferred by</strong>
                    <p class="text-muted">
                        {{ $data->TransferredBy()->Person()->Name() }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-exclamation mr-1"></i> Status</strong>
                    <p class="text-muted">
                        {{ $data->Status() }}
                    </p>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="font-size: 8pt;">
                                <i>
                                    @if($data->created_at == $data->updated_at)
                                        @if($data->updated_at == \Carbon\Carbon::today())
                                            Created: Today @ {{ $data->created_at->format('h:i:s A') }} by {{\App\User::find($data->created_by)->first()->Username }}
                                        @else
                                            Created: {{ $data->created_at->toFormattedDateString() }} by {{ \App\User::find($data->created_by)->first()->Username }};
                                        @endif
                                    @else
                                        @if($data->updated_at->diffInDays(\Carbon\Carbon::now())>1)
                                            Last Updated: {{ $data->updated_at->toFormattedDateString() }} by {{ \App\User::find($data->updated_by)->first()->Username }}
                                        @else
                                            Last Updated: Today @ {{ $data->updated_at->format('h:i:s A') }} by {{\App\User::find($data->updated_by)->first()->Username }}
                                        @endif
                                    @endif
                                </i>
                            </p>
                        </div>
                    </div>
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
                    title: 'Approve {{ $data->Number }}?',
                    text: "You can void Transfer afterwards. Do you wish to approve Transfer?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC3545',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                },function(x){
                    if(x) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.post("/stock-transfer/{{$data->Number}}/approve")
                            .done(function(){
                                window.location = window.location.pathname;
                            });
                    } else {

                    }
                });

            });

            $('#btnVoid').on('click',function(){
                var result = swal({
                    title: 'Void {{ $data->Number }}?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                },function(x){
                    if(x) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.post("/stock-transfer/{{$data->Number}}/void")
                            .done(function(){
                                window.location = window.location.pathname;
                            });
                    } else {

                    }
                });

            });



        });
    </script>
@endsection