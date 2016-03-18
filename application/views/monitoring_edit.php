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
                    MONITORING
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: block;">
                    <div class="btn-group">

                        <?php

                        $ref_id = $this->uri->segment('3'); //$_GET['ref_id']
                        echo "<input id=\"ref_cert_id\" name=\"ref_cert_id\" type=\"text\" value=\"$ref_id\"/>";

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
                        echo form_open("monitoring/monitoring_edit/$ref_id", $attributes);


                    ?>


                    <h4>Certification Details</h4>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td align="center"><b>Certification No</b></td>


                                    <?php
                                    $getCertListByID = $certification_model->getCertListByID($ref_id);
                                    foreach($getCertListByID as $key => $val)
                                    {
                                        echo "<td align=\"center\">";
                                        echo "<input type=\"text\" id=\"certificate_no\" name=\"certificate_no\" class=\"form-control\" value ='".$val['certificate_no']."' >";
                                        echo "</td>";
                                        echo "</tr>";
                                        //echo "<td align=\"center\">";
                                        //date Valid-->
                                        echo "<input type='hidden' id='month_valid' name='month_valid' class='form-control' placeholder='month_valid' value ='".$val['month_valid']."' />";
                                        echo "<input type='hidden' id='day_valid' name='day_valid' class='form-control' placeholder='day_valid' value ='".$val['day_valid']."' />";
                                        echo "<input type='hidden' id='year_valid' name='year_valid' class='form-control' placeholder='year_valid' value ='".$val['year_valid']."' />";

                                        //date Valid-->
                                       // echo "</td>";
                                        echo "<tr>";
                                        echo "<td align=\"center\"><b>Date Issued</b></td>";
                                        echo "<td align=\"center\">";
                                        echo "<input type='text' id='date_issued' name='date_issued' class='form-control' value ='".$val['date_issued']."' onchange ='dateIssued()' />";
                                        echo "</td>";
                                        echo "</tr>";

                                        echo "<tr>";
                                        echo "<td align=\"center\"><b>Validity</b></td>";
                                        echo "<td align=\"center\">";
                                        //echo "<input type='text' id='date_issued' name='date_issued' class='form-control' value ='".$val['date_issued']."' onchange ='dateIssued()' />";
                                        echo "<select name = 'validity' onchange='validityDate()' id='validity' class=\"form-control\">";
                                        foreach ($getValidity as $key=>$val)
                                        {
                                            echo "<option id='".$val['validity_id']."' value='".$val['validity_inyears']."'>";
                                            echo $val['validity_title'];
                                            echo "</option>";
                                        }
                                        echo "</select>";
                                        echo "</td>";
                                        echo "</tr>";

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

                                        echo "Month Valid=>".$month_valid;

                                        $sql ='Update tbl_lswdo_certificate SET
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

                                    }
                                    ?>

                        </tr>

                        <tr>
                            <td align="center"><b>Validity</b></td>
                            <td>
                                <?php
                                //print_r($getVisitCount);
                                echo "<select name = 'validity' onchange='validityDate()' id='validity' class=\"form-control\">";
                                foreach ($getValidity as $key=>$val)
                                {
                                    echo "<option id='".$val['validity_id']."' value='".$val['validity_inyears']."'>";
                                    echo $val['validity_title'];
                                    echo "</option>";
                                }
                                echo "</select>";
                                ?>
                            </td>
                        </tr>

                    </table>


                    <br/></br>
                    <h4>Status of Monitoring/Date</h4>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td><b>Visit Count</b></td>
                            <td align="center">
                            <?php
                                //print_r($getVisitCount);
                                echo "<select id = 'visit_count' name = 'visit_count' class=\"form-control\">";
                                foreach ($getVisitCount as $key=>$val)
                                {
                                    echo "<option id='".$val['visit_id']."' value='".$val['visit_id']."'>";
                                    echo $val['visit_count'];
                                    echo "</option>";
                                }
                                 echo "</select>";
                            ?>
                            </td>
                        </tr>
                        </tr>
                            <td><b>Visit Date</b></td>
                            <td align="center">

                                <input type="text" id="visit_date" name="visit_date" class="form-control" placeholder = 'Enter Visit Date' />
                            </td>
                        </tr>
                        <tr>
                            <td><b>Remarks</b></td>
                            <td>
                                <textarea class="form-control" rows="3" id="remarks" name="remarks" placeholder="Type your message..."></textarea>
                            </td>
                        </tr>

                    </table>


                    <hr>
                    <div class="btn-group">
                        <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Insert" />
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
