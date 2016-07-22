<div class="content">
    <div class="container-padding">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body table-responsive" style="min-width: 310px; height: 400px; margin: 0 auto">


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
                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$region = $this->session->userdata('lswdo_regioncode');
?>

<div class="content">
    <div class="container-padding">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body table-responsive">

                    <div>
                        <center><h4>Compliance & Non-Compliance</h4></center>
                        <?php echo form_open('dashboardc/dashboard/',array('class'=>'form-horizontal')) ?>
                        <table>
                            <!--LGU Type-->
                            <tr>
                                <td><b>LGU Type:</b></td>
                                <td>
                                    <div id="div_lgulist" class="col-lg-8">
                                        <select id="LGUtype" name = "LGUtype" class="form-control" onchange = "get_lguType(this.value);">
                                            <option value = "0">Please Select</option>
                                            <option value = "1">PSWDO</option>
                                            <option value = "2">CSWDO</option>
                                            <option value = "3">MSWDO</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><button type="submit" name="submit" value="1" class="btn-rounded btn btn-option2">Submit</button></td>
                            </tr>
                        </table>
                        <?php echo form_close() ?>
                        <?php if($lguType != 0){
                            if($lguType == 1){
                                $lgu = 'PSWDO';
                            }
                            if($lguType == 2){
                                $lgu = 'CSWDO';
                            }
                            if($lguType == 3){
                                $lgu = 'MSWDO';
                            }
                        ?>
                           <!-- Non-Compliance  -->
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
                                            categories: [<?php echo $nonComplianceName;?>],
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
                                            data: [<?php echo $nonCompliance;?>]
                                        }]
                                    });
                                });

                            </script>
                            <!-- Non-Compliance  -->
                            <!-- Compliance  -->
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
                                            text: 'Compliance'
                                        },
                                        xAxis: {
                                            categories: [<?php echo $complianceName;?>],
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
                                            data: [<?php echo $compliance;?>]
                                        }]
                                    });
                                });

                            </script>
                            <!-- Compliance  -->
                            <table width = "100%">
                                <tr>
                                    <td align ="center"> TOP 10 <?php echo $lgu; ?></td>
                                </tr>
                                <tr>
                                    <td><div id="container1" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div></td>
                                </tr>

                                <tr>
                                    <td><div id="container2" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div></td>
                                </tr>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
