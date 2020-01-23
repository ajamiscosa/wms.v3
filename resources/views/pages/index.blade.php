@extends('templates.content',[
    'title'=>"",
    'description'=>'',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home')
    ]
])

@section('title','Dashboard')

@section('styles')
@endsection

@if(auth()->user()->isAuthorized('Dashboard','V') || auth()->user()->isAdministrator() || auth()->user()->isGeneralManager())
@section('content')

    <div class="row">        
        @if(auth()->user()->isMaterialsControl() || auth()->user()->isGeneralManager() )
            @include('templates.dashboard.warehouse-charts')
        @endif
        @if(auth()->user()->isAccounting() || auth()->user()->isGeneralManager() )
            @include('templates.dashboard.accounting-charts')
        @endif
    </div>

    <div class="row">
    </div>
@endsection
@endif

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
        });


    jQuery.extend({
        getValues: function(url) {
            var result = null;
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    result = data;
                }
            });
        return result;
        }
    });

    var results = $.getValues("/limitproduct"); // array
    console.log(results);

    var fdata = results;
    
    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Purchase Requests', 
          'Issuance Requests',
          'Purchase Orders',  
      ],
      datasets: [
        {
          data: fdata,
          backgroundColor : ['#f56954', '#f39c12','#00a65a'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    });


     var areaChartData = {
      //labels  : ['May','June'],
      datasets: [
        {
          label               : 'Purchase Request',
          backgroundColor     : 'rgba(0,166,90,0.9)',
          borderColor         : 'rgba(0,166,90,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(0,166,90,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(0,166,90,1)',
          //data                : [6,3]
        },
        {
          label               : 'Purchase Orders',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius         : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          //data                : [18,4]
        },
        {
          label               : 'Deliveries',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          //data                : [8,3]
        },
      ]
    }



    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      options: barChartOptions
    })

    function addData(chart, mlabel, xdata) {
        chart.config.data.datasets = [];
        chart.config.data.labels = [];
        
        chart.config.data.labels = mlabel;

        for (i = 0; i < xdata.length; i++) {
            areaChartData.datasets[i].data = xdata[i];
            chart.config.data.datasets.push(areaChartData.datasets[i]);
        }
        chart.update();
    }

    var mlabels = ['Purchase Requests', 'Issuance Requests', 'Purchase Orders'];
    var qwe = [
        [234, 234, 5],
        [22, 1, 123],
        [55,125,60]
    ]

     setTimeout(function() {
          addData(barChart, mlabels, qwe);
     }, 1000);

    // function addData(chart, xdata) {
	// 	chart.data.datasets.foreach((dataset) => {
    //             dataset.forEach((innerData) => {
    //                 innerData.push(xdata);
    //             });
    //     });
    //     chart.update();
    // }


    // var qwe = [
    //     {
    //         "values" : [
    //             3,4,5
    //         ]
    //     }
    // ];

    //  setTimeout(function() {
    //       addData(barChart, qwe);
    //  }, 1000)
    // 
    // console.log(areaChartData);
    // barChart.forEach(function(elem) {
    //     elem.forEach(function(dataElem) {
    //     })
    // });
    </script>
@endsection