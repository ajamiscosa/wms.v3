@extends('templates.content',[
    'title'=>'Update Currency',
    'description'=>'Update Details of '.$data->Name,
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Currency','/currency'),
        \App\Classes\Breadcrumb::create('Update ('.$data->Code.')')
    ]
])
@section('styles')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-6">
            <form method="post" action="/currency/update/{{$data->Code}}">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Updating Currency: </strong>{{ $data->Name }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Code</label>
                                    <input type="text" class="form-control" name="Code" value="{{ $data->Code }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input type="text" class="form-control" name="Name" value="{{ $data->Name }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">USD</label>
                                    <input type="number" step="0.00001" class="form-control" name="USD" value="{{ $data->USD }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">PHP</label>
                                    <input type="number" step="0.00001" class="form-control" name="PHP" value="{{ $data->PHP }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="/currency" class="btn btn-flat btn-default btn-sm">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')

@endsection