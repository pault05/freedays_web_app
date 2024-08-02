@extends('components.layout')

@section('content')

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>


    <br>

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
                const daysPerMonth = @json($daysPerMonth);

                Highcharts.chart('container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Number of leaves per month',
                        align: 'center'
                    },
                    xAxis: {
                        categories: Object.keys(daysPerMonth),
                        crosshair: true,
                        accessibility: {
                            description: 'Months'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Days'
                        }
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    series: [
                        {
                            name: 'Leaves',
                            data: Object.values(daysPerMonth)

                        }]
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const requestsByCategory = @json($requestsByCategory);
                const categoryColors = @json($formattedData['categoryColors']);
                const data = Object.keys(requestsByCategory).map(key => ({
                    name: key,
                    y: requestsByCategory[key],
                    color: categoryColors[key]
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
            document.addEventListener('DOMContentLoaded', function () {
                const formattedData = @json($formattedData);
                const users = formattedData.users;
                const years = formattedData.years;

                const seriesData = users.map(user => ({
                    name: user,
                    data: years.map(year => {
                        const userData = formattedData.data.find(d => d.user === user && d.year == year) || {};
                        const totalLeaves = formattedData.categories.reduce((sum, category) => sum + (userData[category] || 0), 0);
                        return totalLeaves;
                    })
                }));

                Highcharts.chart('container3', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Number of leaves per year',
                        align: 'center'
                    },
                    xAxis: {
                        categories: years,
                        crosshair: true,
                        title: {
                            text: 'Year'
                        },
                        accessibility: {
                            description: 'Years'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Number of leaves'
                        }
                    },
                    tooltip: {
                        headerFormat: '<b>{point.x}</b><br/>',
                        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                formatter: function () {
                                    return this.y > 0 ? this.y : '0';
                                }
                            }
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    series: seriesData
                });
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const formattedData = @json($formattedData);

                const categories = formattedData.categories;
                const users = formattedData.users;
                const categoryColors = formattedData.categoryColors;

                const seriesData = categories.map(category => ({
                    name: category,
                    data: users.map(user => {
                        const userData = formattedData.data.find(item => item.user === user);
                        return userData ? (userData[category] || 0) : 0;
                    }),
                    color: categoryColors[category]
                }));

                Highcharts.chart('container4', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Number of Leaves per Year per Category',
                        align: 'center'
                    },
                    xAxis: {
                        categories: users
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
                        backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
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
                    credits: {
                        enabled: false
                    },
                    series: seriesData
                });
            });
        </script>

@endsection
