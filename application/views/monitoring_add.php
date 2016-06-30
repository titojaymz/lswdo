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
            <li class="active">Add</li>
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
                        $attributes = array("class" => "form-horizontal", "id" => "monitoringForm", "name" => "monitoringForm");
                        //echo form_open("monitoring/monitoring_list", $attributes);
                        echo form_open("assessmentinfo/index/", $attributes);

                        ?>
                                 <input id="btn_back" name="btn_back" type="submit" class="btn btn-primary" value="Back To List"/>
                                 <br/><br/>
                        <?php
                            echo form_close();
                        ?>

                    </div>
                    <?php
                        $profile_id = $this->uri->segment('3');


                        $attributes = array("class" => "form-horizontal", "id" => "monitoringForm", "name" => "monitoringForm");
                        //echo form_open("indicator/indicatorView/$profile_id", $attributes);
                        echo form_open("", $attributes);

                        echo "<input type=\"hidden\" id=\"profile_id\" name=\"profile_id\" class=\"form-control\" value ='".$profile_id."'/>";

                        //echo $this->input->post('profile_id');
                        //profile_id
                        //$profile_id = $getDataByProfileID->profile_id;



                    ?>
                        <!-- date Valid-->
                      <!--  <input type="hidden" id="month_valid" name="month_valid" class="form-control" placeholder="month_valid" />
                        <input type="hidden" id="day_valid" name="day_valid" class="form-control" placeholder="day_valid" />
                        <input type="hidden" id="year_valid" name="year_valid" class="form-control" placeholder="year_valid" />-->
                        <!-- date Valid-->

                   <!-- <h4>Certification Details</h4>
                    <table class="table table-bordered table-striped">
                        <tr>;
                            <td align="center"><b>Certification No</b></td>
                            <td><b>
                                    <?php
/*                                        echo "<input type='text' id='txtCertNo' name = 'txtCertNo' class=\"form-control\" placeholder = 'Enter Certificate Number'/>";
                                    */?>
                            </b></td>
                        </tr>
                        <tr>
                            <td align="center"><b>Date Issued</b></td>
                            <td>
                                <input type="text" id="date_issued" name="date_issued" class="form-control" onchange="dateIssued()" placeholder = 'Please select date' />
                            </td>
                        </tr>
                        <tr>
                            <td align="center"><b>Validity</b></td>
                            <td>
                                <?php
/*                                //print_r($getVisitCount);
                                echo "<select name = 'validity' onchange='validityDate()' id='validity' class=\"form-control\">";
                                foreach ($getValidity as $key=>$val)
                                {
                                    echo "<option id='".$val['validity_id']."' value='".$val['validity_inyears']."'>";
                                    echo $val['validity_title'];
                                    echo "</option>";
                                }
                                echo "</select>";
                                */?>
                            </td>
                        </tr>

                    </table>-->
<!--<pre>-->
<!--    --><?php //print_r($getStatus); ?>
<!--</pre>-->

                    <?php  $visitCount = $countVisits->countVisit; ?>
                    <br/>
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
                        <tr>
                            <td><b>Status:</b></td>
                            <td align="center">
                                <select id = 'visit_status' name = 'visit_status' class="form-control">
                                <option id = '#'>Please Select</option>
                                <?php foreach ($getStatus as $key=>$val)
                                { ?>
                                    <option value='<?php echo $val['status_id']; ?>'
                                    <?php
                                    if($visitCount == 0){
                                        if($val['status_id'] == 1){

                                                $selected = 'selected';
                                                $disabled = '';
                                        } else {
                                            $selected = '';
                                            $disabled = 'disabled';
                                        }
                                    } else {
                                        if($val['status_id'] == 1){

                                            $selected = '';
                                            $disabled = 'disabled';
                                        } else {
                                            $selected = '';
                                            $disabled = '';
                                        }

                                    }
                                        echo $selected.' '.$disabled;
                                    ?>
                                    >
                                    <?php echo $val['status_name']; ?>
                                    </option>
                               <?php  }?>
                                </select>

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

                    <?php
                    $profile_id ='9';
                    $visit_count = $this->input->post('visit_count');
                    //date
                    $strVisitDate = $this->input->post('visit_date');
                    $visitDateToDate = date_create($strVisitDate);
                    $visit_date = date_format($visitDateToDate, "Y-m-d");
                    //date
                    //$visit_date = $this->input->post('visitDate');
                    $remarks = $this->input->post('remarks');
                    $created_by = '104';
                    $date_created = 'NOW()';
                    $modified_by='104';
                    $date_modified = '0000-00-00';
                    $deleted='0';
                    $ref_cert_id = 0;


                    /*$sql = 'Insert into tbl_lswdo_monitoring(profile_id, visit_count, visit_date,remarks,created_by,date_created,modified_by,date_modified,deleted)
                          VALUES(
                          "'.$profile_id.'",
                          "'.$visit_count.'",
                          "'.$visit_date.'",
                          "'.$remarks.'",
                          "'.$created_by.'",
                          '.$date_created.',
                          "'.$modified_by.'",
                          "'.$date_modified.'",
                          "'.$deleted.'"
                          )';*/

                    $sql ='Insert into tbl_lswdo_monitoring(profile_id,ref_cert_id, visit_count, visit_date,remarks,created_by,date_created,modified_by,date_modified,deleted)
                          VALUES(
                          "'.$profile_id.'",
                          "'.$ref_cert_id.'",
                          "'.$visit_count.'",
                          "'.$visit_date.'",
                          "'.$remarks.'",
                          "'.$created_by.'",
                          '.$date_created.',
                          "'.$modified_by.'",
                          "'.$date_modified.'",
                          "'.$deleted.'"
                          )';

                   // echo $sql;
                    ?>


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
