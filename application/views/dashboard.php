


<div class="content">

    <div class="container-padding">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body table-responsive">
<!--                    --><?php //echo $this->session->userdata('user_id'); ?>
                    <!DOCTYPE HTML>
                    <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <title>Highcharts Example</title>


<pre>
<?php
$region_name = "";
$ffscore_format = "";
$fscore_format = "";
$pfscore_format = "";
$newscore = "";
$ff = 0;
$f = 0;
$pf = 0;
$ffscore = "";
$fscore = "";
$pfscore = "";
print_r($getIndicator);

//$newArray = array();
//
//foreach ($getIndicator['target2'] as $key => $innerArr1) {
//    $newArray['target'][$key] = array_merge(
//        $getIndicator['target1'][$key],  /* 0th and 1st index */
//        array($innerArr1[1])        /* 2nd index    //     */
//    );
//}
//
//print_r($newArray);


foreach($getIndicator as $getIn):
    $region_name .= "'".$getIn->region_name."',";


    echo $getIn->profile_id;
    echo "</br>";
    echo $getIn->FinalScore;
    echo "</br>";
    $getPerc = $getIn->FinalScore;
    if($getPerc == 100){
        $ff++;

    }
    else
    {
        $ff = $ff +0;
    }
    if($getPerc > 50 && $getPerc < 100){
        $f++;

    }
    else
    {
        $f = $f +0;
    }
    if($getPerc < 51) {
        $pf++;

    }
    else
    {
        $pf = $pf +0;
    }
    $ffscore .= "".$ff.",";
    $fscore .= "".$f.",";
    $pfscore .= "".$pf.",";

endforeach;

$region_format =  substr($region_name,0,-1);
$ffscore_format =  substr($ffscore,0,-1);
$fscore_format =  substr($fscore,0,-1);
$pfscore_format =  substr($pfscore,0,-1);
echo "</br>";
echo $ffscore_format;
echo "</br>";
echo $fscore_format;
echo "</br>";
echo $pfscore_format;

?>



</pre>



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
                    </head>
                    <body>

                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                    </body>
                    </html>



                </div>
            </div>
        </div>
    </div>
</div>
