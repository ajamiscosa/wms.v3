@extends('templates.content',[
    'title'=>"Welcome, ".auth()->user()->Person()->Name()."!",
    'description'=>'Below are few helpful information to get you started.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home')
    ]
])

@section('title','Dashboard')

@section('styles')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <!-- small box -->
            <div class="small-box bg-info flat">
                <div class="inner">
                    <h3>150</h3>

                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- small box -->
            <div class="small-box bg-success flat">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- small box -->
            <div class="small-box bg-warning flat">
                <div class="inner">
                    <h3>44</h3>

                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card flat">
                <div class="card-header no-border">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Sales</h3>
                        <a href="javascript:void(0);">View Report</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">$18,230.00</span>
                            <span>Sales Over Time</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fa fa-arrow-up"></i> 33.1%
                    </span>
                            <span class="text-muted">Since last month</span>
                        </p>
                    </div>
                    <!-- /.d-flex -->

                    <div class="position-relative mb-4">
                        <canvas id="sales-chart" height="200" width="571" class="chartjs-render-monitor" style="display: block; width: 571px; height: 200px;"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fa fa-square text-primary"></i> This year
                  </span>

                        <span>
                    <i class="fa fa-square text-gray"></i> Last year
                  </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card flat">
                <div class="card-header no-border">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Online Store Visitors</h3>
                        <a href="javascript:void(0);">View Report</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">820</span>
                            <span>Visitors Over Time</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fa fa-arrow-up"></i> 12.5%
                    </span>
                            <span class="text-muted">Since last week</span>
                        </p>
                    </div>
                    <!-- /.d-flex -->

                    <div class="position-relative mb-4">
                        <canvas id="visitors-chart" height="200" width="571" class="chartjs-render-monitor" style="display: block; width: 571px; height: 200px;"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fa fa-square text-primary"></i> This Week
                  </span>

                        <span>
                    <i class="fa fa-square text-gray"></i> Last Week
                  </span>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Latest Purchase Orders</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0" style="display: block;">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Requested By</th>
                                <th class='text-center'>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\PurchaseOrder::all() as $po)
                                @php($counter = 0)
                                @if($counter<10)
                                    @if($po->Status != 'D')
                                    <tr>
                                        <td><a href="/purchase-order/view/{{ $po->OrderNumber }}">{{ $po->OrderNumber }}</a></td>
                                        <td>{{ $po->Requester()->Person()->Name() }}</td>
                                        <td class='text-center'><span class="badge flat badge-success">Shipped</span></td>
                                    </tr>
                                    @endif
                                    @php($counter++)
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix" style="display: block;">
                    <a href="/purchase-order" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                </div>
                <!-- /.card-footer -->
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Latest Issuance Requests</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0" style="display: block;">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Item</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach(\App\Requisition::IssuanceRequests() as $ir)
                                @php($counter = 0)
                                @if($counter<10)
                                    @if($ir->Status != 'D')
                                        <tr>
                                            <td><a href="/issuance-request/view/{{ $ir->OrderNumber }}">{{ $ir->OrderNumber }}</a></td>
                                            <td>{{ $ir->Requester()->Name() }}</td>
                                            <td class='text-center'>
                                                <span class="badge flat badge-success">Shipped</span>
                                            </td>
                                        </tr>
                                    @endif
                                    @php($counter++)
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix" style="display: block;">
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                </div>
                <!-- /.card-footer -->
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script>
        $(function () {
            'use strict'

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode      = 'index'
            var intersect = true

            var $salesChart = $('#sales-chart')
            var salesChart  = new Chart($salesChart, {
                type   : 'bar',
                data   : {
                    labels  : ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC', 'JAN', 'FEB', 'MAR', 'APR', 'MAY'],
                    datasets: [
                        {
                            backgroundColor: '#007bff',
                            borderColor    : '#007bff',
                            data           : [1000, 2000, 3000, 2500, 2700, 2500, 3000]
                        },
                        {
                            backgroundColor: '#ced4da',
                            borderColor    : '#ced4da',
                            data           : [700, 1700, 2700, 2000, 1800, 1500, 2000]
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips           : {
                        mode     : mode,
                        intersect: intersect
                    },
                    hover              : {
                        mode     : mode,
                        intersect: intersect
                    },
                    legend             : {
                        display: false
                    },
                    scales             : {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display      : true,
                                lineWidth    : '4px',
                                color        : 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks    : $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    if (value >= 1000) {
                                        value /= 1000
                                        value += 'k'
                                    }
                                    return '$' + value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display  : true,
                            gridLines: {
                                display: false
                            },
                            ticks    : ticksStyle
                        }]
                    }
                }
            })

            var $visitorsChart = $('#visitors-chart')
            var visitorsChart  = new Chart($visitorsChart, {
                data   : {
                    labels  : ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
                    datasets: [{
                        type                : 'line',
                        data                : [100, 120, 170, 167, 180, 177, 160],
                        backgroundColor     : 'transparent',
                        borderColor         : '#007bff',
                        pointBorderColor    : '#007bff',
                        pointBackgroundColor: '#007bff',
                        fill                : false
                        // pointHoverBackgroundColor: '#007bff',
                        // pointHoverBorderColor    : '#007bff'
                    },
                        {
                            type                : 'line',
                            data                : [60, 80, 70, 67, 80, 77, 100],
                            backgroundColor     : 'tansparent',
                            borderColor         : '#ced4da',
                            pointBorderColor    : '#ced4da',
                            pointBackgroundColor: '#ced4da',
                            fill                : false
                            // pointHoverBackgroundColor: '#ced4da',
                            // pointHoverBorderColor    : '#ced4da'
                        }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips           : {
                        mode     : mode,
                        intersect: intersect
                    },
                    hover              : {
                        mode     : mode,
                        intersect: intersect
                    },
                    legend             : {
                        display: false
                    },
                    scales             : {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display      : true,
                                lineWidth    : '4px',
                                color        : 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks    : $.extend({
                                beginAtZero : true,
                                suggestedMax: 200
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display  : true,
                            gridLines: {
                                display: false
                            },
                            ticks    : ticksStyle
                        }]
                    }
                }
            })
        })
    </script>
@endsection