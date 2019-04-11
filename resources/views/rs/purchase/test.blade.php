@extends('templates.content',[
    'title'=>'Purchase Request',
    'description'=>'List of Purchase Requests',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Purchase Requests')
    ]
])
@section('styles')
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
        .card-title {
            padding-top: 4px;
            height: 27px;
            line-height: 27px;
            text-align: center;
        }
        .shadow {
            box-shadow: 1px 1px 2px 1px rgba(0, 0, 0, 0.7);
        }
        .title-button {
            color: white !important;
            font-weight: lighter;
        }
    </style>
@endsection
@section('content')
    <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
        <div class="card-header card-header-icon" data-background-color="green">
            <h4 class="card-title" style="display: inline-block">Purchase Requests</h4>
        </div>
        <div class="card-body">
            <div class="material-datatables">
                <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="purchaseTable" class="table table-no-bordered dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                                <tbody>
                                @if(count(\App\Requisition::where('Type','=','PR')->get())>0)
                                    @foreach(\App\Requisition::where('Type','=','PR')->get() as $pr)
                                        <tr>
                                            @include('templates.pr', ['issuance'=>$pr])
                                        </tr>
                                    @endforeach
                                @else
                                    No data available in table
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end content-->
    </div>
    <!--  end card  -->
@endsection
@section('scripts')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>

@endsection