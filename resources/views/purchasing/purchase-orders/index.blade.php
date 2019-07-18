@extends('templates.content',[
    'title'=>'Purchase Orders',
    'description'=>'List of all Purchase Orders',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Purchase Orders')
    ]
])
@section('title','Purchase Orders')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
    <style>
        a {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        a:hover {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }

        .flat {
            border-radius: 0 !important;
        }
    </style>
@endsection
@section('content')
    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                @if(auth()->user()->isAuthorized('PurchaseOrders','M'))
                    @php($purchasing=true)
                    <li class="nav-item"><a class="nav-link active show" href="#draft" data-toggle="tab">Draft</a></li>
                    <li class="nav-item"><a class="nav-link {{ $purchasing==false?"active show":"" }}" href="#pending" data-toggle="tab">Pending Approval</a></li>
                @endif
                <li class="nav-item"><a class="nav-link" href="#approved" data-toggle="tab">Approved</a></li>
                <li class="nav-item"><a class="nav-link" href="#all" data-toggle="tab">All</a></li>
            </ul>
        </div><!-- /.card-header -->
        <div class="card-body flat">
            <div class="tab-content">
                <div class="tab-pane flat active show" id="draft">
                    @include('purchasing.purchase-orders.table.draft')
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane flat" id="pending">
                    @include('purchasing.purchase-orders.table.pending')
                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane flat" id="approved">
                    @include('purchasing.purchase-orders.table.approved')
                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane flat" id="all">
                    @include('purchasing.purchase-orders.table.all')
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div><!-- /.card-body -->
    </div>
@endsection