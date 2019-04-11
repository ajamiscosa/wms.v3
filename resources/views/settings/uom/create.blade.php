@extends('templates.content',[
    'title'=>'New Units of Measure',
    'description'=>'Create a new Unit of Measure',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Units of Measure','/uom'),
        \App\Classes\Breadcrumb::create('New')
    ]
])
@section('title','New Unit of Measure')
@section('styles')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <form method="post" action="/uom/store">
                {{ csrf_field() }}
                <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                    <div class="card-header card-header-text">
                        <h3 class="card-title" style="padding-top: 0; margin-top: 0;">Add New Unit of Measure</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group ">
                                    <label class="control-label">Name</label>
                                    <input type="text" class="form-control" name="Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="control-label">Abbreviation</label>
                                    <input type="text" class="form-control" name="Abbreviation">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row float-right">
                            <div class="col-md-12">
                                <button type="submit" class="btn flat btn-danger btn-sm">Save</button>
                                <a href="/uom" class="btn flat btn-default btn-sm">Cancel</a>
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


            $(document).on('click', '.btn-add', addFormGroup);
            $(document).on('click', '.btn-remove', removeFormGroup);

        });
    </script>
@endsection