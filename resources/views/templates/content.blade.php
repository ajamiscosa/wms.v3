@extends('app')
@section('site-content')
<style>
    hr {
        border-color: #D2D6DE;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                    <h5><small>{{ $description }}</small></h5>
                </div>
                <div class="col-sm-6">
                    @include('templates.breadcrumb', $breadcrumbs)
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content container-fluid">
        @yield('content')
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection