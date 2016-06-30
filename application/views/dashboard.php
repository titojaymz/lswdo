<div class="content">
    <div class="container-padding">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body table-responsive">

                    <?php
                    $f = '';
                    $ff = '';
                    $pf = '';
                    $region = '';

                    foreach($getIndicator as $item):

                        $f .= $item->Functional.',';
                        $ff .= $item->FullyFunctional.',';
                        $pf .= $item->PartiallyFunctional.',';
                        $region .= "'".$item->region_name."',";

                    endforeach;
                    $region_format =  substr($region,0,-1);
                    $ffscore_format =  substr($ff,0,-1);
                    $fscore_format =  substr($f,0,-1);
                    $pfscore_format =  substr($pf,0,-1);
                    ?>

                    <?php
                    $unformat = "";
                    $unformat2 = "";

                    foreach($pgetScorePart1 as $key=>$value){
                        $unformat .= '"'.$value['indicator_name'].'",';
                        $unformat2 .= "".$value['TotalNonCompliance'].",";
                    }
                    $pswdoIndicator = substr($unformat,0,-1);
                    $pswdoNon = substr($unformat2,0,-1);
                    ?>

<!--                    --><?php //print_r($pswdoIndicator)?>

                    <?php
                    $unformat = "";
                    $unformat2 = "";
                    foreach($cgetScorePart1 as $key=>$value){
                        $unformat .= '"'.$value['indicator_name'].'",';
                        $unformat2 .= "".$value['TotalNonCompliance'].",";
                    }
                    $cswdoIndicator = substr($unformat,0,-1);
                    $cswdoNon = substr($unformat2,0,-1);
                    ?>

                    <?php
                    $unformat = "";
                    $unformat2 = "";
                    foreach($mgetScorePart1 as $key=>$value){
                        $unformat .= '"'.$value['indicator_name'].'",';
                        $unformat2 .= "".$value['TotalNonCompliance'].",";
                    }
                    $mswdoIndicator = substr($unformat,0,-1);
                    $mswdoNon = substr($unformat2,0,-1);
                    ?>


<!--Compliance-->

                    <?php
                    $unformat = "";
                    $unformat2 = "";
                    foreach($pgetScorePart2 as $key=>$value){
                        $unformat .= '"'.$value['indicator_name'].'",';
                        $unformat2 .= "".$value['TotalCompliance'].",";
                    }
                    $pswdoIndicator1 = substr($unformat,0,-1);
                    $pswdoCom= substr($unformat2,0,-1);
                    ?>
