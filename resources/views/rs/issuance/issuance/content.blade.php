@extends('templates.content',[
    'title'=>"Issuance Receiving : $data->OrderNumber",
    'description'=>"Fulfill Issuance Request",
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Issuance Requests','/issuance-request'),
        \App\Classes\Breadcrumb::create("$data->OrderNumber",'/issuance-request/view/'.$data->OrderNumber),
        \App\Classes\Breadcrumb::create('Receiving')
    ]
])
@section('title',"Receiving: $data->OrderNumber")
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
        <div class="col-lg-12 col-md-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->

                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active show" href="#details" data-toggle="tab">Details</a></li>
                        <li class="nav-item"><a class="nav-link" href="#transactions" data-toggle="tab">Transactions</a></li>
                    </ul>
                </div><!-- /.card-header -->


                <div class="card-body">
                    <div class="tab-content">
                        @include('rs.issuance.issuance.details')

                        @include('rs.issuance.issuance.transactions')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>

    <script type="text/javascript">
        $('#btnCancel').on('click', function(){
            swal({
                html: true,
                title: 'Cancel Issuance {{ $data->OrderNumber }}?',
                text:
                "<html>You won't be able to revert this!<br/><br/>" +
                "<textarea " +
                "id='Remarks'" +
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
            }, function(x){
                if(x) {
                    var remarks = $("#Remarks").val();
                    var request = $.ajax({
                        method: "POST",
                        url: "/issuance-request/{{ $data->OrderNumber }}/void",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { Remarks: remarks }
                    });

                    request.done(function(x){
                        console.log(x);
                        window.location = window.location.pathname;
                    });
                }
            });
        });
    </script>
@endsection