@extends('templates.content',[
    'title'=>'Products',
    'description'=>'List of Products',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Products')
    ]
])
@section('title','Products Masterlist')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}"/>
    <style>
        a {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        a:hover {
            color: #3b5998;
            text-decoration: none; /* no underline */
        }
        .xwrapper {
            display : flex;
            align-items : center;
        }
    </style>
@endsection
@php
    $v = request()->v;
@endphp
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
                <div class="card-header card-header-icon">
                    <h4 class="card-title" style="display: inline-block">Products</h4>
                </div>
                @if(auth()->user()->isAuthorized('Products','M'))
                <div class="card-body">
                    <h3 class="card-title">
                        <a href="/product/new" id="add-warehouse" class="btn btn-flat pull-right btn-fill btn-danger btn-md" style="margin-left: 8px;">Add Product</a>
                    </h3>
                </div>
                @endif
                <div class="card-body">
                    <div class="material-datatables">
                        <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
                            <form method="get" id="frmParams">
                                <div class="row">
                                    <div class="col-lg-4 col-md 12 align-middle" style="display: inline-flex;">
                                        <span class="xwrapper">
                                            Show
                                        </span>
                                        <span class=" ml-2 pr-2">
                                            <select id="selPerPage" class="form-control" name="v" style="width: 100px;">
                                                <option></option>
                                                <option value="10" {{ (!$v or $v==10)?"selected":"" }}>10</option>
                                                <option value="25" {{ $v==25?"selected":"" }}>25</option>
                                                <option value="50" {{ $v==50?"selected":"" }}>50</option>
                                                <option value="All" {{ $v=="All"?"selected":"" }}>All</option>
                                            </select>
                                        </span>
                                        <span class="xwrapper">
                                            Entries
                                        </span>
                                    </div>
                                    <div class="col-lg-6 col-md-12"></div>
                                    <div class="col-lg-2 col-md-12">
                                        <div class="input-group float-right">
                                            <input type="search" id="txtSearch" name="s" class="form-control float-right" value="{{ request()->s }}"/>
                                            <span class="input-group-append">
                                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="productTable" class="table table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                                        <thead>
                                        <tr role="row">
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Product Line</th>
                                            <th class="text-right">Total Stock</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Product Line</th>
                                            <th class="text-right">Total Stock</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>

                                        @php

                                            $products = new \App\Product();


                                            if(request()->has('s')) {
                                                $products = $products->
                                                where('Name','like','%'.request('s').'%')->
                                                orWhere('Description','like','%'.request('s').'%')->
                                                orWhere('UniqueID','like','%'.request('s').'%');
                                            }


                                            if(request()->has('v')) {
                                                $page = request()->v;
                                                if($page=="All") {
                                                    $products = $products->paginate($products->count())->appends([
                                                        's' => request('s'),
                                                        'v' => request('v')
                                                    ]);
                                                } else {
                                                    $products = $products->paginate(request()->v)->appends([
                                                        's' => request('s'),
                                                        'v' => request('v')
                                                    ]);
                                                }
                                            } else {
                                                $products = $products->paginate(10)->appends([
                                                    's' => request('s')
                                                ]);
                                            }

                                        @endphp
                                        @if($products->count()>0)
                                            @foreach($products as $product)
                                                @php($uom = $product->UOM()!=null?$product->UOM()->Abbreviation:"")
                                                <tr role="row" class="{{ $loop->index % 2 ? "odd":"even" }}">
                                                    <td><a href="/product/view/{{ $product->UniqueID }}">{{ $product->UniqueID }}</a></td>
                                                    <td>{{ $product->Name }}</td>
                                                    <td>{{ $product->Description }}</td>
                                                    <td>{{ $product->Category()->Description }}</td>
                                                    <td>{{ $product->ProductLine()->Description }}</td>
                                                    <td class="text-right">{{ sprintf('%d %s',($product->getAvailableQuantity()), $uom) }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="100%" style="text-align: center; vertical-align: middle;">
                                                    No Data Available
                                                </td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="dataTables_paginate paging_full_numbers float-right">
                                {{ $products->links('templates.pagination.default') }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end content-->
            </div>
            <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script>

        var perPage = $('#selPerPage').select2({
            width: '100%',
            placeholder: "Select Filter",
            minimumResultsForSearch: -1
        });


        perPage.on('change', function(){
            $('#frmParams').submit();
        });

    </script>
@endsection