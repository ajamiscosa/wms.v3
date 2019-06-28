@extends('templates.content',[
    'title'=>" Page Not Found",
    'description'=>" ",
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Error')
    ]
])
@section('title',"Page Not Found")
@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 404</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-warning"></i> Oops!  not found.</h3>
                <p>
                    We could not find the page you were looking for.
                    Meanwhile, you may <a href="/">return to dashboard</a> or try using the search form.
                </p>
                <form class="search-form">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" name="submit" class="btn btn-warning"><i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.input-group -->
                </form>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
@endsection