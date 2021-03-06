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
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active">Assessment Information</li>
            <li class="active">Indicators</li>
            <li class="active">Monitoring</li>
            <li class="active">Certification</li>
            <li class="active">Add</li>
        </ol>
    </div>
    <!-- End Page Header -->

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    Certification Details
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: block;">

                    <?php
                        $attributes = array("class" => "form-horizontal", "id" => "certificate_issuanceForm", "name" => "certificate_issuanceForm");
                        echo form_open("certificate_issuance/certificate_issuance_add", $attributes);


                        //profile_id
                       // $profile_id = $getDataByProfileID->profile_id;
                        $profile_id = $this->uri->segment('3');
                        echo "<input type=\"hidden\" id=\"profile_id\" name=\"profile_id\" class=\"form-control\" value ='".$profile_id."'/>";
                    ?>
                    <div class="btn-group">

                        <?php

                        echo "<a id ='btn_addCert' class='btn btn-lrg btn-primary' href= '../certificate_issuance_list/$profile_id'> Back to List </a>";

                        ?>

                    </div>

                        <!-- date Valid-->
                        <input type="hidden" id="month_valid" name="month_valid" class="form-control" placeholder="month_valid" />
                        <input type="hidden" id="day_valid" name="day_valid" class="form-control" placeholder="day_valid" />
                        <input type="hidden" id="year_valid" name="year_valid" class="form-control" placeholder="year_valid" />
                        <!-- date Valid-->

                    <h4>Certification Details</h4>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td align="center"><b>Certification No</b></td>
                            <td><b>
                                    <?php
                                        echo "<input type='text' id='txtCertNo' name = 'txtCertNo' class=\"form-control\" placeholder = 'Enter Certificate Number'/>";
                                    ?>
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



                    <?php
                    //$profile_id ='9';
                    //$visit_count = $this->input->post('visit_count');
                    ////date
                    //$strVisitDate = $this->input->post('visit_date');
                    //$visitDateToDate = date_create($strVisitDate);
                    //$visit_date = date_format($visitDateToDate, "Y-m-d");
                    ////date
                    ////$visit_date = $this->input->post('visitDate');
                    //$remarks = $this->input->post('remarks');
                    //$created_by = '104';
                    //$date_created = 'NOW()';
                    //$modified_by='104';
                    //$date_modified = '0000-00-00';
                    //$deleted='0';


                    //$sql = 'Insert into tbl_lswdo_monitoring(profile_id, visit_count, visit_date,remarks,created_by,date_created,modified_by,date_modified,deleted)
                    //      VALUES(
                    //      "'.$profile_id.'",
                    //      "'.$visit_count.'",
                    //      "'.$visit_date.'",
                    //      "'.$remarks.'",
                    //      "'.$created_by.'",
                    //      '.$date_created.',
                    //      "'.$modified_by.'",
                    //      "'.$date_modified.'",
                    //      "'.$deleted.'"
                    //      )';
//
                    //echo $sql;
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
