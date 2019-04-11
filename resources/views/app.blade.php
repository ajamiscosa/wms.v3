<!DOCTYPE html>
<html lang="en" class="perfect-scrollbar-on">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('includes.favico')
    @include('includes.styles')
    @yield('styles')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    @include('includes.navbar')
    @include('includes.sidebar')
    @yield('site-content')
    @include('includes.footer')
</div>
<!-- ./wrapper -->

@include('includes.scripts')
@yield('scripts')
</body>
</html>



{{--<!-- Content Wrapper. Contains page content -->--}}
{{--<div class="content-wrapper">--}}
{{--<!-- Content Header (Page header) -->--}}
{{--<section class="content-header">--}}
{{--<div class="container-fluid">--}}
{{--<div class="row mb-2">--}}
{{--<div class="col-sm-6">--}}
{{--<h1>Blank Page</h1>--}}
{{--</div>--}}
{{--<div class="col-sm-6">--}}

{{--</div>--}}
{{--</div>--}}
{{--</div><!-- /.container-fluid -->--}}
{{--</section>--}}

{{--<!-- Main content -->--}}
{{--<section class="content">--}}
{{--<!-- Default box -->--}}
{{--<div class="card">--}}
{{--<div class="card-header">--}}
{{--<h3 class="card-title">Title</h3>--}}

{{--<div class="card-tools">--}}
{{--<button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">--}}
{{--<i class="fa fa-minus"></i></button>--}}
{{--<button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">--}}
{{--<i class="fa fa-times"></i></button>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="card-body">--}}
{{--Start creating your amazing application!--}}
{{--</div>--}}
{{--<!-- /.card-body -->--}}
{{--<div class="card-footer">--}}
{{--Footer--}}
{{--</div>--}}
{{--<!-- /.card-footer-->--}}
{{--</div>--}}
{{--<!-- /.card -->--}}

{{--</section>--}}
{{--<!-- /.content -->--}}

{{--</div>--}}
{{--<!-- /.content-wrapper -->--}}