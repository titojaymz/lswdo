<div class="content">

    <div class="container-padding">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body table-responsive">
                    <?php echo $this->session->userdata('user_id'); ?>
                    <!DOCTYPE HTML>
                    <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>Highcharts Example</title>

                        <style type="text/css">
                            ${demo.css}
                        </style>
                        <script type="text/javascript">
                            $(function () {
                                $('#container').highcharts({
                                    chart: {
                                        type: 'bar'
                                    },
                                    title: {
                                        text: 'SAMPLE DASHBOARD'
                                    },
                                    subtitle: {
                                        text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
                                    },
                                    xAxis: {
                                        categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
                                        title: {
                                            text: null
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Population (millions)',
                                            align: 'high'
                                        },
                                        labels: {
                                            overflow: 'justify'
                                        }
                                    },
                                    tooltip: {
                                        valueSuffix: ' millions'
                                    },
                                    plotOptions: {
                                        bar: {
                                            dataLabels: {
                                                enabled: true
                                            }
                                        }
                                    },
                                    legend: {
                                        layout: 'vertical',
                                        align: 'right',
                                        verticalAlign: 'top',
                                        x: -40,
                                        y: 80,
                                        floating: true,
                                        borderWidth: 1,
                                        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                                        shadow: true
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    series: [{
                                        name: 'Year 1800',
                                        data: [107, 31, 635, 203, 2]
                                    }, {
                                        name: 'Year 1900',
                                        data: [133, 156, 947, 408, 6]
                                    }, {
                                        name: 'Year 2012',
                                        data: [1052, 954, 4250, 740, 38]
                                    }]
                                });
                            });
                        </script>
                    </head>
                    <body>

                    <div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>

                    </body>
                    </html>

                </div>
            </div>
        </div>
    </div>
</div>
