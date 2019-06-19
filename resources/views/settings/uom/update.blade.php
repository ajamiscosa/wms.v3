@extends('templates.content',[
    'title'=>'Update Unit of Measure',
    'description'=>'Update details of a Unit of Measure',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Units of Measure','/uom'),
        \App\Classes\Breadcrumb::create('Update')
    ]
])
@section('title', "Update [{$data->Name}]")
@section('styles')
<link rel="stylesheet" href="{{ asset('css/select2.css') }}">
@endsection
@php
    $url = \Illuminate\Support\Facades\URL::current();
    $app_url = env('APP_URL');
    $edit_path = str_replace($app_url, "", $url);
    $view_path = str_replace("update", "view", $edit_path);
@endphp

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <form action="{{$edit_path}}" method="post">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Updating UOM: </strong>{{ $data->Name }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input type="text" class="form-control" name="Name" value="{{ $data->Name }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Abbreviation</label>
                                    <input type="text" class="form-control" name="Abbreviation" value="{{ $data->Abbreviation }}">
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label">Allow Decimal</label>
                                    <select class="form-control decimal-select" name="Type" required>
                                        <option></option>
                                        <option value="1" {{ $data->Type==1?'selected':'' }}>Yes</option>
                                        <option value="0" {{ $data->Type==0?'selected':'' }}>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row float-right">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="{{ $view_path }}" class="btn btn-flat btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(function () {
            var addFormGroup = function (event) {
                event.preventDefault();

                var $content = $(this).closest('.entry');
                var $clone = $content.clone();

                $(this)
                    .toggleClass('btn-add btn-outline-danger btn-remove')
                    .html('<i class="fa fa-minus-circle"></i>');

                $clone.find('input').val('');
                $clone.insertAfter($content);

            };

            var removeFormGroup = function (event) {
                event.preventDefault();

                var $content = $(this).closest('.entry');
                $content.remove();
            };


            $('.decimal-select').select2({
                placeholder: '- Select -',
                minimumResultsForSearch: -1
            });

            $(document).on('click', '.btn-add', addFormGroup);
            $(document).on('click', '.btn-remove', removeFormGroup);

        });
    </script>
@endsection