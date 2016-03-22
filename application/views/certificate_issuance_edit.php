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
                    Monitoring Details
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: block;">
                    <div class="btn-group">

                        <?php

                        $ref_id = $this->uri->segment('3'); //ref_id for tbl_lswdo_certificate; ref_cert_id for lswdo_monitoring
                        //$ref_id = $this->uri->segment('4'); //$_GET['ref_cert_id']
                        echo "<input type =\"text\" id=\"ref_cert_id\" name=\"ref_cert_id\" type=\"text\" value=\"$ref_id\"/>";

                        $attributes = array("class" => "form-horizontal", "id" => "monitoringForm", "name" => "monitoringForm");
                        echo form_open("certificate_issuance/certificate_issuance_list", $attributes);

                        ?>
                        <input id="btn_back" name="btn_back" type="submit" class="btn btn-primary" value="Back To List"/>
                        <br/><br/>
                        <?php
                        echo form_close();
                        ?>

                    </div>
                    <?php
                    $attributes = array("class" => "form-horizontal", "id" => "monitoringForm", "name" => "monitoringForm");
                    echo form_open("", $attributes);
                    //echo form_open("certificate_issuance/certificate_issuance_list", $attributes);


                    ?>

                    <table class="table table-bordered table-striped">

                        <?php
                        //$getMonitoringListByRefID = $monitoring_model->getMonitoringListByRefID($ref_id);
                        //$getCertListByID = $certification_model->getCertListByID($ref_id);
                        //print_r($getCertListByID);
                        echo $certListByID->ref_id;

                        echo "<input type=\"text\" id=\"month_valid\" name=\"month_valid\" class=\"form-control\" value = '".$certListByID->month_valid."' placeholder=\"month_valid\" />";
                        echo "<input type=\"text\" id=\"day_valid\" name=\"day_valid\" class=\"form-control\" value = '".$certListByID->day_valid."' placeholder=\"day_valid\" />";
                        echo "<input type=\"text\" id=\"year_valid\" name=\"year_valid\" class=\"form-control\" value = '".$certListByID->year_valid."' placeholder=\"year_valid\" />";

                        echo "<tr>";
                        echo "<td align=\"center\"><b>Certificate No</b></td>";
                        echo "<td align=\"center\">";
                        echo " <input type=\"text\" id=\"certificate_no\" name=\"certificate_no\" class=\"form-control\" value = '".$certListByID->certificate_no."' placeholder = 'Enter Visit Date' />";
                        echo "</b></td>";

                        echo "<tr>";
                        echo "<td align=\"center\"><b>Visit Date</b></td>";
                        echo "<td align=\"center\">";
                        echo " <input type=\"text\" id=\"date_issued\" name=\"date_issued\" onchange=\"dateIssued()\" class=\"form-control\" value = '".$certListByID->date_issued."' placeholder = 'Enter Date Issued' />";
                        echo "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td align=\"center\"><b>Validity In years</b></td>";
                        // echo "<td align=\"center\"><b>".$valCert['validity']."</b></td>";
                        echo "<td align=\"center\">";
                        echo "<select id = 'validity' name = 'validity' onchange='validityDate()' class=\"form-control\">";

                        $getValidity = $validity_model->getValidity();
                        foreach ($getValidity as $key=>$val)
                        {
                            //echo $val['validity_id'];
                            echo $val['validity_title'];

                            echo "<option id='".$val['validity_id']."' value='".$val['validity_id']."'";
                            // echo ">";

                            if($certListByID->validity == $val['validity_id'])
                            {
                                echo " selected = selected";
                                echo ">";
                                echo $val['validity_title'];

                            }else
                            {
                                echo " ";
                                echo ">";
                                echo $val['validity_title'];

                            }

                            echo "</option>";

                        }
                        echo "</select>";


                        /*foreach ($getCertListByID as $keyCert => $valCert)
                        {

                           // date Valid-->
                            echo "<input type=\"text\" id=\"month_valid\" name=\"month_valid\" class=\"form-control\" value = '".$valCert['month_valid']."' placeholder=\"month_valid\" />";
                            echo "<input type=\"text\" id=\"day_valid\" name=\"day_valid\" class=\"form-control\" value = '".$valCert['day_valid']."' placeholder=\"day_valid\" />";
                            echo "<input type=\"text\" id=\"year_valid\" name=\"year_valid\" class=\"form-control\" value = '".$valCert['year_valid']."' placeholder=\"year_valid\" />";
                        // date Valid-->

                            echo "<tr>";
                            echo "<td align=\"center\"><b>Certificate No</b></td>";
                            echo "<td align=\"center\">";
                            echo " <input type=\"text\" id=\"certificate_no\" name=\"certificate_no\" class=\"form-control\" value = '".$valCert['certificate_no']."' placeholder = 'Enter Visit Date' />";
                            echo "</b></td>";

                            //date_issued
                            echo "<tr>";
                            echo "<td align=\"center\"><b>Visit Date</b></td>";
                            echo "<td align=\"center\">";
                            echo " <input type=\"text\" id=\"date_issued\" name=\"date_issued\" onchange=\"dateIssued()\" class=\"form-control\" value = '".$valCert['date_issued']."' placeholder = 'Enter Date Issued' />";
                            echo "</td>";
                            echo "</tr>";


                            //visit_count

                            echo "<tr>";
                            echo "<td align=\"center\"><b>Validity In years</b></td>";
                           // echo "<td align=\"center\"><b>".$valCert['validity']."</b></td>";
                            echo "<td align=\"center\">";
                            echo "<select id = 'validity' name = 'validity' onchange='validityDate()' class=\"form-control\">";

                            $getValidity = $validity_model->getValidity();
                            foreach ($getValidity as $key=>$val)
                            {
                                //echo $val['validity_id'];
                                echo $val['validity_title'];

                                echo "<option id='".$val['validity_id']."' value='".$val['validity_id']."'";
                               // echo ">";

                               if($valCert['validity'] == $val['validity_id'])
                               {
                                   echo " selected = selected";
                                   echo ">";
                                   echo $val['validity_title'];

                               }else
                               {
                                   echo " ";
                                   echo ">";
                                   echo $val['validity_title'];

                               }

                               echo "</option>";

                            }
                            echo "</select>";
                            echo "</td>";
                            echo "</tr>";


                        }//end of $getMonitoringListByRefID*/

                        $certificate_no = $this->input->post('certificate_no');
                        $current_certificate = '0';
                        //date
                        $strIssuedDate = $this->input->post('date_issued');
                        $issuedDateToDate = date_create($strIssuedDate);
                        $date_issued = date_format($issuedDateToDate, "Y-m-d");
                        //date

                        $validity = $this->input->post('validity');
                        $month_valid = $this->input->post('month_valid');
                        $day_valid = $this->input->post('day_valid');
                        $year_valid = $this->input->post('year_valid');
                        $DELETED = '0';
                        $modified_by = 104;
                        $profile_id = '9';

                        //echo "Month Valid=>".$month_valid;

                        $sql ='Update tbl_lswdo_certificate SET
					profile_id = "'.$profile_id.'",
					certificate_no = "'.$certificate_no.'",
					current_certificate = "'.$current_certificate.'",
					date_issued = "'.$date_issued.'",
					validity = "'.$validity.'",
					month_valid = "'.$month_valid.'",
					day_valid = "'.$day_valid.'",
					year_valid = "'.$year_valid.'",
					modified_by = "'.$modified_by.'",
					date_modified = now(),
					DELETED = "'.$DELETED.'"
					WHERE
					ref_id = "'.$ref_id.'"
				    ';
                         echo $sql;


                        ?>

                        </tr>

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
