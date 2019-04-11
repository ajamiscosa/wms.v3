@extends('templates.content',[
    'title'=>"Consumption Report: $data->UniqueID *** WORK IN PROGRESS ***",
    'description'=>'View Product Consumption.',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Reports','/reports'),
        \App\Classes\Breadcrumb::create('Consumption','/consumption'),
        \App\Classes\Breadcrumb::create("$data->UniqueID"),
    ]
])
@php($data->IsReport = true)
@section('title',"Consumption Report: [$data->UniqueID] $data->Name *** WORK IN PROGRESS ***")
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icheck.square-red.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-12">
            @include('inventory.products.details', ['data'=>$data])
        </div>
        <div class="col-lg-8 col-md-12">
            @include('inventory.products.consumption', ['data'=>$data])
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script>
        var mode      = 'index';
        var intersect = true;

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        };

        var $visitorsChart = $('#visitors-chart');
        var visitorsChart  = new Chart($visitorsChart, {
            data   : {
                labels  : ['August', 'September', 'October', 'November', 'December', 'January'],
                datasets: [
                    {
                        type                : 'line',
                        data                : [0, 0, 0, 5, 10, 15, 18],
                        backgroundColor     : 'transparent',
                        borderColor         : '#007bff',
                        pointBorderColor    : '#007bff',
                        pointBackgroundColor: '#007bff',
                        fill                : false,
                         pointHoverBackgroundColor: '#007bff',
                         pointHoverBorderColor    : '#007bff'
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
                            beginAtZero : true,
                            suggestedMax: 177
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
        });
    </script>
@endsection