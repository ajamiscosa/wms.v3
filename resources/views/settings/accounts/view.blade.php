@extends('templates.content',[
    'title'=>'View User Accounts',
    'description'=>'View account details',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('User Accounts','/account'),
        \App\Classes\Breadcrumb::create('View')
    ]
])
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-body pb-0">
                    <div class="row float-right">
                        <div class="col-md-12">
                            <form action="/account/{{ $data->Username }}/toggle" method="post">
                                {{ csrf_field() }}
                                @if($data->Status)
                                    <a href="/account/{{ $data->Username }}/update" class="btn btn-flat btn-fill btn-danger btn-sm">Edit</a>
                                    <button type="submit" class="btn btn-flat btn-fill btn-default btn-sm">Disable</button>
                                @else
                                    <button type="submit" class="btn btn-flat btn-fill btn-success btn-sm">Enable</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                                <div class="thumbnail">
                                    <img src="{{ asset('storage/images/'.$data->Person()->ImageFile) }}" style="width: 150px; height: 150px;" alt="...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>{{ $data->Person()->FirstName }} {{ $data->Person()->LastName }}</h2>
                                    @php
                                        $title = "";
                                        foreach($data->Roles() as $role) {
                                            $title .= $role->Name;
                                            $title .= " | ";
                                        }
                                        $title = trim($title,' | ');
                                    @endphp
                                    <h4 style="margin-top: -10px;">{{ \App\Classes\Helper::camelSplit($title) }}</h4>
                                    <h4 style="margin-top: -5px;"><i>{{ $data->Username }}</i>
                                    @if(!$data->Status)
                                        &nbsp;<span class="badge badge-danger" style="font-size: 9px; vertical-align: middle;">DISABLED</span>
                                    @endif
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0">
                    <strong><i class="fa fa-edit mr-1"></i> Email Address</strong>
                    <p class="text-muted">
                        {{ $data->Person()->Email }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-book mr-1"></i> Contact Number</strong>
                    <p class="text-muted">
                        {{ $data->Person()->ContactNumber }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-book mr-1"></i> Birthday</strong>
                    <p class="text-muted">
                        {{ $data->Person()->Birthday->format('F d, Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('js/jasny-bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            var count = 1;
            var addFormGroup = function (event) {
                event.preventDefault();
                if(count<2) {
                    var $content = $(this).closest('.entry');
                    var $clone = $content.clone();

                    $(this)
                        .toggleClass('btn-default btn-add btn-danger btn-remove')
                        .html('<span class="glyphicon glyphicon-minus"></span>');

                    $clone.find('input').val('');
                    $clone.insertAfter($content);
                    count++;
                }
            };

            var removeFormGroup = function (event) {
                event.preventDefault();
                var $content = $(this).closest('.entry');
                $content.remove();
                count--;
            };


            $(document).on('click', '.btn-add', addFormGroup);
            $(document).on('click', '.btn-remove', removeFormGroup);

            //
            $('#Birthday').datetimepicker({
                format: "MMM DD, YYYY"
            });

            var $roleSelect = $('.role-select');
            $roleSelect.select2({
                placeholder: 'Select Role',
                minimumResultsForSearch: -1
            });
            var $genderSelect = $('.gender-select');
            $genderSelect.select2({
                placeholder: 'Select Gender',
                minimumResultsForSearch: -1
            });
        });
@endsection