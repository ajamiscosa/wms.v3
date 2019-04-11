<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ $title }}
        <small>{{ $description }}</small>
    </h1>
    @include('templates.breadcrumb', $breadcrumbs)
</section>
<!-- Main content -->
<hr style="margin-top: 15px; margin-bottom: 0px; padding-bottom: 0px;"/>
<section class="content container-fluid">
    @yield('content')
</section>
<!-- /.content -->