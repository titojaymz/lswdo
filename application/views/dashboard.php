


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

//$score = "";
//$newscore = "";
//$region_name = "";
//
//foreach ($getRegionName as $getRegName):
//    $region_name .= "'".$getRegName->region_name."',";
//
//    foreach ($getIndicator as $getIn):
//
//        if($getRegName->region_name == $getIn->region_name)
//        {
//
//            $newscore .= "".$getIn->TotalScore.",";
////            break;
//        }
//        else
//        {
//
//            $newscore .= "0,";
////            break;
//        }
//
//    endforeach;
//
//    $score_format =  substr($newscore,0,-1);
//
//endforeach;
//$region_format =  substr($region_name,0,-1);
//echo $region_format;
//echo "<br>";
//echo "<br>";
//echo $newscore;

///test



$score = "";
$newscore = "";
$newArray = array();
foreach($getRegionName  as $getRegName):
    $arr = $getRegName->region_name;
    $first = $arr;
    foreach($getIndicator  as $getIn):
        if($getRegName->region_name == $getIn->region_name)
        {
            $newArray[$first][1] = $getIn->lgu_type_id;
            $newArray[$first][2] = $getIn->TotalScore;
            $newArray[$first][3] = $getIn->FinalScore;

        } else {
            $newArray[$first][1] = "";
            $newArray[$first][2] = 0;
            $newArray[$first][3] = 0;
        }
    endforeach;
endforeach;

print_r($newArray);
/*foreach ($getIndicator as $getIn):
    $score = "".$getIn->TotalScore."";
    $region_name ="";

    foreach ($getRegionName as $getRegName):

            if($getRegName->region_name == $getIn->region_name)
            {
                $region_name .= "'".$getIn->region_name."',";
                $newscore .= "".$score.",";
                break;

            }
            else
            {
                $region_name .= "'".$getRegName->region_name."',";
                $newscore .= "0,";


            }

    endforeach;

    $region_format =  substr($region_name,0,-1);


endforeach;
echo $region_format;
echo "<br>";
echo "<br>";
echo $newscore;
$score_format =  substr($newscore,0,-1);*/

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
                                        categories: [<?php echo $region_format;?>
                                        ],
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
                                        data: [<?php echo $score_format;?>]

                                    }, {
                                        name: 'Functional',
                                        data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3, 105.0, 104.3, 91.2, 83.5, 106.6]

                                    }, {
                                        name: 'Partially Functional',
                                        data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2, 105.0, 104.3, 91.2, 83.5, 106.6]

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
