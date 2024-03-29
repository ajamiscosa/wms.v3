@extends('templates.content',[
    'title'=>'View Product Line',
    'description'=>'View Product Line Details',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Product Line','/product-line'),
        \App\Classes\Breadcrumb::create('View')
    ]
])
@section('title', "Product Line | $data->Identifier")
@section('styles')
@endsection
@php
$url = \Illuminate\Support\Facades\URL::current();
$app_url = env('APP_URL');
$edit_path = str_replace($app_url, "", $url);
$edit_path = str_replace("view", "update", $edit_path);

$name = explode(' ', $data->Identifier);
$name = implode('-', $name);
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-text">
                    <h3 class="card-title" style="padding-top: 0; margin-top: 0;"><strong>Product Line: </strong>[{{ $data->Identifier }}] <small><i>{{ $data->Description }}</i></small> 
                        @if(!$data->Status)
                            <span class="badge badge-danger text-center align-middle flat" style="font-size: 11px;">DISABLED</span>
                        @endif
                    </h3>
                </div>
                <form action="/product-line/toggle/{{$data->ID}}" method="post">
                    <div class="card-body" style="padding-bottom: 0px;">
                        <div class="row">
                            <div class="col-md-12">
                                    {{ csrf_field() }}
                                @if($data->Status)
                                    <button type="submit" id="btnEdit" class="btn btn-flat btn-fill btn-danger btn-sm">Edit</button>
                                    <button type="submit" id="btnDisable" class="btn btn-flat btn-fill btn-default btn-sm">Disable</button>
                                @else
                                    <button type="submit" id="btnEnable" class="btn btn-flat btn-fill btn-success btn-sm">Enable</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
                <div id="pEdit" class="card-body" style="padding-top: 4px;">
                    <div class="container">
                        <form action="/product-line/update/{{$data->ID}}" method="post">
                                {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <hr>
                                        <strong><i class="fa fa-code mr-1"></i> Code</strong>
                                        <div id="cEdit">
                                            <p class="text-muted">
                                                {{ $data->Code }}
                                            </p>
                                        </div> 
                                        <small id="code-error" style="color: red;"></small>                                       
                                        <hr>
                                        <strong><i class="fa fa-braille mr-1"></i> Identifier</strong>
                                        <div id="nEdit">
                                            <p class="text-muted">
                                                {{ $data->Identifier }}
                                            </p>
                                        </div>
                                        <small id="code-error-name" style="color: red;"></small>
                                        <hr>
                                        <strong><i class="fa fa-book mr-1"></i> Description</strong>
                                        <div id="editDesc">
                                            <p class="text-muted">
                                                {{ $data->Description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" style="display:none" id="btnSave" class="btn btn-flat btn-fill btn-danger btn-sm">Save</button>
                                    <button type="submit" style="display:none" id="btnCancel" class="btn btn-flat btn-fill btn-default btn-sm">Cancel</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    //$("#pEdit p.text-muted").replaceWith( "<input type='number' id='editName'>" );

    var codeBefore = $('div#cEdit').text();
    var nameBefore = $('div#nEdit').text().trim();
    var descBefore = $('div#editDesc').text();

    var trimCodeBefore = $.trim(codeBefore);
    var trimNameBefore = $.trim(nameBefore);
    var trimDescBefore = $.trim(descBefore);

    var nameHTML = $('div#nEdit').html();
    var codeHTML = $('div#cEdit').html();
    var descHTML = $('div#editDesc').html();

    $('#btnEdit').on('click', function(e) {
        e.preventDefault();

        $('div#cEdit p').replaceWith("<input id='editCode' type='text' name='Code' class='form-control'  maxlength='2' required>" );
        $("div#nEdit p").replaceWith("<input id='editName' type='text' name='Name'  class='form-control'  maxlength='2' required>" );
        $('div#editDesc p').replaceWith("<input id='editDesc' type='text' name='Description' class='form-control' >" );
        
        $('input#editCode').val(trimCodeBefore);
        $('input#editName').val(nameBefore);
        $('input#editDesc').val(trimDescBefore);

        $('#btnEdit').css('visibility','hidden');
        $('#btnDisable').css('visibility','hidden');

        $('#btnSave').css('display','inline-block');
        $('#btnCancel').css('display','inline');
    });

    
    var nameExists = false;
    var codeExists = false;
        
    $(document).on('input',':input#editName', function(){
        var code = $('#editName').val();
        console.log(code);
        if(code.length == 2) {
            $.get({
                url: "/product-line/check/name/"+code,
                success: function(msg) {
                    if(msg) {
                        $('#editName').addClass('is-invalid');
                        $('#code-error-name').html('<b>'+code+'</b> already exists in the database.');
                        $('#btnSave').attr('disabled','disabled');
                        nameExists = true;
                    }
                    else {
                        $('#editName').removeClass('is-invalid');
                        $('#code-error-name').text('');
                        $('#btnSave').removeAttr('disabled','disabled');
                        nameExists = false;
                    }
                }
            });
        }
        else {
            $('#editName').removeClass('is-invalid');
            $('#btnSave').removeAttr('disabled','disabled');
            $('#code-error-name').text('');
        }
    });
        
    $(document).on('input',':input#editCode', function(){
        var code = $(this).val();
        if(code.length == 2) {
            $.get({
                url: "/product-line/check/code/"+code,
                success: function(msg) {
                    if(msg) {
                        $('#editCode').addClass('is-invalid');
                        $('#code-error').html('<b>'+code+'</b> already exists in the database.');
                        $('#btnSave').attr('disabled','disabled');
                        codeExists = true;
                    }
                    else {
                        $('#editCode').removeClass('is-invalid');
                        $('#btnSave').removeAttr('disabled','disabled');
                        $('#code-error').text('');
                        codeExists = false;
                    }
                }
            });
        }
        else {
            $('#editCode').removeClass('is-invalid');
            $('#btnSave').removeAttr('disabled','disabled');
            $('#code-error').text('');
        }
    });

        
    $('#btnSave').on('click', function(e){
        if(nameExists || codeExists) {
            e.preventDefault();
        }
    });

    

    $('#btnCancel').on('click', function(e){
        e.preventDefault();
        
        $('#code-error-name').text('');
        $('#code-error').text('');

        $('div#nEdit #editName').replaceWith(nameHTML);
        $('input#editCode').replaceWith(codeHTML);
        $('input#editDesc').replaceWith(descHTML);

        $('input#editName').val(trimNameBefore);
        $('input#editCode').val(trimCodeBefore);
        $('input#editDesc').val(trimDescBefore);

        $('#btnEdit').css('visibility','visible');
        $('#btnDisable').css('visibility','visible');

        $('#btnSave').css('display','none');
        $('#btnCancel').css('display','none');
    });


</script>

@endsection