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

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    Certification Details
                    <?php
                   // error_reporting(1);

                    ini_set('display_errors', 1);

                    //echo $updateResult;
                    ?>
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: block;">

                    <?php
                    //$profile_id = $getDataByProfileID->profile_id;
                    //$ref_id =
                    //echo "<input type=\"hidden\" id=\"profile_id\" name=\"profile_id\" class=\"form-control\" value ='".$profile_id."'/>";
                    $getCertList = $certification_model->getCertList();

                    echo "<a id ='btn_addCert' class='btn btn-lrg btn-primary' href= 'certificate_issuance_add'> Add Cert </a>";

                    ?>

                    <?php
                        $attributes = array("class" => "form-horizontal", "id" => "addCert", "name" => "addCert");
                        //echo form_open("certificate_issuance/certificate_issuance_add", $attributes);
                    ?>


                   <!-- <div class="btn-group">
                        <input id="btn_addCert" name="btn_addCert" type="submit" class="btn btn-primary" value="Add Cert"/>
                    </div>-->

                    <br/>
                    <h4>Certification Details</h4>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td align="center"><b>&nbsp;</b></td>
                            <td align="center"><b>Certificate No</b></td>
                            <td align="center"><b>Date Issued</b></td>
                            <td align="center"><b>Validity In Years</b></td>
                            <td align="center"><b>Valid until</b></td>
                            <!--<td align="center"><b>Visit Count</b></td>
                            <td align="center"><b>Visit Date</b></td>
                            <td align="center"><b>Remarks</b></td>-->

                        </tr>

                        <tr>

                            <?php

                                foreach($getCertList as $key=>$val)
                                {
                                    $ref_id_cert = $val['ref_id'];
                                    echo "<td align=\"center\"><b>";
                                    //echo $ref_id;
                                    //echo "monitoring_edit/".$ref_id.'/'.$profile_id;

                                    echo "<a class='btn btn-sm btn-primary' href= 'certificate_issuance_edit/$ref_id_cert/'>
                                            <i class=\"fa fa-edit\"></i>Edit </a>";
                                    echo " </b></td>";

                                    echo "<td align=\"center\"><b>" . $val['certificate_no'] ." </b></td>";

                                    $dateIssuedToDate = date_create($val['date_issued']);
                                    $date_issued_val = date_format($dateIssuedToDate, "F d, Y");

                                    echo "<td align=\"center\"><b>" . $date_issued_val ." </b></td>";

                                    $getValidityByID = $certification_model->getValidityByID($val['validity']);

                                    foreach($getValidityByID as $validityKey => $validityVal)
                                    {
                                        echo "<td align=\"center\"><b>" .$validityVal['validity_title'] ." </b></td>";

                                    }

                                    $strValidUntil = $val['day_valid'] . "-" . $val['month_valid'] . "-" . $val['year_valid'];
                                    $validUntilToDate = date_create($strValidUntil);
                                    $date_valid_val = date_format($validUntilToDate, "F d, Y");

                                    echo "<td align=\"center\"><b>".$date_valid_val." </b></td>";

                                    /*$getMonitoringListByRefID = $monitoring_model->getMonitoringListByRefID($ref_id_cert);

                                    foreach($getMonitoringListByRefID as $keyMonitoring => $valMonitoring)
                                    {
                                        echo "<td align=\"center\"><b>";
                                        //echo $valMonitoring['visit_count'];
                                        $getVisitCountByID = $monitoring_model->getVisitCountByID($valMonitoring['visit_count']);

                                        foreach($getVisitCountByID as $keyVisit => $valVisit)
                                        {
                                            echo $valVisit['visit_count'];
                                        }//end foreach $getVisitCountByID

                                        echo " </b></td>";

                                        echo "<td align=\"center\"><b>";

                                        $visitDateToDate = date_create($valMonitoring['visit_date']);
                                        $visit_date_val = date_format($visitDateToDate, "F d, Y");

                                        echo $visit_date_val;
                                        echo " </b></td>";

                                        //Remarks
                                        echo "<td align=\"center\"><b>" . $valMonitoring['remarks'] . " </b></td>";
                                    } //end foreach $getMonitoringListByRefID*/

                                    echo "</tr>";
                                }
                            ?>

                    </table>


                    <hr>


                    </div>
                    <?php //echo form_close() ?>
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
