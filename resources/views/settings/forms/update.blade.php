@extends('templates.content',[
    'title'=>'Update Form Numbers',
    'description'=>'Change how form numbers are setup',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Form Numbers','/form-number-setup'),
        \App\Classes\Breadcrumb::create('Update')

    ]
])
@section('styles')
@endsection
@php
    $url = \Illuminate\Support\Facades\URL::current();
    $app_url = env('APP_URL');
    $edit_path = str_replace($app_url, "", $url);
    $edit_path = str_replace("view", "update", $edit_path);


$re = '/(?#! splitCamelCase Rev:20140412)
    # Split camelCase "words". Two global alternatives. Either g1of2:
      (?<=[a-z])      # Position is after a lowercase,
      (?=[A-Z])       # and before an uppercase letter.
    | (?<=[A-Z])      # Or g2of2; Position is after uppercase,
      (?=[A-Z][a-z])  # and before upper-then-lower case.
    /x';

$module = preg_split($re, $data->Module);

$url = \Illuminate\Support\Facades\URL::current();
$app_url = env('APP_URL');
$edit_path = str_replace($app_url, "", $url);
$view_path = str_replace("update", "view", $edit_path);
@endphp
@section('content')
    <div class="col-lg-4">
        <div class="row">

            <form action="{{$edit_path}}" method="post">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Updating: </strong> {{ \App\Classes\Helper::camelSplit($data->Module) }}</h3>
                    </div>
                    <div class="card-body" style="padding-top: 4px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input type="text" class="form-control" name="Name" readonly value="{{ \App\Classes\Helper::camelSplit($data->Module) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Prefix</label>
                                    <input type="text" class="form-control" name="Prefix" id="Prefix" value="{{ $data->Prefix }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Digits</label>
                                    <input type="number" min="0" max="10" class="form-control" name="Digits" id="Digits" value="{{ $data->Digits }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Current Value</label>
                                    <input type="number" min="0" max="{{ str_pad('',$data->Digits,9) }}" class="form-control" name="Current" id="Current" value="{{ $data->Current }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 10px;">
                                <div class="form-group">
                                    <label class="control-label">Preview</label>
                                    <span id="Preview">{{ $data->Prefix }}-{{ str_pad($data->Current,$data->Digits,'0',STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <a href="/form-number-setup" class="btn btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function(){
            $( "#Current" ).change(function() {
                var prefix = $("#Prefix").val();
                var digits = $("#Digits").val();
                var current = $("#Current").val();
                $("#Preview").html(prefix+'-'+pad(current, digits));
            });
        });

        function pad (str, max) {
            str = str.toString();
            return str.length < max ? pad("0" + str, max) : str;
        }

    </script>
@endsection
