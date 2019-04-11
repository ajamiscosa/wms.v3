@extends('templates.content',[
    'title'=>'New Shipping Method',
    'description'=>'Create New Shipping Method',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Shipping Methods','/ship-via'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title','New Shipping Method')
@section('styles')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <form method="post" action="/ship-via/store">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Add New Shipping Method</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <textarea style="resize: none;" rows="3" class="form-control flat" name="Description" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-flat btn-danger btn-sm">Save</button>
                                <a href="/ship-via" class="btn btn-flat btn-default btn-sm">Cancel</a>
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