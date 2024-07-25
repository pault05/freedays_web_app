@extends('Components.layout')

@section('content')

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <div class="mt-4">
        <h3 class="text-center mb-4">Statistics</h3>
    </div>

    <style>
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            height: 100%;
            width: 100%;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card">
                    <div id="container2">

                    </div>
                </div>
            </div>


            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card">
                    <div id="container3">
                        <h3>Free days per year</h3>

                    </div>
                </div>
            </div>
        </div>
    </div>



        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="card">
                        <div id="container">

                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="card">
                        <div id="container4">
                        </div>
                    </div>
                </div>
        </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Highcharts.chart('container', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Number of leaves per month',
                            align: 'left'
                        },
                        subtitle: {
                            text:
                                'Source: <a target="_blank" ' +
                                'href="https://www.indexmundi.com/agriculture/?commodity=corn">indexmundi</a>',
                            align: 'left'
                        },
                        xAxis: {
                            categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July','August', 'September', 'Octbober', 'November', 'December'],
                            crosshair: true,
                            accessibility: {
                                description: 'Months'
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'days'
                            }
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        series: [
                            {
                                name: 'Leaves',
                                data: @json(array_values($daysPerMonth->toArray())),
                                {{--data: @json($daysPerMonth)--}}

                            }
                        ]
                    });
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const requestsByDescription = @json($requestsByDescription);

                    console.log(requestsByDescription);
                    const data = Object.keys(requestsByDescription).map(key => ({
                        name: key,
                        y: requestsByDescription[key]
                    }));

                    Highcharts.chart('container2', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: 'Free Days Requests By Categories'
                        },
                        tooltip: {
                            valueSuffix: ' requests'
                        },
                        plotOptions: {
                            series: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.name}: {point.percentage:.1f} %'
                                }
                            }
                        },
                        credits: {
                            enabled: false
                        },
                        series: [{
                            name: 'Requests',
                            colorByPoint: true,
                            data: data
                        }]
                    });
                });
            </script>

            <script>
                const chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container3',
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 15,
                            beta: 15,
                            depth: 50,
                            viewDistance: 25
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            enabled: false
                        }
                    },
                    tooltip: {
                        headerFormat: '<b>{point.key}</b><br>',
                        pointFormat: 'Cars sold: {point.y}'
                    },
                    title: {
                        text: 'Number of leaves per year',
                        align: 'center'
                    },

                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        column: {
                            depth: 25
                        }
                    },
                    series: [{
                        data: [
                            @foreach($daysPerYear as $array)

                            ['{{ $array[0] }}', {{ $array[1]  }}],
                            @endforeach

                        ],
                        colorByPoint: true
                    }]
                });

                function showValues() {
                    document.getElementById(
                        'alpha-value'
                    ).innerHTML = chart.options.chart.options3d.alpha;
                    document.getElementById(
                        'beta-value'
                    ).innerHTML = chart.options.chart.options3d.beta;
                    document.getElementById(
                        'depth-value'
                    ).innerHTML = chart.options.chart.options3d.depth;
                }

                document.querySelectorAll(
                    '#sliders input'
                ).forEach(input => input.addEventListener('input', e => {
                    chart.options.chart.options3d[e.target.id] = parseFloat(e.target.value);
                    showValues();
                    chart.redraw(false);
                }));

                showValues();

            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const formattedData = @json($formattedData);

                    if (formattedData.categories.length === 0) {
                        document.getElementById('container4').innerHTML = 'No data available';
                        return;
                    }

                    const categories = formattedData.categories;
                    console.log(formattedData);
                    const seriesData = [];



                    categories.forEach((category) => {
                        const data = formattedData.data.map(yearData => yearData[category] || 0);
                        seriesData.push({
                            name: category,
                            data: data
                        });
                    });

                    Highcharts.chart('container4', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Leaves per Category per Year',
                            align: 'left'
                        },
                        xAxis: {
                            categories: formattedData.years
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Number of Leaves'
                            },
                            stackLabels: {
                                enabled: true
                            }
                        },
                        legend: {
                            align: 'left',
                            x: 70,
                            verticalAlign: 'top',
                            y: 70,
                            floating: true,
                            backgroundColor:
                                Highcharts.defaultOptions.legend.backgroundColor || 'white',
                            borderColor: '#CCC',
                            borderWidth: 1,
                            shadow: false
                        },
                        tooltip: {
                            headerFormat: '<b>{point.x}</b><br/>',
                            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal',
                                dataLabels: {
                                    enabled: true
                                }
                            }
                        },
                        series: seriesData
                    });
                });
            </script>


@endsection
