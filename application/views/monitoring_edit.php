<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script>
    $(function() {
        $( "#visit_date" ).datepicker();
    });
    $(function() {
        $( "#date_issued" ).datepicker();
    });
</script><!--CARLA-->

<style type="text/css">
    body{background: #F5F5F5;}

</style>

<script>
    function validityDate()
    {
        var date_issued = document.getElementById("date_issued").value;
        var res = date_issued.split("/");
        var validity = document.getElementById("validity");

        var currentYear = parseInt(res[2]);
        var validYear = parseInt(validity.options[validity.selectedIndex].value);

        var addValidity = currentYear + validYear;

        document.getElementById("year_valid").value = addValidity;
    }

    function dateIssued()
    {
        var date_issued = document.getElementById("date_issued").value;
        var res = date_issued.split("/");
        //document.getElementById("month_valid").value = date_issued ;
        document.getElementById("month_valid").value = res[0];
        document.getElementById("day_valid").value = res[1];
    }

</script>

<body>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <!--  <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active">Assessment Information</li>
            <li class="active">Indicators</li>
            <li class="active">Monitoring</li>
            <li class="active">Edit</li>
        </ol>
    </div>
    <!-- End Page Header -->

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    Monitoring Details
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: block;">
                    <div class="btn-group">

                        <?php

                        $prof_id = $this->uri->segment('3'); //ref_id for tbl_lswdo_certificate; ref_cert_id for lswdo_monitoring
                        $ref_id = $this->uri->segment('4'); //$_GET['ref_cert_id']
                        echo "<input type =\"hidden\" id=\"ref_cert_id\" name=\"ref_cert_id\" type=\"text\" value=\"$ref_id\"/>";

                        $attributes = array("class" => "form-horizontal", "id" => "monitoringForm", "name" => "monitoringForm");
                        echo form_open("monitoring/monitoring_list", $attributes);

                        ?>
                                 <input id="btn_back" name="btn_back" type="submit" class="btn btn-primary" value="Back To List"/>
                                 <br/><br/>
                        <?php
                            echo form_close();
                        ?>

                    </div>
                    <?php
                        $attributes = array("class" => "form-horizontal", "id" => "monitoringForm", "name" => "monitoringForm");
                       // echo form_open("monitoring/monitoring_edit/$ref_id", $attributes);
                        echo form_open("", $attributes);


                    ?>

                    <table class="table table-bordered table-striped">

                        <!-- date Valid-->
                        <input type="hidden" id="month_valid" name="month_valid" class="form-control" placeholder="month_valid" />
                        <input type="hidden" id="day_valid" name="day_valid" class="form-control" placeholder="day_valid" />
                        <input type="hidden" id="year_valid" name="year_valid" class="form-control" placeholder="year_valid" />
                        <!-- date Valid-->

                                    <?php
//                                        $getMonitoringListByRefID = $monitoring_model->getMonitoringListByRefID($prof_id,$ref_id);
//
//                                        foreach ($getMonitoringListByRefID as $keyMonitoring => $valMonitoring)
//                                        {
//                                            //visit_count
//                                        echo "<tr>";
//                                        echo "<td align=\"center\"><b>Visit Count</b></td>";
//                                        echo "<td align=\"center\">";
//                                        echo "<select id = 'visit_count' name = 'visit_count' class=\"form-control\">";
//
//                                        $getVisitCount = $visit_model->getVisitCount();
//                                        foreach ($getVisitCount as $key=>$val)
//                                        {
//                                            echo "<option id='".$val['visit_id']."' value='".$val['visit_id']."'";
//
//                                            if($valMonitoring['visit_count'] == $val['visit_id'])
//                                            {
//                                                echo " selected = selected";
//                                                echo ">";
//                                                echo $val['visit_count'];
//
//
//                                            }else
//                                            {
//                                                echo " ";
//                                                echo ">";
//                                                echo $val['visit_count'];
//
//                                            }
//                                            echo "</option>";
//
//                                        }
//                                        echo "</select>";
//                                        echo "</td>";
//                                        echo "</tr>";
//
//                                        //visit_date
//                                        echo "<tr>";
//                                        echo "<td align=\"center\"><b>Visit Date</b></td>";
//                                        echo "<td align=\"center\">";
//                                        echo " <input type=\"text\" id=\"visit_date\" name=\"visit_date\" class=\"form-control\" value = '".$valMonitoring['visit_date']."' placeholder = 'Enter Visit Date' />";
//                                        echo "</td>";
//                                        echo "</tr>";
//
//                                        //remarks
//                                        echo "<tr>";
//                                        echo "<td align=\"center\"><b>Remarks</b></td>";
//                                        echo "<td align=\"center\">";
//                                        echo "<textarea class=\"form-control\" rows=\"3\" id=\"remarks\" name=\"remarks\" placeholder=\"Type your message...\">".$valMonitoring['remarks']."</textarea>";
//                                        echo "</td>";
//                                        echo "</tr>";


//                                        }//end of $getMonitoringListByRefID
                                    ?>

                        <tr>
                            <td><b>Visit Count</b></td>
                            <td align="center">
                            <?php
//                                print_r($getMonitoringList);
                            $getVisitCount = $visit_model->getVisitCount();
                                echo "<select id = 'visit_count' name = 'visit_count' class=\"form-control\">";
                                foreach ($getVisitCount as $key=>$val)
                                {

                                    if($val['visit_id'] == $getMonitoringList->visit_count) {
                                        echo "<option id='" . $val['visit_id'] . "' value='" . $val['visit_id'] . "' selected>";
                                    } else {
                                        echo "<option id='" . $val['visit_id'] . "' value='" . $val['visit_id'] . "'>";
                                    }
                                    echo $val['visit_count'];
                                    echo "</option>";
                                }
                                 echo "</select>";
                            ?>
                        </td>
                        </tr>
                        <tr>
                            <td><b>Status:</b></td>
                            <td align="center">
                                <?php
                                //print_r($getVisitCount);
                                echo "<select id = 'visit_status' name = 'visit_status' class=\"form-control\">";
                                echo "<option id = '#'>Please Select</option>";
                                foreach ($getStatus as $key=>$val)
                                {
                                if($val['status_id'] == $getMonitoringList->visit_status) {
                                    echo "<option value='" . $val['status_id'] . "' selected>";
                                } else {
                                    echo "<option value='" . $val['status_id'] . "'>";
                                }
                                    echo $val['status_name'];
                                    echo "</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>
                        </tr>
                        <td><b>Visit Date</b></td>
                        <td align="center">
                            <input type="text" id="visit_date" name="visit_date" class="form-control" placeholder = 'Enter Visit Date' value = '<?php echo $getMonitoringList->visit_date ?>'/>
                        </td>
                        </tr>
                        <tr>
                            <td><b>Remarks</b></td>
                            <td>
                                <textarea class="form-control" rows="3" id="remarks" name="remarks" placeholder="Type your message..."><?php echo  $getMonitoringList->remarks ?></textarea>
                            </td>
                        </tr>

                    </table>
<!--                                        $certificate_no = $this->input->post('certificate_no');-->
<!--                                        $current_certificate = '0';-->
<!--                                        //date-->
<!--                                        $strIssuedDate = $this->input->post('date_issued');-->
<!--                                        $issuedDateToDate = date_create($strIssuedDate);-->
<!--                                        $date_issued = date_format($issuedDateToDate, "Y-m-d");-->
<!--                                        //date-->
<!---->
<!--                                        $validity = $this->input->post('validity');-->
<!--                                        $month_valid = $this->input->post('month_valid');-->
<!--                                        $day_valid = $this->input->post('day_valid');-->
<!--                                        $year_valid = $this->input->post('year_valid');-->
<!--                                        $DELETED = '0';-->
<!--                                        $modified_by = 104;-->
<!---->
<!--                                        //echo "Month Valid=>".$month_valid;-->
<!---->
<!--                                        $sql ='Update tbl_lswdo_certificate SET-->
<!--                                                certificate_no = "'.$certificate_no.'",-->
<!--                                                current_certificate = "'.$current_certificate.'",-->
<!--                                                date_issued = "'.$date_issued.'",-->
<!--                                                validity = "'.$validity.'",-->
<!--                                                month_valid = "'.$month_valid.'",-->
<!--                                                day_valid = "'.$day_valid.'",-->
<!--                                                year_valid = "'.$year_valid.'",-->
<!--                                                modified_by = "'.$modified_by.'",-->
<!--                                                date_modified = now(),-->
<!--                                                DELETED = "'.$DELETED.'"-->
<!--                                                WHERE-->
<!--                                                ref_id = "'.$ref_id.'"-->
<!--                                                ';-->
<!---->
<!--//                                        echo $sql;-->
<!---->
<!---->
<!--                                    ?>-->
                    </table>





                    <hr>
                    <div class="btn-group">
                        <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Update" />
                    </div>

                    </div>
                    <?php echo form_close() ?>
                    <!--              <pre>-->
                    <!--                    --><?php //print_r($getSecondCategory); ?>
                    <!--                </pre>-->
                    <?php //print_r($getSecondCategory); ?>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
