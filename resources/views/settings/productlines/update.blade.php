@extends('templates.content',[
    'title'=>'Update Product Line',
    'description'=>'Update Product Line Details',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Product Lines','/product-line'),
        \App\Classes\Breadcrumb::create('Update')
    ]
])
@section('title', "Update Product Line | $data->Identifier")
@section('styles')
@endsection
@php
    $url = \Illuminate\Support\Facades\URL::current();
    $app_url = env('APP_URL');
    $edit_path = str_replace($app_url, "", $url);
    $edit_path = str_replace("view", "update", $edit_path);
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-3 col-lg-offset-3 col-md-4 col-md-offset-6">
            <form action="{{$edit_path}}" method="post">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Updating: </strong>[{{ $data->Identifier }}] {{ $data->Description }}</h3>
                    </div>
                    <div class="card-body" style="padding-top: 4px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Code</label>
                                        <input type="number" class="form-control" name="Code" id="prodCode" maxlength="2" value="{{ $data->Code }}" required />  
                                    <small id="code-error" style="color: red;"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Identifier</label>
                                    <input type="text" class="form-control" id="prodName" name="Name" maxlength="2" value="{{ $data->Identifier }}" required />  
                                    <small id="code-error-name" style="color: red;"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <textarea style="resize: none;" rows="3" class="form-control flat" name="Description" required>{{ $data->Description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                            <a href="/product-line/view/{{$data->Identifier}}" class="btn btn-flat btn-default btn-sm">Cancel</a>
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