<!---->
<!--                    <pre> --><?php //print_r($pswdoIndicator1)?>
<!---->
<!--                        </pre>-->

                    <?php
                    $unformat = "";
                    $unformat2 = "";
                    foreach($cgetScorePart2 as $key=>$value){
                        $unformat .= '"'.$value['indicator_name'].'",';
                        $unformat2 .= "".$value['TotalCompliance'].",";
                    }
                    $cswdoIndicator1 = substr($unformat,0,-1);
                    $cswdoCom = substr($unformat2,0,-1);
                    ?>

                    <?php
                    $unformat = "";
                    $unformat2 = "";
                    foreach($mgetScorePart2 as $key=>$value){
                        $unformat .= '"'.$value['indicator_name'].'",';
                        $unformat2 .= "".$value['TotalCompliance'].",";
                    }
                    $mswdoIndicator1 = substr($unformat,0,-1);
                    $mswdoCom = substr($unformat2,0,-1);
                    ?>
                    <style type="text/css">
                        ${demo.css}
                    </style>
                    <script type="text/javascript">
                        $(function () {
                            $('#container').highcharts({
                                chart: {
                                    type: 'column'
                                },
                                title: {
                                    text: 'Level of functionality'
                                },
                                subtitle: {
                                    text: ''
                                },
                                xAxis: {
                                    categories: [<?php echo $region_format;?>],
                                    crosshair: true
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: ''
                                    }
                                },
                                tooltip: {
                                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                                    footerFormat: '</table>',
                                    shared: true,
                                    useHTML: true
                                },
                                plotOptions: {
                                    column: {
                                        pointPadding: 0.2,
                                        borderWidth: 0
                                    }
                                },
                                series: [{
                                    name: 'Fully Functional',
                                    data: [<?php echo $ffscore_format;?>]

                                }, {
                                    name: 'Functional',
                                    data: [<?php echo $fscore_format;?>]

                                }, {
                                    name: 'Partially Functional',
                                    data: [<?php echo $pfscore_format;?>]

                                }]
                            });
                        });
                    </script>

                    <script type="text/javascript">
                        $(function () {
                            $('#container1').highcharts({
                                chart: {
                                    type: 'bar'
                                },
                                title: {
                                    text: ''
                                },
                                subtitle: {
                                    text: 'Non-Compliance'
                                },
                                xAxis: {
                                    categories: [<?php echo $pswdoIndicator;?>],
                                    title: {
                                        text: null
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    allowDecimals: false,
                                    title: {
                                        text: 'Respondents',
                                        align: 'high'
                                    },
                                    labels: {
                                        overflow: 'justify'
                                    }
                                },
                                tooltip: {
                                    valueSuffix: ''
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
                                    name: 'Respondents',
                                    data: [<?php echo $pswdoNon;?>]
                                }]
                            });
                        });

                    </script>
                    <script type="text/javascript">
                        $(function () {
                            $('#container2').highcharts({
                                chart: {
                                    type: 'bar'
                                },
                                title: {
                                    text: ''
                                },
                                subtitle: {
                                    text: 'Non-Compliance'
                                },
                                xAxis: {
                                    categories: [<?php echo $cswdoIndicator;?>],
                                    title: {
                                        text: null
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    allowDecimals: false,
                                    title: {
                                        text: 'Respondents',
                                        align: 'high'
                                    },
                                    labels: {
                                        overflow: 'justify'
                                    }
                                },
                                tooltip: {
                                    valueSuffix: ''
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
                                    name: 'Respondents',
                                    data: [<?php echo $cswdoNon;?>]
                                }]
                            });
                        });

                    </script>
                    <script type="text/javascript">
                        $(function () {
                            $('#container3').highcharts({
                                chart: {
                                    type: 'bar'
                                },
                                title: {
                                    text: ''
                                },
                                subtitle: {
                                    text: 'Non-Compliance'
                                },
                                xAxis: {
                                    categories: [<?php echo $mswdoIndicator;?>],
                                    title: {
                                        text: null
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    allowDecimals: false,
                                    title: {
                                        text: 'Respondents',
                                        align: 'high'
                                    },
                                    labels: {
                                        overflow: 'justify'
                                    }
                                },
                                tooltip: {
                                    valueSuffix: ''
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
                                    name: 'Respondents',
                                    data: [<?php echo $mswdoNon;?>]
                                }]
                            });
                        });

                    </script>


                    <script type="text/javascript">
                        $(function () {
                            $('#container4').highcharts({
                                chart: {
                                    type: 'bar'
                                },
                                title: {
                                    text: ''
                                },
                                subtitle: {
                                    text: 'Compliance'
                                },
                                xAxis: {
                                    categories: [<?php echo $pswdoIndicator1;?>],
                                    title: {
                                        text: null
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    allowDecimals: false,
                                    title: {
                                        text: 'Respondents',
                                        align: 'high'
                                    },
                                    labels: {
                                        overflow: 'justify'
                                    }
                                },
                                tooltip: {
                                    valueSuffix: ''
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
                                    name: 'Respondents',
                                    data: [<?php echo $pswdoCom;?>]
                                }]
                            });
                        });

                    </script>
                    <script type="text/javascript">
                        $(function () {
                            $('#container5').highcharts({
                                chart: {
                                    type: 'bar'
                                },
                                title: {
                                    text: ''
                                },
                                subtitle: {
                                    text: 'Compliance'
                                },
                                xAxis: {
                                    categories: [<?php echo $cswdoIndicator1;?>],
                                    title: {
                                        text: null
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    allowDecimals: false,
                                    title: {
                                        text: 'Respondents',
                                        align: 'high'
                                    },
                                    labels: {
                                        overflow: 'justify'
                                    }
                                },
                                tooltip: {
                                    valueSuffix: ''
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
                                    name: 'Respondents',
                                    data: [<?php echo $cswdoCom;?>]
                                }]
                            });
                        });

                    </script>
                    <script type="text/javascript">
                        $(function () {
                            $('#container6').highcharts({
                                chart: {
                                    type: 'bar'
                                },
                                title: {
                                    text: ''
                                },
                                subtitle: {
                                    text: 'Compliance'
                                },
                                xAxis: {
                                    categories: [<?php echo $mswdoIndicator;?>],
                                    title: {
                                        text: null
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    allowDecimals: false,
                                    title: {
                                        text: 'Respondents',
                                        align: 'high'
                                    },
                                    labels: {
                                        overflow: 'justify'
                                    }
                                },
                                tooltip: {
                                    valueSuffix: ''
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
                                    name: 'Respondents',
                                    data: [<?php echo $mswdoCom;?>]
                                }]
                            });
                        });

                    </script>
                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                    <table class="table" >
                        <tr>
                            <td align ="center" colspan="2">
                                TOP 10 PSWDO
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="container4" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                            </td>
                            <td>
                                <div id="container1" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                            </td>
                        </tr>

                        <tr>
                            <td align ="center" colspan="2">
                                TOP 10 CSWDO
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="container5" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                            </td>
                            <td>
                                <div id="container2" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                            </td>
                        </tr>

                        <tr>
                            <td align ="center" colspan="2">
                                TOP 10 MSWDO
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="container6" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                            </td>
                            <td>
                                <div id="container3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                            </td>
                        </tr>

<!--                        <tr>-->
<!--                            <td>-->
<!---->
<!--                            <div id="container5" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>-->
<!--                            <div id="container6" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>-->
<!--                            </td>-->
<!--                            <td>-->
<!---->
<!--                            <div id="container2" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>-->
<!--                            <div id="container3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>-->
<!--                            </td>-->
<!--                        </tr>-->
                    </table>




                </div>
            </div>
        </div>
    </div>
</div>
